<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminGejalaController extends Controller
{
    public function index(): Response
    {
        $gejalaList = Gejala::orderBy('kode_gejala', 'asc')->get();

        return Inertia::render('Admin/Gejala/Index', [
            'gejalaList' => $gejalaList,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_gejala' => 'required|string|max:20|unique:gejala,kode_gejala',
            'nama_gejala' => 'required|string',
            'jenis_gejala' => 'required|in:utama,tambahan',
            'cf_pakar' => 'required|numeric|min:0|max:1',
        ]);

        Gejala::create($validated);

        return redirect()->back()->with('success', 'Data gejala berhasil ditambahkan.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $gejala = Gejala::findOrFail($id);

        $validated = $request->validate([
            'kode_gejala' => 'required|string|max:20|unique:gejala,kode_gejala,'.$id,
            'nama_gejala' => 'required|string',
            'jenis_gejala' => 'required|in:utama,tambahan',
            'cf_pakar' => 'required|numeric|min:0|max:1',
        ]);

        $gejala->update($validated);

        return redirect()->back()->with('success', 'Data gejala berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $gejala = Gejala::findOrFail($id);
        $gejala->delete();

        return redirect()->back()->with('success', 'Data gejala berhasil dihapus.');
    }
}
