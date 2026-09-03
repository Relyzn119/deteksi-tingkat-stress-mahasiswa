<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { FileText, Printer, ArrowLeft, Filter } from 'lucide-vue-next';

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

const selectedHasil = ref(props.selectedFilter || '');

const handleFilter = () => {
    router.get(route('admin.laporan.index'), { hasil: selectedHasil.value }, { preserveState: true });
};

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
</script>

<template>
    <Head title="Laporan Diagnosa" />

    <div class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between">
        <header class="border-b border-slate-800 bg-slate-900/90 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-rose-600 rounded-xl">
                        <FileText class="w-5 h-5 text-white" />
                    </div>
                    <span class="font-bold text-white">Laporan Diagnosa Mahasiswa</span>
                </div>

                <div class="flex items-center space-x-3">
                    <Link
                        :href="route('admin.laporan.print', { hasil: selectedHasil })"
                        target="_blank"
                        class="text-xs font-semibold bg-emerald-600 hover:bg-emerald-500 text-white px-3.5 py-2 rounded-lg transition flex items-center space-x-1.5 shadow-md shadow-emerald-600/20"
                    >
                        <Printer class="w-3.5 h-3.5" />
                        <span>Cetak Laporan Rekap</span>
                    </Link>

                    <Link
                        :href="route('admin.dashboard')"
                        class="text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 px-3.5 py-2 rounded-lg border border-slate-700 transition flex items-center space-x-1.5"
                    >
                        <ArrowLeft class="w-4 h-4" />
                        <span>Dashboard</span>
                    </Link>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto w-full px-4 py-8 flex-grow space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">Laporan & Rekapitulasi Diagnosa</h1>
                    <p class="text-xs text-slate-400 mt-1">Laporan komprehensif riwayat diagnosa depresi seluruh mahasiswa.</p>
                </div>

                <!-- FILTER FORM -->
                <div class="flex items-center space-x-2 w-full sm:w-auto">
                    <select
                        v-model="selectedHasil"
                        @change="handleFilter"
                        class="bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-indigo-500 font-semibold"
                    >
                        <option value="">Semua Hasil Diagnosa</option>
                        <option value="Tidak Depresi">Tidak Depresi</option>
                        <option value="Depresi Ringan">Depresi Ringan</option>
                        <option value="Depresi Sedang">Depresi Sedang</option>
                        <option value="Depresi Berat">Depresi Berat</option>
                    </select>
                </div>
            </div>

            <!-- STAT SUMMARY CARDS -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-slate-800/90 border border-emerald-500/30 p-4 rounded-2xl text-center">
                    <div class="text-2xl font-black text-emerald-400">{{ props.stats.tidak }}</div>
                    <div class="text-xs text-slate-400 font-semibold mt-0.5">Tidak Depresi</div>
                </div>

                <div class="bg-slate-800/90 border border-sky-500/30 p-4 rounded-2xl text-center">
                    <div class="text-2xl font-black text-sky-400">{{ props.stats.ringan }}</div>
                    <div class="text-xs text-slate-400 font-semibold mt-0.5">Depresi Ringan</div>
                </div>

                <div class="bg-slate-800/90 border border-amber-500/30 p-4 rounded-2xl text-center">
                    <div class="text-2xl font-black text-amber-400">{{ props.stats.sedang }}</div>
                    <div class="text-xs text-slate-400 font-semibold mt-0.5">Depresi Sedang</div>
                </div>

                <div class="bg-slate-800/90 border border-rose-500/30 p-4 rounded-2xl text-center">
                    <div class="text-2xl font-black text-rose-400">{{ props.stats.berat }}</div>
                    <div class="text-xs text-slate-400 font-semibold mt-0.5">Depresi Berat</div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-950/80 text-xs uppercase text-slate-400 border-b border-slate-700">
                            <tr>
                                <th class="py-3.5 px-4 w-12 text-center">No</th>
                                <th class="py-3.5 px-4 w-32">NIM</th>
                                <th class="py-3.5 px-4">Nama Mahasiswa</th>
                                <th class="py-3.5 px-4">Hasil Diagnosa</th>
                                <th class="py-3.5 px-4 text-center">Persentase (CF)</th>
                                <th class="py-3.5 px-4">Tanggal Diagnosa</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700/60 text-xs">
                            <tr v-if="props.diagnosaList.length === 0">
                                <td colspan="6" class="py-8 text-center text-slate-500">Tidak ada data diagnosa ditemukan.</td>
                            </tr>

                            <tr v-for="(d, idx) in props.diagnosaList" :key="d.id" class="hover:bg-slate-700/30 transition">
                                <td class="py-3.5 px-4 text-center text-slate-500">{{ idx + 1 }}</td>
                                <td class="py-3.5 px-4 font-mono text-indigo-400 font-bold">{{ d.user?.nim || '-' }}</td>
                                <td class="py-3.5 px-4 font-bold text-white">{{ d.user?.name }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg border" :class="getBadgeColor(d.hasil_diagnosa)">
                                        {{ d.hasil_diagnosa }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center font-bold text-emerald-400 font-mono text-sm">{{ d.persentase }}%</td>
                                <td class="py-3.5 px-4 text-slate-300 font-mono">
                                    {{ new Date(d.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' }) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <footer class="text-center py-4 text-xs text-slate-500">
            &copy; {{ new Date().getFullYear() }} Panel Administrator Sistem Pakar Depresi
        </footer>
    </div>
</template>
