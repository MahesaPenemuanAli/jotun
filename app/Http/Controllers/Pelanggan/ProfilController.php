<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        return view('pelanggan.profil', compact('user', 'pelanggan'));
    }

    public function edit(): View
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        return view('pelanggan.edit-profil', compact('user', 'pelanggan'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update(['name' => $validated['name']]);

        if ($user->pelanggan) {
            $user->pelanggan->update([
                'nama_pelanggan' => $validated['name'],
                'no_hp' => $validated['no_hp'],
            ]);
        }

        if (filled($validated['password'] ?? null)) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('pelanggan.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
