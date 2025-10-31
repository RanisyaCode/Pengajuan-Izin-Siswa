<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\User; 

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $title = "My Profile";
        return view('profile.edit', compact('user', 'profile', 'title'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $title = "Edit Profile";
        return view('profile.edit', compact('user', 'profile', 'title'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */  // ✅ kasih tahu Intelephense bahwa ini model User
        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'password' => 'nullable|confirmed|min:6',
        ]);

        // Update nama di tabel profiles
        $profile->nama = $request->nama;

        // Update foto profil jika ada
        if ($request->hasFile('profile_photo')) {
            if ($profile->profile_photo && Storage::disk('public')->exists('profile_photos/'.$profile->profile_photo)) {
                Storage::disk('public')->delete('profile_photos/'.$profile->profile_photo);
            }

            $file = $request->file('profile_photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('profile_photos', $filename, 'public');

            $profile->profile_photo = $filename;
        }

        $profile->save();

        // Update email & password di tabel users
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save(); 

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function deletePhoto(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
    
        if ($profile && $profile->profile_photo) {
            if (Storage::disk('public')->exists('profile_photos/' . $profile->profile_photo)) {
                Storage::disk('public')->delete('profile_photos/' . $profile->profile_photo);
            }
            $profile->profile_photo = null;
            $profile->save();
        }

        return redirect()->route('profile.edit')->with('photo_deleted', true);
    }
}
