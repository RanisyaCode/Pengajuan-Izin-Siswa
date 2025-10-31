<?php

namespace App\Http\Controllers;

use App\Models\IzinSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahSiswa = User::where('role', 'Siswa')->count();
        $siswaYangAjukan = IzinSiswa::distinct('siswa_id')->count('siswa_id');

        $data = [
            'title'            => 'Dashboard',
            'menuDashboard'    => 'active',
            'jumlahUser'       => User::count(),
            'jumlahAdmin'      => User::where('role', 'Admin')->count(),
            'jumlahSiswa'      => $jumlahSiswa,
            'jumlahMenunggu'   => Auth::user()->role === 'Siswa'
                ? IzinSiswa::where('status', 'menunggu')->where('siswa_id', Auth::id())->count()
                : IzinSiswa::where('status', 'menunggu')->count(),
            'jumlahDisetujui'  => IzinSiswa::where('status', 'disetujui')->count(),
            'jumlahDitolak'    => IzinSiswa::where('status', 'ditolak')->count(),
            'belumMengajukan'  => $jumlahSiswa - $siswaYangAjukan,
        ];

        if (Auth::user()->role === 'Siswa') {
            // include yang soft deleted juga
            $izinTerbaru = IzinSiswa::withTrashed()
                ->where('siswa_id', Auth::id())
                ->latest()
                ->first();

            $riwayatIzin = IzinSiswa::withTrashed()
                ->where('siswa_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();

            $data['izinTerbaru'] = $izinTerbaru;
            $data['riwayatIzin'] = $riwayatIzin;
        } else {
            // tambahan: untuk Admin dan Wali Kelas
            // Tampilkan semua riwayat izin siswa (beserta relasi siswa)
            $riwayatIzin = IzinSiswa::withTrashed()
                ->with('siswa') // pastikan relasi 'siswa' ada di model IzinSiswa
                ->latest()
                ->take(10)
                ->get();

            // 🔹 Tambahan penting agar tampil di dashboard admin
            $data['riwayatIzinAdmin'] = $riwayatIzin;

            $data['riwayatIzin'] = $riwayatIzin;
        }

        return view('dashboard', $data);
    }

    public function hapusRiwayat($id)
    {
        $izin = IzinSiswa::withTrashed()
            ->where('id', $id)
            ->where('siswa_id', Auth::id())
            ->firstOrFail();

        $izin->forceDelete(); // hapus permanen riwayat (karena soft delete udah kepake)
        
        return redirect()->back()->with('success', 'Riwayat izin berhasil dihapus.');
    }

    public function hapusRiwayatAdmin($id)
    {
        $izin = IzinSiswa::withTrashed()->findOrFail($id);
        $izin->forceDelete(); // hapus permanen

        return redirect()->back()->with('success', 'Data izin berhasil dihapus oleh admin.');
    }

}
