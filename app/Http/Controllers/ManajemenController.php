<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ManajemenExport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenController extends Controller
{

    public function manajemen(Request $request)
    {
        $query = User::query();

        // Pencarian nama/email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 🏷️ Filter role
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $data = [
            'title' => 'Manajemen User',
            'menuManajemenUser' => 'active',
            'manajemen' => $query->orderBy('role', 'asc')->paginate(10)->appends($request->query())
        ];        

        return view('admin.manajemenuser.manajemen', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Manajemen User',
            'menuManajemenUser' => 'active',
        ];
        return view('admin.manajemenuser.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:users,email',
            'role' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'nama.required' => 'Nama Tidak Boleh Kosong',
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.unique' => 'Email Sudah Ada',
            'role.required' => 'Role Harus Di Pilih',
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.confirmed' => 'Password Konfirmasi Tidak Sama',
            'password.min' => 'Password Minimal 8 Karakter',
        ]);

        $manajemen = new User;
        $manajemen->nama = $request->nama;
        $manajemen->email = $request->email;
        $manajemen->role = $request->role;
        $manajemen->password = Hash::make($request->password);
        $manajemen->save();

        return redirect()->route('manajemenuser.manajemen')->with('success', 'Data Berhasil Di Tambahkan');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Manajemen User',
            'menuManajemenUser' => 'active',
            'manajemen' => User::findOrFail($id),
        ];
        return view('admin.manajemenuser.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'role' => 'required',
            'password' => 'nullable|confirmed|min:8',
        ], [
            'nama.required' => 'Nama Tidak Boleh Kosong',
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.unique' => 'Email Sudah Ada',
            'role.required' => 'Role Harus Di Pilih',
            'password.confirmed' => 'Password Konfirmasi Tidak Sama',
            'password.min' => 'Password Minimal 8 Karakter',
        ]);

        $manajemen = User::findOrFail($id);
        $manajemen->nama = $request->nama;
        $manajemen->email = $request->email;
        $manajemen->role = $request->role;

        if ($request->filled('password')) {
            $manajemen->password = Hash::make($request->password);
        }

        $manajemen->save();

        return redirect()->route('manajemenuser.manajemen')->with('success', 'Data Berhasil Di Edit');
    }

    public function destroy($id)
    {
        $manajemen = User::findOrFail($id);
        $manajemen->delete();

        return redirect()->route('manajemenuser.manajemen')->with('success', 'Data Berhasil Di Hapus');
    }

    public function exportExcel()
    {
        return Excel::download(new ManajemenExport, 'data-manajemen.xlsx');
    }

    public function exportPdf()
    {
        $filename = now()->format('d-m-Y_H.i.s');
        $data = ['manajemen' => User::get()];

        $pdf = Pdf::loadView('admin.manajemenuser.pdf', $data)
            ->setPaper('a4', 'portrait');

        // Stream → tampil di browser dulu, user bisa download dari viewer
        return $pdf->stream('DataManajemenUser_'.$filename.'.pdf'); 
    }


}