<?php

namespace App\Services;

use App\Models\Gejala;
use InvalidArgumentException;

class CertaintyFactorService
{
    /**
     * Calculate Certainty Factor (CF) and determine depression level based on PPDGJ-III rules.
     *
     * @param  array<int, float|string>  $userAnswers  Array mapping gejala_id => cf_user
     * @return array{
     *     jumlah_utama: int,
     *     jumlah_tambahan: int,
     *     cf_combine: float,
     *     persentase: float,
     *     hasil_diagnosa: string,
     *     details: array<int, array{gejala_id: int, cf_user: float, cf_hasil: float}>
     * }
     */
    public function calculate(array $userAnswers): array
    {
        $cfCombine = 0.0;
        $jumlahUtama = 0;
        $jumlahTambahan = 0;
        $details = [];

        foreach ($userAnswers as $gejalaId => $cfUserVal) {
            $cfUser = (float) $cfUserVal;

            // Skip if user selects "Tidak" / <= 0
            if ($cfUser <= 0) {
                continue;
            }

            $gejala = Gejala::find($gejalaId);
            if (! $gejala) {
                continue;
            }

            $cfPakar = (float) $gejala->cf_pakar;

            // CF(H,E) = CF User * CF Pakar
            $cf = $cfUser * $cfPakar;

            // CF Combine calculation
            if ($cfCombine == 0.0) {
                $cfCombine = $cf;
            } else {
                $cfCombine = $cfCombine + ($cf * (1.0 - $cfCombine));
            }

            // Count symptom types
            if ($gejala->jenis_gejala === 'utama') {
                $jumlahUtama++;
            } else {
                $jumlahTambahan++;
            }

            $details[] = [
                'gejala_id' => (int) $gejalaId,
                'cf_user' => $cfUser,
                'cf_hasil' => round($cf, 4),
            ];
        }

        if (empty($details)) {
            throw new InvalidArgumentException('Silakan pilih minimal satu gejala.');
        }

        $persentase = round($cfCombine * 100, 2);
        $hasilDiagnosa = $this->determineDepressionLevel($jumlahUtama, $jumlahTambahan);

        return [
            'jumlah_utama' => $jumlahUtama,
            'jumlah_tambahan' => $jumlahTambahan,
            'cf_combine' => round($cfCombine, 4),
            'persentase' => $persentase,
            'hasil_diagnosa' => $hasilDiagnosa,
            'details' => $details,
        ];
    }

    /**
     * Determine depression level based on PPDGJ-III rules.
     */
    public function determineDepressionLevel(int $jumlahUtama, int $jumlahTambahan): string
    {
        // Depresi Berat: 3 gejala utama + minimal 4 tambahan
        if ($jumlahUtama >= 3 && $jumlahTambahan >= 4) {
            return 'Depresi Berat';
        }

        // Depresi Sedang: (2 utama + minimal 3 tambahan) OR (3 utama + kurang dari 4 tambahan)
        if (($jumlahUtama == 2 && $jumlahTambahan >= 3) || ($jumlahUtama == 3 && $jumlahTambahan < 4)) {
            return 'Depresi Sedang';
        }

        // Depresi Ringan: 2 utama + minimal 2 tambahan
        if ($jumlahUtama == 2 && $jumlahTambahan >= 2) {
            return 'Depresi Ringan';
        }

        return 'Tidak Depresi';
    }
}
