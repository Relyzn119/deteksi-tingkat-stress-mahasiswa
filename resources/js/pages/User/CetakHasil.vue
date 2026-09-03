<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

interface Gejala {
    id: number;
    kode_gejala: string;
    nama_gejala: string;
}

interface DetailDiagnosa {
    id: number;
    cf_user: number;
    cf_hasil: number;
    gejala: Gejala;
}

interface Student {
    name: string;
    nim: string;
    prodi: string;
    semester: number;
}

interface Diagnosa {
    id: number;
    jumlah_utama: number;
    jumlah_tambahan: number;
    hasil_cf: number;
    persentase: number;
    hasil_diagnosa: string;
    created_at: string;
    detail_diagnosa: DetailDiagnosa[];
}

interface Penyakit {
    kode_penyakit: string;
    nama_penyakit: string;
    deskripsi: string;
    solusi: string;
}

const props = defineProps<{
    diagnosa: Diagnosa;
    penyakit: Penyakit | null;
    student: Student;
}>();

onMounted(() => {
    // Automatically open browser print dialog
    setTimeout(() => {
        window.print();
    }, 500);
});
</script>

<template>
    <Head title="Cetak Hasil Diagnosa" />

    <div class="bg-white text-slate-900 min-h-screen p-8 max-w-4xl mx-auto space-y-6 print:p-0 font-sans">
        <!-- HEADER -->
        <div class="border-b-2 border-slate-900 pb-4 text-center space-y-1">
            <h1 class="text-xl font-bold uppercase tracking-wider">Laporan Hasil Diagnosa Depresi Mahasiswa</h1>
            <h2 class="text-sm font-semibold text-slate-700">Metode Certainty Factor (CF) — Standard PPDGJ-III</h2>
            <div class="text-xs text-slate-500">Universitas / Institut Sistem Pakar Depresi</div>
        </div>

        <!-- IDENTITAS MAHASISWA -->
        <div class="bg-slate-50 border border-slate-300 rounded-lg p-4 space-y-2 text-xs">
            <div class="font-bold text-slate-800 text-sm border-b border-slate-200 pb-1 mb-2">Identitas Mahasiswa</div>
            <div class="grid grid-cols-2 gap-2">
                <div><span class="font-semibold text-slate-600">Nama Lengkap:</span> {{ props.student.name }}</div>
                <div><span class="font-semibold text-slate-600">NIM:</span> {{ props.student.nim || '-' }}</div>
                <div><span class="font-semibold text-slate-600">Program Studi:</span> {{ props.student.prodi || '-' }}</div>
                <div><span class="font-semibold text-slate-600">Semester:</span> Semester {{ props.student.semester || '-' }}</div>
                <div><span class="font-semibold text-slate-600">Tanggal Diagnosa:</span> {{ new Date(props.diagnosa.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }) }}</div>
            </div>
        </div>

        <!-- HASIL DIAGNOSA BOX -->
        <div class="border-2 border-slate-900 rounded-lg p-6 text-center space-y-2 bg-slate-100">
            <div class="text-xs uppercase font-bold text-slate-600">Kesimpulan Diagnosis</div>
            <div class="text-2xl font-black text-slate-900">{{ props.diagnosa.hasil_diagnosa }}</div>
            <div class="text-3xl font-extrabold text-indigo-700">{{ props.diagnosa.persentase }}%</div>
            <div class="text-xs text-slate-500">Tingkat Keyakinan Certainty Factor (CF Combine: {{ props.diagnosa.hasil_cf }})</div>
            <div class="text-xs text-slate-600 pt-1">
                Gejala Utama: <strong>{{ props.diagnosa.jumlah_utama }}</strong> &bull; Gejala Tambahan: <strong>{{ props.diagnosa.jumlah_tambahan }}</strong>
            </div>
        </div>

        <!-- DESKRIPSI & REKOMENDASI -->
        <div v-if="props.penyakit" class="grid grid-cols-2 gap-4 text-xs">
            <div class="border border-slate-300 rounded-lg p-4 space-y-1">
                <div class="font-bold text-slate-800 border-b border-slate-200 pb-1 mb-1">Deskripsi Klinis</div>
                <p class="text-slate-700 leading-relaxed">{{ props.penyakit.deskripsi }}</p>
            </div>

            <div class="border border-slate-300 rounded-lg p-4 space-y-1">
                <div class="font-bold text-slate-800 border-b border-slate-200 pb-1 mb-1">Saran / Rekomendasi Solusi</div>
                <p class="text-slate-700 leading-relaxed">{{ props.penyakit.solusi }}</p>
            </div>
        </div>

        <!-- GEJALA YANG DIPILIH -->
        <div class="space-y-2">
            <div class="text-xs font-bold text-slate-800">Rincian Gejala Yang Dipilih:</div>
            <table class="w-full text-left text-xs border border-slate-300 border-collapse">
                <thead>
                    <tr class="bg-slate-200 text-slate-800 font-bold border-b border-slate-300">
                        <th class="p-2 border-r border-slate-300 text-center w-10">No</th>
                        <th class="p-2 border-r border-slate-300 w-16">Kode</th>
                        <th class="p-2 border-r border-slate-300">Nama Gejala</th>
                        <th class="p-2 border-r border-slate-300 text-center w-20">CF User</th>
                        <th class="p-2 text-center w-20">CF Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, idx) in props.diagnosa.detail_diagnosa" :key="item.id" class="border-b border-slate-200">
                        <td class="p-2 text-center border-r border-slate-200">{{ idx + 1 }}</td>
                        <td class="p-2 font-mono font-bold border-r border-slate-200">{{ item.gejala.kode_gejala }}</td>
                        <td class="p-2 border-r border-slate-200">{{ item.gejala.nama_gejala }}</td>
                        <td class="p-2 text-center border-r border-slate-200">{{ item.cf_user }}</td>
                        <td class="p-2 text-center font-bold">{{ item.cf_hasil }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- SIGNATURE -->
        <div class="pt-8 flex justify-end text-xs">
            <div class="text-center space-y-12">
                <div>Dicetak pada: {{ new Date().toLocaleDateString('id-ID') }}</div>
                <div class="font-bold border-b border-slate-900 pb-1 w-48">Tanda Tangan / Verifikasi</div>
            </div>
        </div>
    </div>
</template>
