<?php

namespace App\Http\Controllers;

use App\Models\Aturan;
use App\Models\Gejala;
use App\Models\Penyakit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminAturanController extends Controller
{
    public function index(): Response
    {
        $aturanList = Aturan::with(['penyakit', 'gejala'])
            ->get();

        $penyakitList = Penyakit::orderBy('kode_penyakit', 'asc')->get();
        $gejalaList = Gejala::orderBy('kode_gejala', 'asc')->get();

        return Inertia::render('Admin/Aturan/Index', [
            'aturanList' => $aturanList,
            'penyakitList' => $penyakitList,
            'gejalaList' => $gejalaList,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'penyakit_id' => 'required|exists:penyakit,id',
            'gejala_id' => 'required|exists:gejala,id',
        ]);

        $exists = Aturan::where('penyakit_id', $request->penyakit_id)
            ->where('gejala_id', $request->gejala_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['penyakit_id' => 'Aturan relasi ini sudah ada.']);
        }

        Aturan::create($validated);

        return redirect()->back()->with('success', 'Rule / Aturan berhasil ditambahkan.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $aturan = Aturan::findOrFail($id);
        $aturan->delete();

        return redirect()->back()->with('success', 'Rule / Aturan berhasil dihapus.');
    }
}
