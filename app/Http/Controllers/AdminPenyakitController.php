<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminPenyakitController extends Controller
{
    public function index(): Response
    {
        $penyakitList = Penyakit::orderBy('kode_penyakit', 'asc')->get();

        return Inertia::render('Admin/Penyakit/Index', [
            'penyakitList' => $penyakitList,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_penyakit' => 'required|string|max:20|unique:penyakit,kode_penyakit',
            'nama_penyakit' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'solusi' => 'required|string',
        ]);

        Penyakit::create($validated);

        return redirect()->back()->with('success', 'Data tingkat depresi berhasil ditambahkan.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $penyakit = Penyakit::findOrFail($id);

        $validated = $request->validate([
            'kode_penyakit' => 'required|string|max:20|unique:penyakit,kode_penyakit,'.$id,
            'nama_penyakit' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'solusi' => 'required|string',
        ]);

        $penyakit->update($validated);

        return redirect()->back()->with('success', 'Data tingkat depresi berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $penyakit = Penyakit::findOrFail($id);
        $penyakit->delete();

        return redirect()->back()->with('success', 'Data tingkat depresi berhasil dihapus.');
    }
}
