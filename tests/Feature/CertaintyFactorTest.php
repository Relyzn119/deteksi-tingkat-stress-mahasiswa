<?php

use App\Models\Gejala;
use App\Services\CertaintyFactorService;
use Database\Seeders\SistemPakarSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(SistemPakarSeeder::class);
    $this->cfService = new CertaintyFactorService;
});

test('it correctly calculates certainty factor combine and percentage', function () {
    $g1 = Gejala::where('kode_gejala', 'G01')->first(); // Utama, CF Pakar: 0.8
    $g2 = Gejala::where('kode_gejala', 'G02')->first(); // Utama, CF Pakar: 0.8
    $g4 = Gejala::where('kode_gejala', 'G04')->first(); // Tambahan, CF Pakar: 0.6
    $g5 = Gejala::where('kode_gejala', 'G05')->first(); // Tambahan, CF Pakar: 0.6

    // User chooses: G01=1.0, G02=0.8, G04=0.6, G05=0.4
    // CF1 = 1.0 * 0.8 = 0.8
    // CF2 = 0.8 * 0.8 = 0.64 -> Combine = 0.8 + (0.64 * (1 - 0.8)) = 0.8 + 0.128 = 0.928
    // CF3 = 0.6 * 0.6 = 0.36 -> Combine = 0.928 + (0.36 * (1 - 0.928)) = 0.928 + 0.02592 = 0.95392
    // CF4 = 0.4 * 0.6 = 0.24 -> Combine = 0.95392 + (0.24 * (1 - 0.95392)) = 0.95392 + 0.0110592 = 0.9649792 (96.5%)

    $answers = [
        $g1->id => 1.0,
        $g2->id => 0.8,
        $g4->id => 0.6,
        $g5->id => 0.4,
    ];

    $result = $this->cfService->calculate($answers);

    expect($result['jumlah_utama'])->toBe(2);
    expect($result['jumlah_tambahan'])->toBe(2);
    expect($result['hasil_diagnosa'])->toBe('Depresi Ringan');
    expect($result['persentase'])->toBeGreaterThan(90.0);
    expect(count($result['details']))->toBe(4);
});

test('it correctly determines Depresi Berat rule', function () {
    // 3 Gejala Utama + 4 Gejala Tambahan
    $level = $this->cfService->determineDepressionLevel(3, 4);
    expect($level)->toBe('Depresi Berat');
});

test('it correctly determines Depresi Sedang rule', function () {
    // 2 Gejala Utama + 3 Gejala Tambahan
    $level1 = $this->cfService->determineDepressionLevel(2, 3);
    expect($level1)->toBe('Depresi Sedang');

    // 3 Gejala Utama + 2 Gejala Tambahan
    $level2 = $this->cfService->determineDepressionLevel(3, 2);
    expect($level2)->toBe('Depresi Sedang');
});

test('it correctly determines Depresi Ringan rule', function () {
    // 2 Gejala Utama + 2 Gejala Tambahan
    $level = $this->cfService->determineDepressionLevel(2, 2);
    expect($level)->toBe('Depresi Ringan');
});

test('it correctly determines Tidak Depresi rule', function () {
    // 1 Gejala Utama + 1 Gejala Tambahan
    $level = $this->cfService->determineDepressionLevel(1, 1);
    expect($level)->toBe('Tidak Depresi');
});

test('it throws exception when no valid symptom is selected', function () {
    $g1 = Gejala::first();
    $answers = [
        $g1->id => 0, // "Tidak"
    ];

    $this->cfService->calculate($answers);
})->throws(InvalidArgumentException::class);
