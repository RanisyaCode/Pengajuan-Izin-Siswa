<?php

namespace App\Exports;

use App\Models\IzinSiswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DataIzinExport implements FromView, WithDrawings, WithEvents
{
    protected $data;
    protected $startRow;

    public function __construct()
    {
        $this->data = IzinSiswa::with('user')->get();
        $this->startRow = 5; // baris pertama data
    }

    public function view(): View
    {
        // Kirim data ke Blade, jam tetap dari PHP tapi Blade tidak digunakan untuk jam lagi
        return view('admin.izinsiswa.excel', [
            'IzinSiswa' => $this->data,
            'tanggal'   => now()->format('d-m-Y'),
            'jam'       => now()->format('H:i:s'),
        ]);
    }

    public function drawings()
    {
        $drawings = [];
        foreach ($this->data as $i => $izin) {
            if ($izin->file && file_exists(public_path('storage/' . $izin->file))) {
                $ext = strtolower(pathinfo($izin->file, PATHINFO_EXTENSION));

                if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                    $drawing = new Drawing();
                    $drawing->setPath(public_path('storage/' . $izin->file));
                    $drawing->setHeight(105); // ukuran gambar proporsional
                    $drawing->setCoordinates('H' . ($this->startRow + $i));
                    $drawing->setOffsetX(10);
                    $drawing->setOffsetY(5);
                    $drawings[] = $drawing;
                }
            }
        }
        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Lebar kolom
                $columns = ['A'=>6,'B'=>20,'C'=>15,'D'=>25,'E'=>18,'F'=>30,'G'=>15,'H'=>25];
                foreach($columns as $col => $width){
                    $event->sheet->getColumnDimension($col)->setWidth($width);
                }

                // Tinggi baris + alignment + badge warna
                foreach ($this->data as $i => $izin) {
                    $row = $this->startRow + $i;
                    $ext = strtolower(pathinfo($izin->file, PATHINFO_EXTENSION));

                    $event->sheet->getRowDimension($row)->setRowHeight(
                        in_array($ext, ['jpg','jpeg','png','gif','webp']) ? 90 : 30
                    );

                    $event->sheet->getStyle("A{$row}:H{$row}")
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                        ->setVertical(Alignment::VERTICAL_CENTER)
                        ->setWrapText(true);

                    // Badge warna pastel
                    $statusCell = "G{$row}";
                    $status = strtolower($izin->status ?? '');
                    $color = match($status) {
                        'approved', 'disetujui' => 'A8D5BA',
                        'pending' => 'FDE2B6',
                        'rejected', 'ditolak' => 'F5A8A8',
                        default => 'D3D3D3',
                    };
                    $event->sheet->getStyle($statusCell)->applyFromArray([
                        'font' => ['bold' => true,'color' => ['rgb'=>'000000']],
                        'fill' => ['fillType'=>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                   'startColor'=>['rgb'=>$color]],
                        'alignment'=>[
                            'horizontal'=>Alignment::HORIZONTAL_CENTER,
                            'vertical'=>Alignment::VERTICAL_CENTER,
                        ],
                    ]);
                }

                // Header biru pastel
                $headerStyle = [
                    'font' => ['bold'=>true,'color'=>['rgb'=>'FFFFFF'],'size'=>11],
                    'fill' => ['fillType'=>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                               'startColor'=>['rgb'=>'7DA6F7']],
                    'alignment'=>['horizontal'=>Alignment::HORIZONTAL_CENTER,'vertical'=>Alignment::VERTICAL_CENTER]
                ];
                $event->sheet->getStyle("A4:H4")->applyFromArray($headerStyle);

                // Center header baris 1-4
                $event->sheet->getStyle("A1:H4")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Border tabel pastel
                $lastRow = $this->startRow + count($this->data) - 1;
                $event->sheet->getStyle("A4:H{$lastRow}")->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
                    ->getColor()->setRGB('DADADA');

                // Shading ganjil-genap
                for ($r = $this->startRow; $r <= $lastRow; $r++) {
                    $fillColor = ($r % 2 == 0) ? 'F7F7F7' : 'FFFFFF';
                    $event->sheet->getStyle("A{$r}:H{$r}")->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setRGB($fillColor);
                }
            }
        ];
    }
}
