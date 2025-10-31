<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CatatanKalender;

class KalenderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Set menu aktif
        $menuKalenderAdmin = 'active';
        $menuKalenderSiswa = 'active';

        // Ambil data sesuai role
        if ($user && $user->role === 'admin') {
            $catatan = CatatanKalender::select('id', 'tanggal', 'catatan', 'kategori', 'user_id', 'role')->get();
            $baseUrl   = route('admin.kalender.store');
            $updateUrl = route('admin.kalender.update', ':id');
            $deleteUrl = route('admin.kalender.destroy', ':id');
        } else {
            $catatan = CatatanKalender::select('id', 'tanggal', 'catatan', 'kategori', 'user_id', 'role')
                        ->where('user_id', $user->id ?? null)
                        ->get();
            $baseUrl   = route('siswa.kalender.store');
            $updateUrl = route('siswa.kalender.update', ':id');
            $deleteUrl = route('siswa.kalender.destroy', ':id');
        }        

        // 🧠 Map data ke format FullCalendar + warna per kategori
        $events = $catatan->map(function ($item) {
            // Tentukan warna berdasarkan kategori
            $color = match ($item->kategori) {
                'Acara Pribadi' => '#4e73df', // biru
                'Acara Sekolah' => '#858796', // abu-abu
                'Penting'       => '#9b59b6', // ungu
                'Acara Lainnya' => '#e74a3b', // merah/pink
                default         => '#4e73df', // fallback biru
            };

            return [
                'id'       => $item->id,
                'title'    => $item->catatan,
                'start'    => $item->tanggal,
                'allDay'   => true,
                'kategori' => $item->kategori ?? 'Acara Pribadi',
                'color'    => $color,
            ];
        });

        return view('admin.calendar.kalender', [
            'title' => 'Kalender',
            'events' => $events,
            'menuKalenderAdmin' => $menuKalenderAdmin,
            'menuKalenderSiswa' => $menuKalenderSiswa,
            'baseUrl' => $baseUrl,
            'updateUrl' => $updateUrl,
            'deleteUrl' => $deleteUrl,
        ]);
    }

    public function storeCatatan(Request $request)
    {
        try {
            $validated = $request->validate([
                'tanggal'  => 'required|date',
                'catatan'  => 'required|string',
                'kategori' => 'nullable|string|max:50',
            ]);

            $user = Auth::user();

            $catatan = CatatanKalender::create([
                'tanggal'  => $validated['tanggal'],
                'catatan'  => $validated['catatan'],
                'kategori' => $validated['kategori'] ?? 'Acara Pribadi',
                'role'     => $user->role ?? 'siswa',
                'user_id'  => $user->id ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Catatan berhasil disimpan!',
                'id' => $catatan->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $query = CatatanKalender::query();

        if ($user && $user->role === 'siswa') {
            $query->where('user_id', $user->id);
        }

        $catatan = $query->findOrFail($id); // bukan firstOrFail()

        $catatan->update([
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'kategori' => $request->kategori,
        ]);

        return response()->json($catatan);
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $query = CatatanKalender::where('id', $id);
        if ($user && $user->role === 'siswa') {
            $query->where('user_id', $user->id);
        }

        $catatan = $query->firstOrFail();
        $catatan->delete();

        return response()->json(['message' => 'Berhasil dihapus!']);
    }
}
