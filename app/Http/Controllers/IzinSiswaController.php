<?php

namespace App\Http\Controllers;

use App\Models\IzinSiswa;
use App\Models\AjukanIzin;
use Illuminate\Http\Request;
use App\Exports\DataIzinExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class IzinSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = IzinSiswa::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_izin', $request->tanggal);
        }

        if ($request->filled('nama')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($sub) use ($request) {
                    $sub->where('nama', 'like', '%' . $request->nama . '%');
                })
                ->orWhere('nama_siswa', 'like', '%' . $request->nama . '%');
            });
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', 'like', '%' . $request->kelas . '%');
        }

        $izin = $query->latest()->paginate(10);

        return view('admin.izinsiswa.index', [
            'izin' => $izin,
            'title' => 'Data Izin Siswa',
            'menuDataIzinSiswa' => 'active',
        ]);
    }

    public function create()
    {
        return view('siswa.ajukan-izin', [
            'title' => 'Ajukan Izin Siswa'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string|max:50',
            'tanggal_izin' => 'required|date',
            'alasan' => 'required|string|max:255',
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = Auth::user();

        $cekIzin = IzinSiswa::where('siswa_id', $user->id)
            ->whereDate('tanggal_izin', $request->tanggal_izin)
            ->exists();

        $cekAjukan = AjukanIzin::where('siswa_id', $user->id)
            ->whereDate('tanggal_izin', $request->tanggal_izin)
            ->exists();

        if ($cekIzin || $cekAjukan) {
            return redirect()->back()->with('error', 'Kamu sudah mengajukan izin di tanggal ini.');
        }

        $namaFile = null;
        if ($request->hasFile('file')) {
            $namaSiswa = str_replace(' ', '_', strtolower($user->nama));
            $kelas = str_replace([' ', '(', ')'], '_', strtolower($request->kelas));
            $ext = $request->file('file')->getClientOriginalExtension();
            $namaFile = "buktiizin_{$namaSiswa}_({$kelas}).{$ext}";
            $request->file('file')->storeAs('bukti_izin', $namaFile, 'public');
        }

        $ajukan = AjukanIzin::create([
            'siswa_id'     => $user->id,
            'nama_siswa'   => $user->nama,
            'kelas'        => $request->kelas,
            'tanggal_izin' => $request->tanggal_izin,
            'alasan'       => $request->alasan,
            'file'         => $namaFile,
            'status'       => 'menunggu',
        ]);

        IzinSiswa::create([
            'siswa_id'        => $user->id,
            'nama_siswa'      => $user->nama,
            'kelas'           => $request->kelas,
            'tanggal_izin'    => $request->tanggal_izin,
            'alasan'          => $request->alasan,
            'file'            => $namaFile,
            'status'          => 'menunggu',
            'ajukan_izin_id'  => $ajukan->id,
        ]);

        return redirect()->route('izinsiswa')->with('success', 'Pengajuan izin berhasil dibuat.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,disetujui,ditolak',
        ]);

        $izin = IzinSiswa::findOrFail($id);

        $izin->status = $request->status;
        $izin->save();

        if ($izin->ajukanIzin) {
            $izin->ajukanIzin->status = $request->status;
            $izin->ajukanIzin->save();
        }

        return redirect()->back()->with('success', 'Status izin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $izin = IzinSiswa::findOrFail($id);

        if ($izin->file && Storage::disk('public')->exists('bukti_izin/' . $izin->file)) {
            Storage::disk('public')->delete('bukti_izin/' . $izin->file);
        }

        if ($izin->ajukanIzin) {
            $izin->ajukanIzin->delete();
        }

        $izin->delete();

        return redirect()->route('izinsiswa')->with('success', 'Data izin dan file bukti berhasil dihapus.');
    }

    public function download($id)
    {
        $izin = IzinSiswa::findOrFail($id);

        if (!$izin->file) {
            return back()->with('error', 'File bukti tidak tersedia.');
        }

        $filePath = storage_path('app/public/bukti_izin/' . $izin->file);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File bukti tidak ditemukan di server.');
        }

        $namaSiswa = str_replace(' ', '_', strtolower($izin->nama_siswa));
        $kelas = str_replace([' ', '(', ')'], '_', strtolower($izin->kelas));
        $ext = pathinfo($izin->file, PATHINFO_EXTENSION);
        $downloadName = "buktiizin_{$namaSiswa}_({$kelas}).{$ext}";

        return response()->download($filePath, $downloadName, [
            'Content-Type' => mime_content_type($filePath),
        ]);
    }

    public function exportExcel()
    {
        $filename = now()->format('d-m-Y_H.i.s');
        return Excel::download(new DataIzinExport, 'DataIzinSiswa_'.$filename.'.xls');
    }

    public function exportPdf()
    {
        $filename = now()->format('d-m-Y_H.i.s');
        $data = ['izinsiswa' => IzinSiswa::get()];

        $pdf = Pdf::loadView('admin.izinsiswa.pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->stream('DataIzinSiswa_'.$filename.'.pdf'); 
    }

    public function updateCatatan(Request $request, $id)
    {
        try {
            $izin = IzinSiswa::findOrFail($id);

            $request->validate([
                'catatan' => 'nullable|string|max:255',
            ]);

            $izin->catatan = $request->catatan;
            $izin->save();

            if ($izin->ajukanIzin) {
                $izin->ajukanIzin->catatan = $request->catatan;
                $izin->ajukanIzin->save();
            }

            return redirect()->back()->with('success', 'Catatan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui catatan.');
        }
    }
}