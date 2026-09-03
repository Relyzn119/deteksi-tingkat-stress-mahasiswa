<?php

namespace App\Http\Controllers;

use App\Models\Aturan;
use App\Models\Diagnosa;
use App\Models\Gejala;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function index(): Response
    {
        $totalUser = User::where('role', 'user')->count();
        $totalGejala = Gejala::count();
        $totalRule = Aturan::count();
        $totalDiagnosa = Diagnosa::count();

        $chartData = [
            'tidak' => Diagnosa::where('hasil_diagnosa', 'Tidak Depresi')->count(),
            'ringan' => Diagnosa::where('hasil_diagnosa', 'Depresi Ringan')->count(),
            'sedang' => Diagnosa::where('hasil_diagnosa', 'Depresi Sedang')->count(),
            'berat' => Diagnosa::where('hasil_diagnosa', 'Depresi Berat')->count(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'totalUser' => $totalUser,
            'totalGejala' => $totalGejala,
            'totalRule' => $totalRule,
            'totalDiagnosa' => $totalDiagnosa,
            'chartData' => $chartData,
        ]);
    }
}
