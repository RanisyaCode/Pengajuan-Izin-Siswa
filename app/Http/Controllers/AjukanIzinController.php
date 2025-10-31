<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\IzinSiswa;
use App\Models\AjukanIzin;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AjukanIzinController extends Controller
{
    /**
     * Tampilkan daftar ajukan izin siswa.
     */
    public function index()
    {
        $user = Auth::user(); 

        if ($user->role == 'Admin') {
            $data = [
                'title'           => 'Ajukan Izin Siswa',
                'menuAdminAjukan' => 'active',
                'ajukanizin'      => AjukanIzin::with('user')->latest()->paginate(10),
            ];
        } else {
            $data = [
                'title'           => 'Ajukan Izin Siswa',
                'menuSiswaAjukan' => 'active',
                'ajukanizin'      => AjukanIzin::with('user')
                                        ->where('siswa_id', $user->id)
                                        ->latest()
                                        ->paginate(10),
            ];
        }

        return view('siswa.ajukanizin.ajukan', $data);
    }

    /**
     * Form tambah ajukan izin.
     */
    public function create()
    {
        $user = Auth::user();

        return view('siswa.ajukanizin.ajukan-izin', [
            'title' => 'Tambah Ajukan Izin Siswa',
            'menuSiswaAjukan' => 'active',
            'user' => $user,
        ]);
    }

    /**
     * Simpan data pengajuan izin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa'   => 'required|string|max:255',
            'kelas'        => 'required|string|max:255',
            'tanggal_izin' => 'required|date|after:today', // ✅ ubah dari after_or_equal ke after
            'alasan'       => 'required|string|min:5|max:500',
            'file'         => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'nama_siswa.required'   => 'Nama siswa wajib diisi.',
            'kelas.required'        => 'Kelas wajib diisi.',
            
            'tanggal_izin.required' => 'Tanggal pengajuan izin wajib diisi.',
            'tanggal_izin.date'     => 'Format tanggal izin tidak valid.',
            'tanggal_izin.after'    => 'Tanggal izin tidak boleh hari ini atau sebelumnya.', // ✅ pesan baru
        
            'alasan.required' => 'Alasan wajib diisi.',
            'alasan.min'      => 'Alasan minimal 5 karakter.',
            'alasan.max'      => 'Alasan maksimal 500 karakter.',
        
            'file.required' => 'Bukti harus diunggah.',
            'file.mimes'    => 'Bukti harus berupa file PDF, JPG, JPEG, atau PNG.',
            'file.max'      => 'Ukuran bukti maksimal 2 MB.',
        ]);        

        $user = Auth::user();

        if ($request->nama_siswa !== $user->nama) {
            return redirect()->back()->with('error', 'Nama siswa harus sesuai dengan akun yang login.');
        }

        // Cek izin menunggu di tanggal yang sama
        $cekIzin = AjukanIzin::where('siswa_id', $user->id)
            ->whereDate('tanggal_izin', $request->tanggal_izin)
            ->where('status', 'menunggu')
            ->exists();

        if ($cekIzin) {
            return redirect()->back()->with('error', 'Kamu sudah punya izin yang sedang diproses pada tanggal ini.');
        }

        // Simpan file ke storage
        $namaFile = $request->file('file')->store('uploads', 'public');

        // Simpan ke tabel AjukanIzin
        $izin = AjukanIzin::create([
            'siswa_id'     => $user->id,
            'nama_siswa'   => $user->nama,
            'kelas'        => $request->kelas,
            'tanggal_izin' => $request->tanggal_izin,
            'alasan'       => $request->alasan,
            'file'         => $namaFile,
            'status'       => 'menunggu',
        ]);

        // Simpan juga ke tabel IzinSiswa
        IzinSiswa::create([
            'ajukan_izin_id' => $izin->id,
            'siswa_id'       => $izin->siswa_id,
            'nama_siswa'     => $izin->nama_siswa,
            'kelas'          => $izin->kelas,
            'tanggal_izin'   => $izin->tanggal_izin,
            'alasan'         => $izin->alasan,
            'file'           => $izin->file,
            'status'         => $izin->status,
        ]);        

        return redirect()->route('siswa.ajukan')->with('success', 'Izin berhasil diajukan.');
    }

    /**
     * Tampilkan data izin siswa untuk admin/wali kelas.
     */
    public function indexAdmin(Request $request)
    {
        $izin = AjukanIzin::when($request->nama_siswa, function ($query) use ($request) {
                    $query->where('nama_siswa', 'like', '%' . $request->nama_siswa . '%');
                })
                ->when($request->tanggal, function ($query) use ($request) {
                    $query->whereDate('tanggal_izin', $request->tanggal);
                })
                ->when($request->status, function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->latest()
                ->paginate(10);

        return view('admin.izinsiswa.index', [
            'title' => 'Data Izin Siswa',
            'izin'  => $izin,
            'menuAdminAjukan' => 'active',
        ]);
    }

    /**
     * Update status izin siswa oleh admin/wali.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,disetujui,ditolak',
        ]);

        $izinSiswa = IzinSiswa::findOrFail($id);
        $izinSiswa->status = $request->status;
        $izinSiswa->save();

        // ✅ Sinkronkan status di tabel AjukanIzin
        if ($izinSiswa->ajukanIzin) {
            $izinSiswa->ajukanIzin->update(['status' => $request->status]);
        } 

        return redirect()->back()->with('success', 'Status izin berhasil diperbarui.');
    }

    /**
     * Hapus data izin (hanya dari AjukanIzin, biar IzinSiswa tetap jadi riwayat).
     */
    public function destroy($id)
    {
        $izin = AjukanIzin::findOrFail($id);

        // ✅ Hapus file bukti dari storage jika ada
        if ($izin->file && Storage::disk('public')->exists($izin->file)) {
            Storage::disk('public')->delete($izin->file);
        }

        $izin->delete();

        return redirect()->route('siswa.ajukan')->with('success', 'Data izin dan file bukti berhasil dihapus.');
    }

    /**
     * Edit ajukan izin siswa.
     */
    public function edit($id)
    {
        // Cari data dari tabel AjukanIzin
        $izin = AjukanIzin::with('user')->find($id);

        if (!$izin) {
            return redirect()->route('siswa.ajukan')
                ->with('error', 'Data izin tidak ditemukan atau sudah dihapus.');
        }

        // Pastikan hanya pemilik izin yang bisa edit
        if ($izin->siswa_id !== Auth::id()) {
            return redirect()->route('siswa.ajukan')
                ->with('error', 'Anda tidak memiliki izin untuk mengubah data ini.');
        }

        return view('siswa.ajukanizin.update', [
            'title' => 'Edit Ajukan Izin Siswa',
            'menuSiswaAjukan' => 'active',
            'izin' => $izin,
        ]);
    }

    /**
     * Update ajukan izin siswa.
     */
    public function update(Request $request, $id)
    {
        $izin = AjukanIzin::findOrFail($id);
        $user = Auth::user();

        $izinSiswa = IzinSiswa::where('siswa_id', $izin->siswa_id)
                        ->where('tanggal_izin', $izin->tanggal_izin)
                        ->first();

        if (!$izinSiswa) {
            return redirect()->back()->with('error', 'Tidak bisa mengubah, data Anda sudah dihapus di admin.');
        }

        if ($izin->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Izin sudah diproses, tidak bisa diubah lagi.');
        }

        if ($request->nama_siswa !== $user->nama) {
            return redirect()->back()->with('error', 'Nama siswa harus sesuai dengan akun yang login.');
        }

        $request->validate([
            'tanggal_izin' => 'required|date|after:today',
            'alasan'       => 'required|string|min:5|max:500',
            'file'         => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'tanggal_izin.required' => 'Tanggal izin wajib diisi.',
            'tanggal_izin.date' => 'Format tanggal tidak valid.',
            'tanggal_izin.after' => 'Tanggal izin harus setelah hari ini (tidak bisa izin di hari ini atau sebelumnya).',

            'alasan.required' => 'Alasan wajib diisi.',
            'alasan.min' => 'Alasan minimal 5 karakter.',
            'alasan.max' => 'Alasan maksimal 500 karakter.',

            'file.mimes' => 'Bukti harus berupa file PDF, JPG, JPEG, atau PNG.',
            'file.max' => 'Ukuran bukti maksimal 2 MB.',
        ]);

        // Update file baru jika diunggah
        if ($request->hasFile('file')) {
            if ($izin->file && Storage::disk('public')->exists($izin->file)) {
                Storage::disk('public')->delete($izin->file);
            }
            $namaFile = $request->file('file')->store('uploads', 'public');
            $izin->file = $namaFile;
        }

        // Update data izin
        $izin->tanggal_izin = $request->tanggal_izin;
        $izin->alasan       = $request->alasan;
        $izin->save();

        // Update juga di tabel IzinSiswa
        if ($izinSiswa) {
            $izinSiswa->update([
                'alasan'       => $izin->alasan,
                'file'         => $izin->file,
                'tanggal_izin' => $izin->tanggal_izin,
            ]);
        }

        return redirect()->route('siswa.ajukan')->with('success', 'Izin berhasil diperbarui.');
    }

    /**
     * Export PDF ajukan izin siswa.
     */
    public function exportPdf()
    {
        $ajukanizin = AjukanIzin::where('siswa_id', Auth::id())->get();
        $filename = now()->format('d-m-Y_H.i.s');

        $data = ['ajukanizin' => $ajukanizin];

        $pdf = Pdf::loadView('siswa.ajukanizin.pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('DataAjukanIzin_'.$filename.'.pdf'); 
    }
}