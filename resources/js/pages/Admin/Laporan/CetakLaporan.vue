<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

interface Student {
    name: string;
    nim: string | null;
}

interface Diagnosa {
    id: number;
    hasil_diagnosa: string;
    persentase: number;
    created_at: string;
    user: Student;
}

const props = defineProps<{
    diagnosaList: Diagnosa[];
    stats: {
        tidak: number;
        ringan: number;
        sedang: number;
        berat: number;
    };
    selectedFilter?: string;
}>();

onMounted(() => {
    setTimeout(() => {
        window.print();
    }, 500);
});
</script>

<template>
    <Head title="Cetak Rekap Laporan Diagnosa" />

    <div class="bg-white text-slate-900 min-h-screen p-8 max-w-5xl mx-auto space-y-6 print:p-0 font-sans">
        <!-- HEADER -->
        <div class="border-b-2 border-slate-900 pb-4 text-center space-y-1">
            <h1 class="text-xl font-bold uppercase tracking-wider">Rekapitulasi Laporan Diagnosa Depresi Mahasiswa</h1>
            <h2 class="text-xs font-semibold text-slate-600">Sistem Pakar Tingkat Depresi Mahasiswa Menggunakan Metode Certainty Factor (CF)</h2>
            <div v-if="props.selectedFilter" class="text-xs font-bold text-indigo-700 pt-1">
                Kategori Filter: {{ props.selectedFilter }}
            </div>
        </div>

        <!-- STAT REKAP SUMMARY -->
        <div class="grid grid-cols-4 gap-2 text-center text-xs border border-slate-300 rounded p-2 bg-slate-50">
            <div>Tidak Depresi: <strong>{{ props.stats.tidak }}</strong></div>
            <div>Depresi Ringan: <strong>{{ props.stats.ringan }}</strong></div>
            <div>Depresi Sedang: <strong>{{ props.stats.sedang }}</strong></div>
            <div>Depresi Berat: <strong>{{ props.stats.berat }}</strong></div>
        </div>

        <!-- TABLE -->
        <table class="w-full text-left text-xs border border-slate-300 border-collapse">
            <thead>
                <tr class="bg-slate-200 text-slate-900 font-bold border-b border-slate-300">
                    <th class="p-2 border-r border-slate-300 text-center w-10">No</th>
                    <th class="p-2 border-r border-slate-300 w-28">NIM</th>
                    <th class="p-2 border-r border-slate-300">Nama Mahasiswa</th>
                    <th class="p-2 border-r border-slate-300 w-36">Hasil Diagnosa</th>
                    <th class="p-2 border-r border-slate-300 text-center w-24">Persentase (CF)</th>
                    <th class="p-2 text-center w-36">Tanggal Diagnosa</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="props.diagnosaList.length === 0">
                    <td colspan="6" class="p-4 text-center text-slate-500">Tidak ada data diagnosa.</td>
                </tr>

                <tr v-for="(d, idx) in props.diagnosaList" :key="d.id" class="border-b border-slate-200">
                    <td class="p-2 text-center border-r border-slate-200">{{ idx + 1 }}</td>
                    <td class="p-2 font-mono font-bold border-r border-slate-200">{{ d.user?.nim || '-' }}</td>
                    <td class="p-2 border-r border-slate-200 font-medium">{{ d.user?.name }}</td>
                    <td class="p-2 border-r border-slate-200 font-bold">{{ d.hasil_diagnosa }}</td>
                    <td class="p-2 text-center border-r border-slate-200 font-bold">{{ d.persentase }}%</td>
                    <td class="p-2 text-center font-mono">{{ new Date(d.created_at).toLocaleDateString('id-ID') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- SIGNATURE -->
        <div class="pt-8 flex justify-end text-xs">
            <div class="text-center space-y-12">
                <div>Dicetak pada: {{ new Date().toLocaleDateString('id-ID') }}</div>
                <div class="font-bold border-b border-slate-900 pb-1 w-48">Administrator Sistem Pakar</div>
            </div>
        </div>
    </div>
</template>
