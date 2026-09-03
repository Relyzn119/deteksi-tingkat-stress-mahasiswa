<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Printer, History, Home, AlertTriangle, CheckCircle, HelpCircle, ShieldAlert, Sparkles } from 'lucide-vue-next';

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

const getBadgeColor = (hasil: string) => {
    switch (hasil) {
        case 'Depresi Berat':
            return 'bg-rose-950/80 border-rose-500/60 text-rose-300';
        case 'Depresi Sedang':
            return 'bg-amber-950/80 border-amber-500/60 text-amber-300';
        case 'Depresi Ringan':
            return 'bg-sky-950/80 border-sky-500/60 text-sky-300';
        default:
            return 'bg-emerald-950/80 border-emerald-500/60 text-emerald-300';
    }
};

const getProgressBarColor = (hasil: string) => {
    switch (hasil) {
        case 'Depresi Berat':
            return 'bg-rose-500';
        case 'Depresi Sedang':
            return 'bg-amber-500';
        case 'Depresi Ringan':
            return 'bg-sky-500';
        default:
            return 'bg-emerald-500';
    }
};
</script>

<template>
    <Head title="Hasil Diagnosa" />

    <div class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between">
        <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-indigo-600 rounded-xl">
                        <Sparkles class="w-5 h-5 text-white" />
                    </div>
                    <span class="font-bold text-white">Hasil Evaluasi Diagnosa</span>
                </div>

                <div class="flex items-center space-x-3">
                    <Link
                        :href="route('diagnosa.print', props.diagnosa.id)"
                        target="_blank"
                        class="text-xs font-semibold bg-indigo-600 hover:bg-indigo-500 text-white px-3.5 py-2 rounded-lg transition flex items-center space-x-1.5 shadow-md shadow-indigo-600/20"
                    >
                        <Printer class="w-3.5 h-3.5" />
                        <span>Cetak / Download PDF</span>
                    </Link>

                    <Link
                        :href="route('diagnosa.history')"
                        class="text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 px-3.5 py-2 rounded-lg border border-slate-700 transition flex items-center space-x-1.5"
                    >
                        <History class="w-3.5 h-3.5 text-indigo-400" />
                        <span>Riwayat</span>
                    </Link>
                </div>
            </div>
        </header>

        <main class="max-w-5xl mx-auto w-full px-4 py-8 flex-grow space-y-8">
            <!-- STUDENT INFO CARD -->
            <div class="bg-gradient-to-r from-indigo-950/80 via-slate-800/90 to-emerald-950/80 border border-slate-700/80 rounded-2xl p-6 shadow-xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="text-xs text-indigo-300 font-semibold uppercase tracking-wider">Identitas Mahasiswa</div>
                    <div class="text-xl font-bold text-white mt-1">{{ props.student.name }}</div>
                    <div class="text-xs text-slate-400 mt-1">NIM: {{ props.student.nim || '-' }} &bull; {{ props.student.prodi || '-' }} (Semester {{ props.student.semester || '-' }})</div>
                </div>

                <div class="text-right">
                    <div class="text-xs text-slate-400">Tanggal Diagnosa</div>
                    <div class="text-xs font-mono font-medium text-slate-300 mt-1">{{ new Date(props.diagnosa.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }) }}</div>
                </div>
            </div>

            <!-- RESULT BANNER -->
            <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-8 shadow-2xl text-center space-y-6">
                <div class="inline-block px-6 py-2 rounded-2xl border text-xl font-extrabold shadow-lg" :class="getBadgeColor(props.diagnosa.hasil_diagnosa)">
                    {{ props.diagnosa.hasil_diagnosa }}
                </div>

                <div>
                    <div class="text-5xl font-black text-white tracking-tight">{{ props.diagnosa.persentase }}%</div>
                    <div class="text-xs text-slate-400 mt-1">Tingkat Keyakinan Certainty Factor (CF Combine: {{ props.diagnosa.hasil_cf }})</div>
                </div>

                <!-- PROGRESS BAR -->
                <div class="w-full bg-slate-900 rounded-full h-4 p-0.5 border border-slate-700 max-w-xl mx-auto overflow-hidden">
                    <div
                        class="h-full rounded-full transition-all duration-1000 shadow-lg"
                        :class="getProgressBarColor(props.diagnosa.hasil_diagnosa)"
                        :style="{ width: props.diagnosa.persentase + '%' }"
                    ></div>
                </div>

                <!-- STAT COUNTERS -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 max-w-2xl mx-auto pt-4">
                    <div class="bg-slate-900/80 p-4 rounded-xl border border-slate-700">
                        <div class="text-2xl font-bold text-indigo-400">{{ props.diagnosa.jumlah_utama }}</div>
                        <div class="text-xs text-slate-400">Gejala Utama</div>
                    </div>

                    <div class="bg-slate-900/80 p-4 rounded-xl border border-slate-700">
                        <div class="text-2xl font-bold text-amber-400">{{ props.diagnosa.jumlah_tambahan }}</div>
                        <div class="text-xs text-slate-400">Gejala Tambahan</div>
                    </div>

                    <div class="bg-slate-900/80 p-4 rounded-xl border border-slate-700 col-span-2 sm:col-span-1">
                        <div class="text-2xl font-bold text-emerald-400">{{ props.diagnosa.persentase }}%</div>
                        <div class="text-xs text-slate-400">Keyakinan CF</div>
                    </div>
                </div>
            </div>

            <!-- DESKRIPSI & SOLUSI -->
            <div v-if="props.penyakit" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-6 shadow-xl space-y-3">
                    <h3 class="text-base font-bold text-indigo-400 flex items-center space-x-2">
                        <AlertTriangle class="w-5 h-5" />
                        <span>Deskripsi Klinis</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        {{ props.penyakit.deskripsi }}
                    </p>
                </div>

                <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-6 shadow-xl space-y-3">
                    <h3 class="text-base font-bold text-emerald-400 flex items-center space-x-2">
                        <CheckCircle class="w-5 h-5" />
                        <span>Saran & Solusi Pakar</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        {{ props.penyakit.solusi }}
                    </p>
                </div>
            </div>

            <!-- GEJALA YANG DIPILIH TABLE -->
            <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-6 shadow-xl space-y-4">
                <h3 class="text-base font-bold text-white">Gejala Yang Dipilih Pengguna</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-950/80 text-xs uppercase text-slate-400 border-b border-slate-700">
                            <tr>
                                <th class="py-3 px-4 w-12 text-center">No</th>
                                <th class="py-3 px-4 w-20">Kode</th>
                                <th class="py-3 px-4">Nama Gejala</th>
                                <th class="py-3 px-4 w-24 text-center">CF User</th>
                                <th class="py-3 px-4 w-24 text-center">CF Hasil</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700/60 text-xs">
                            <tr v-for="(item, idx) in props.diagnosa.detail_diagnosa" :key="item.id">
                                <td class="py-3 px-4 text-center text-slate-500">{{ idx + 1 }}</td>
                                <td class="py-3 px-4 font-mono font-bold text-indigo-400">{{ item.gejala.kode_gejala }}</td>
                                <td class="py-3 px-4 text-slate-200">{{ item.gejala.nama_gejala }}</td>
                                <td class="py-3 px-4 text-center font-bold text-amber-400">{{ item.cf_user }}</td>
                                <td class="py-3 px-4 text-center font-bold text-emerald-400">{{ item.cf_hasil }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- NAVIGATION BUTTONS -->
            <div class="flex items-center justify-center space-x-4 pt-4">
                <Link
                    :href="route('diagnosa.create')"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-6 py-2.5 rounded-xl transition shadow-lg shadow-indigo-600/30 text-xs"
                >
                    Diagnosa Ulang
                </Link>

                <Link
                    :href="route('diagnosa.history')"
                    class="bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-semibold px-6 py-2.5 rounded-xl transition text-xs"
                >
                    Lihat Riwayat
                </Link>
            </div>
        </main>

        <footer class="text-center py-4 text-xs text-slate-500">
            &copy; {{ new Date().getFullYear() }} Sistem Pakar Tingkat Depresi Mahasiswa
        </footer>
    </div>
</template>
