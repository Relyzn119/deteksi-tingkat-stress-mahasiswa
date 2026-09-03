<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminLaporanController extends Controller
{
    public function index(Request $request): Response
    {
        $filter = $request->query('hasil');

        $query = Diagnosa::with('user');

        if ($filter) {
            $query->where('hasil_diagnosa', $filter);
        }

        $diagnosaList = $query->orderBy('created_at', 'desc')->get();

        $stats = [
            'tidak' => Diagnosa::where('hasil_diagnosa', 'Tidak Depresi')->count(),
            'ringan' => Diagnosa::where('hasil_diagnosa', 'Depresi Ringan')->count(),
            'sedang' => Diagnosa::where('hasil_diagnosa', 'Depresi Sedang')->count(),
            'berat' => Diagnosa::where('hasil_diagnosa', 'Depresi Berat')->count(),
        ];

        return Inertia::render('Admin/Laporan/Index', [
            'diagnosaList' => $diagnosaList,
            'stats' => $stats,
            'selectedFilter' => $filter,
        ]);
    }

    public function print(Request $request): Response
    {
        $filter = $request->query('hasil');

        $query = Diagnosa::with('user');

        if ($filter) {
            $query->where('hasil_diagnosa', $filter);
        }

        $diagnosaList = $query->orderBy('created_at', 'desc')->get();

        $stats = [
            'tidak' => Diagnosa::where('hasil_diagnosa', 'Tidak Depresi')->count(),
            'ringan' => Diagnosa::where('hasil_diagnosa', 'Depresi Ringan')->count(),
            'sedang' => Diagnosa::where('hasil_diagnosa', 'Depresi Sedang')->count(),
            'berat' => Diagnosa::where('hasil_diagnosa', 'Depresi Berat')->count(),
        ];

        return Inertia::render('Admin/Laporan/CetakLaporan', [
            'diagnosaList' => $diagnosaList,
            'stats' => $stats,
            'selectedFilter' => $filter,
        ]);
    }
}
