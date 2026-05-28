<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilToko;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfilTokoController extends Controller
{
    public function edit(): View
    {
        $admin = Auth::guard('admin')->user();
        $profil = ProfilToko::where('id_admin', $admin->id_admin)->first();

        return view('admin.profil-toko.edit', [
            'profil' => $profil,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'kontak' => ['nullable', 'string', 'max:30'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
        ]);

        ProfilToko::updateOrCreate(
            ['id_admin' => $admin->id_admin],
            $validated,
        );

        return redirect()
            ->route('admin.profil-toko.edit')
            ->with('success', 'Profil toko berhasil diperbarui.');
    }
}
