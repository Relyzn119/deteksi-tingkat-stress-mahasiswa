<?php

namespace App\Http\Controllers;

use App\Models\DetailDiagnosa;
use App\Models\Diagnosa;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Services\CertaintyFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DiagnosaController extends Controller
{
    /**
     * Show diagnosis questionnaire.
     */
    public function create(): Response|RedirectResponse
    {
        $user = Auth::user();

        // Check if student profile is complete
        if (empty($user->jk) || empty($user->umur) || empty($user->prodi) || empty($user->semester)) {
            return redirect()->route('user.profile')->with('warning', 'Silakan lengkapi profil terlebih dahulu sebelum melakukan diagnosa.');
        }

        // Check if user already has a diagnosis
        $latestDiagnosa = Diagnosa::where('user_id', $user->id)->latest()->first();

        $gejalaList = Gejala::orderBy('kode_gejala', 'asc')->get();

        return Inertia::render('User/Diagnosa', [
            'gejalaList' => $gejalaList,
            'existingDiagnosaId' => $latestDiagnosa?->id,
        ]);
    }

    /**
     * Store diagnosis response and calculate CF.
     */
    public function store(Request $request, CertaintyFactorService $cfService): RedirectResponse
    {
        $request->validate([
            'gejala' => 'required|array',
            'gejala.*' => 'required|numeric|min:0|max:1',
        ]);

        $user = Auth::user();
        $userAnswers = $request->input('gejala');

        try {
            $calculation = $cfService->calculate($userAnswers);
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->withErrors(['gejala' => $e->getMessage()]);
        }

        // Create Diagnosa record
        $diagnosa = Diagnosa::create([
            'user_id' => $user->id,
            'jumlah_utama' => $calculation['jumlah_utama'],
            'jumlah_tambahan' => $calculation['jumlah_tambahan'],
            'hasil_cf' => $calculation['cf_combine'],
            'persentase' => $calculation['persentase'],
            'hasil_diagnosa' => $calculation['hasil_diagnosa'],
            'tanggal' => now(),
        ]);

        // Create DetailDiagnosa records
        foreach ($calculation['details'] as $detail) {
            DetailDiagnosa::create([
                'diagnosa_id' => $diagnosa->id,
                'gejala_id' => $detail['gejala_id'],
                'cf_user' => $detail['cf_user'],
                'cf_hasil' => $detail['cf_hasil'],
            ]);
        }

        return redirect()->route('diagnosa.show', $diagnosa->id)->with('success', 'Diagnosa berhasil diproses!');
    }

    /**
     * Show diagnosis result.
     */
    public function show(int $id): Response|RedirectResponse
    {
        $user = Auth::user();

        $diagnosa = Diagnosa::with(['detailDiagnosa.gejala'])
            ->where('id', $id)
            ->firstOrFail();

        // Check ownership unless admin
        if ($diagnosa->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403);
        }

        $penyakit = Penyakit::where('nama_penyakit', $diagnosa->hasil_diagnosa)->first();

        return Inertia::render('User/Hasil', [
            'diagnosa' => $diagnosa,
            'penyakit' => $penyakit,
            'student' => $diagnosa->user,
        ]);
    }

    /**
     * Show printable diagnosis page.
     */
    public function print(int $id): Response
    {
        $user = Auth::user();

        $diagnosa = Diagnosa::with(['detailDiagnosa.gejala', 'user'])
            ->where('id', $id)
            ->firstOrFail();

        if ($diagnosa->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403);
        }

        $penyakit = Penyakit::where('nama_penyakit', $diagnosa->hasil_diagnosa)->first();

        return Inertia::render('User/CetakHasil', [
            'diagnosa' => $diagnosa,
            'penyakit' => $penyakit,
            'student' => $diagnosa->user,
        ]);
    }

    /**
     * Show student's diagnosis history.
     */
    public function history(): Response
    {
        $user = Auth::user();

        $history = Diagnosa::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('User/Riwayat', [
            'history' => $history,
        ]);
    }

    /**
     * Delete a diagnosis record from history.
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = Auth::user();

        $diagnosa = Diagnosa::where('id', $id)->firstOrFail();

        if ($diagnosa->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403);
        }

        $diagnosa->delete();

        return redirect()->back()->with('success', 'Riwayat diagnosa berhasil dihapus.');
    }
}
