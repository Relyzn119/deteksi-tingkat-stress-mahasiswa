<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class UserProfileController extends Controller
{
    /**
     * Show student profile form.
     */
    public function show(Request $request): Response
    {
        return Inertia::render('User/Profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update student profile info.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nim' => 'required|string|max:50|unique:users,nim,'.$user->id,
            'name' => 'required|string|max:255',
            'jk' => 'required|in:Laki-laki,Perempuan',
            'umur' => 'required|integer|min:15|max:80',
            'prodi' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:14',
        ]);

        $user->update($validated);

        return redirect()->route('diagnosa.create')->with('message', 'Profil berhasil disimpan! Silakan lanjutkan diagnosa.');
    }
}
