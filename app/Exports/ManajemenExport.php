<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;

class ManajemenExport implements FromView, WithEvents, WithCustomStartCell
{
    public function view(): View
    {
        return view('admin.manajemenuser.excel', [
            'manajemen' => User::all()
        ]);
    }

    public function startCell(): string
    {
        return 'A5'; // Tabel mulai di baris 5
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Atur timezone Indonesia (WIB)
                $waktuWIB = Carbon::now(new CarbonTimeZone('Asia/Jakarta'));

                // Baris 1: Judul Besar
                $sheet->mergeCells('A1:D1');
                $sheet->setCellValue('A1', 'Data Manajemen User');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Baris 2: Dicetak pada
                $sheet->mergeCells('A2:D2');
                $sheet->setCellValue('A2', 'Dicetak pada:');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Baris 3: Tanggal
                $sheet->mergeCells('A3:D3');
                $sheet->setCellValue('A3', 'Tanggal: ' . $waktuWIB->format('d-m-Y'));
                $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Baris 4: Pukul
                $sheet->mergeCells('A4:D4');
                $sheet->setCellValue('A4', 'Pukul: ' . $waktuWIB->format('H:i:s'));
                $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Heading tabel (baris 5)
                $sheet->getStyle('A5:D5')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFB0C4DE'], // pastel light blue
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Data mulai baris 6
                $lastRow = 5 + User::count();
                $sheet->getStyle("A6:D$lastRow")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Rata tengah kolom No dan Role
                $sheet->getStyle("A6:A$lastRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("D6:D$lastRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Auto-size kolom
                foreach (range('A', 'D') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Warna background kolom Email pastel cyan
                $sheet->getStyle("C6:C$lastRow")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFB2EBF2'], // pastel cyan
                    ],
                ]);

                // Warna background kolom Role sesuai value
                for ($row = 6; $row <= $lastRow; $row++) {
                    $role = strtolower($sheet->getCell("D$row")->getValue());
                    if ($role === 'admin') {
                        $sheet->getStyle("D$row")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD6C1FF'); // pastel ungu
                    } else {
                        $sheet->getStyle("D$row")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFBFFCC6'); // pastel green
                    }
                }
            },
        ];
    }
}
