<?php

namespace Database\Seeders;

use App\Models\Aturan;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SistemPakarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Admin & Test User
        User::updateOrCreate(
            ['email' => 'admin@sistempakar.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'mahasiswa@sistempakar.com'],
            [
                'nim' => '210101001',
                'name' => 'Mahasiswa Test',
                'password' => Hash::make('password'),
                'jk' => 'Laki-laki',
                'umur' => 22,
                'prodi' => 'Teknik Informatika',
                'semester' => 8,
                'role' => 'user',
            ]
        );

        // 2. Seed Data Penyakit (Tingkat Depresi PPDGJ-III)
        $penyakitData = [
            [
                'kode_penyakit' => 'P01',
                'nama_penyakit' => 'Depresi Berat',
                'deskripsi' => 'Mood depresif, kehilangan minat dan kegembiraan, serta berkurangnya energi yang menuju meningkatnya keadaan mudah lelah dan berkurangnya aktivitas yang nyata selama sekurang-kurangnya 2 minggu. Disertai minimal 3 gejala utama dan minimal 4 gejala tambahan dengan intensitas berat.',
                'solusi' => 'Disarankan untuk segera berkonsultasi dengan Dokter Spesialis Kedokteran Jiwa (Psikiater) atau Psikolog Klinis secara profesional untuk mendapatkan penanganan medis/terapi yang tepat dan dukungan secara intensif.',
            ],
            [
                'kode_penyakit' => 'P02',
                'nama_penyakit' => 'Depresi Sedang',
                'deskripsi' => 'Mengalami sekurang-kurangnya 2 gejala utama depresi dan minimal 3 gejala tambahan dengan lama berlangsung sekurang-kurangnya 2 minggu. Aktivitas sehari-hari mulai terganggu secara bermakna.',
                'solusi' => 'Berkonsultasi dengan Psikolog/Konselor kampus, melakukan konseling psikologis, serta menerapkan pola hidup sehat, manajemen stres, dan bercerita kepada orang terpercaya.',
            ],
            [
                'kode_penyakit' => 'P03',
                'nama_penyakit' => 'Depresi Ringan',
                'deskripsi' => 'Mengalami sekurang-kurangnya 2 gejala utama depresi dan minimal 2 gejala tambahan dengan lama berlangsung sekurang-kurangnya 2 minggu. Penderita biasanya masih mampu meneruskan pekerjaan dan kegiatan sosial.',
                'solusi' => 'Melakukan relaksasi, olahraga teratur, memperbaiki pola tidur, mengurangi isolasi diri, serta melakukan aktivitas positif yang disukai (hobi).',
            ],
            [
                'kode_penyakit' => 'P04',
                'nama_penyakit' => 'Tidak Depresi',
                'deskripsi' => 'Kondisi emosional dan psikologis berada dalam batas normal dan tidak memenuhi kriteria klinis tingkat depresi PPDGJ-III.',
                'solusi' => 'Tetap pertahankan pola hidup sehat, jaga keseimbangan antara kegiatan akademik dan istirahat, serta kelola emosi secara positif.',
            ],
        ];

        $penyakitMap = [];
        foreach ($penyakitData as $p) {
            $penyakit = Penyakit::updateOrCreate(
                ['kode_penyakit' => $p['kode_penyakit']],
                $p
            );
            $penyakitMap[$p['kode_penyakit']] = $penyakit->id;
        }

        // 3. Seed Data Gejala
        $gejalaData = [
            // Gejala Utama
            [
                'kode_gejala' => 'G01',
                'nama_gejala' => 'Merasa sedih, hampa, depresi, atau putus asa hampir sepanjang hari',
                'jenis_gejala' => 'utama',
                'cf_pakar' => 0.8,
            ],
            [
                'kode_gejala' => 'G02',
                'nama_gejala' => 'Kehilangan minat atau kesenangan pada aktivitas yang biasanya disukai (anhedonia)',
                'jenis_gejala' => 'utama',
                'cf_pakar' => 0.8,
            ],
            [
                'kode_gejala' => 'G03',
                'nama_gejala' => 'Mudah lelah, lemas, atau merasa berkurangnya energi secara signifikan',
                'jenis_gejala' => 'utama',
                'cf_pakar' => 0.8,
            ],
            // Gejala Tambahan
            [
                'kode_gejala' => 'G04',
                'nama_gejala' => 'Konsentrasi dan kemampuan berpikir atau membuat keputusan menurun',
                'jenis_gejala' => 'tambahan',
                'cf_pakar' => 0.6,
            ],
            [
                'kode_gejala' => 'G05',
                'nama_gejala' => 'Rasa percaya diri dan harga diri berkurang drastis',
                'jenis_gejala' => 'tambahan',
                'cf_pakar' => 0.6,
            ],
            [
                'kode_gejala' => 'G06',
                'nama_gejala' => 'Perasaan bersalah yang berlebihan atau merasa tidak berguna',
                'jenis_gejala' => 'tambahan',
                'cf_pakar' => 0.6,
            ],
            [
                'kode_gejala' => 'G07',
                'nama_gejala' => 'Pandangan masa depan yang suram, pesimistis, atau tidak berharapan',
                'jenis_gejala' => 'tambahan',
                'cf_pakar' => 0.6,
            ],
            [
                'kode_gejala' => 'G08',
                'nama_gejala' => 'Gagasan, pikiran, atau tindakan untuk membahayakan diri atau bunuh diri',
                'jenis_gejala' => 'tambahan',
                'cf_pakar' => 0.9,
            ],
            [
                'kode_gejala' => 'G09',
                'nama_gejala' => 'Gangguan tidur (sulit tidur / insomnia atau tidur berlebihan / hipersomnia)',
                'jenis_gejala' => 'tambahan',
                'cf_pakar' => 0.6,
            ],
            [
                'kode_gejala' => 'G10',
                'nama_gejala' => 'Perubahan nafsu makan atau perubahan berat badan yang signifikan',
                'jenis_gejala' => 'tambahan',
                'cf_pakar' => 0.6,
            ],
        ];

        $gejalaMap = [];
        foreach ($gejalaData as $g) {
            $gejala = Gejala::updateOrCreate(
                ['kode_gejala' => $g['kode_gejala']],
                $g
            );
            $gejalaMap[$g['kode_gejala']] = $gejala->id;
        }

        // 4. Seed Aturan / Knowledge Base Rules
        // Depresi Berat (P01) -> ALL Symptoms
        foreach (['G01', 'G02', 'G03', 'G04', 'G05', 'G06', 'G07', 'G08', 'G09', 'G10'] as $gKode) {
            Aturan::firstOrCreate([
                'penyakit_id' => $penyakitMap['P01'],
                'gejala_id' => $gejalaMap[$gKode],
            ]);
        }

        // Depresi Sedang (P02) -> G01, G02, G04, G05, G06, G07, G09, G10
        foreach (['G01', 'G02', 'G04', 'G05', 'G06', 'G07', 'G09', 'G10'] as $gKode) {
            Aturan::firstOrCreate([
                'penyakit_id' => $penyakitMap['P02'],
                'gejala_id' => $gejalaMap[$gKode],
            ]);
        }

        // Depresi Ringan (P03) -> G01, G02, G04, G05, G09
        foreach (['G01', 'G02', 'G04', 'G05', 'G09'] as $gKode) {
            Aturan::firstOrCreate([
                'penyakit_id' => $penyakitMap['P03'],
                'gejala_id' => $gejalaMap[$gKode],
            ]);
        }
    }
}
