<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'position' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini telah digunakan oleh pengguna lain.',
            'current_password.required_with' => 'Password saat ini wajib diisi untuk mengubah password baru.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah.']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->position = $validated['position'] ?? null;
        $user->phone = $validated['phone'] ?? null;
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
