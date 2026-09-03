<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { History, Stethoscope, Eye, Trash2, ArrowLeft, PlusCircle } from 'lucide-vue-next';

interface DiagnosaItem {
    id: number;
    hasil_diagnosa: string;
    persentase: number;
    hasil_cf: number;
    created_at: string;
}

const props = defineProps<{
    history: DiagnosaItem[];
}>();

const deleteForm = useForm({});

const deleteDiagnosa = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus data riwayat diagnosa ini?')) {
        deleteForm.delete(route('diagnosa.destroy', id));
    }
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
    <Head title="Riwayat Diagnosa" />

    <div class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between">
        <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-indigo-600 rounded-xl">
                        <History class="w-5 h-5 text-white" />
                    </div>
                    <span class="font-bold text-white">Riwayat Diagnosa Mahasiswa</span>
                </div>

                <div class="flex items-center space-x-3">
                    <Link
                        :href="route('diagnosa.create')"
                        class="text-xs font-semibold bg-emerald-600 hover:bg-emerald-500 text-white px-3.5 py-2 rounded-lg transition flex items-center space-x-1.5 shadow-md shadow-emerald-600/20"
                    >
                        <PlusCircle class="w-3.5 h-3.5" />
                        <span>Diagnosa Baru</span>
                    </Link>
                </div>
            </div>
        </header>

        <main class="max-w-5xl mx-auto w-full px-4 py-8 flex-grow space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white">Daftar Riwayat Diagnosa</h1>
                    <p class="text-xs text-slate-400 mt-1">Catatan histori hasil pemeriksaan tingkat depresi yang pernah dilakukan.</p>
                </div>

                <Link
                    :href="route('user.profile')"
                    class="inline-flex items-center space-x-1.5 text-xs text-slate-400 hover:text-slate-200 transition"
                >
                    <ArrowLeft class="w-4 h-4" />
                    <span>Kembali ke Profil</span>
                </Link>
            </div>

            <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-950/80 text-xs uppercase text-slate-400 border-b border-slate-700">
                            <tr>
                                <th class="py-3.5 px-4 w-12 text-center">No</th>
                                <th class="py-3.5 px-4">Tanggal Diagnosa</th>
                                <th class="py-3.5 px-4">Hasil Diagnosa</th>
                                <th class="py-3.5 px-4 text-center">Tingkat Keyakinan (CF)</th>
                                <th class="py-3.5 px-4 text-center w-32">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700/60 text-xs">
                            <tr v-if="props.history.length === 0">
                                <td colspan="5" class="py-8 text-center text-slate-500">
                                    Belum ada riwayat diagnosa. Silakan lakukan diagnosa pertama Anda.
                                </td>
                            </tr>

                            <tr v-for="(item, idx) in props.history" :key="item.id" class="hover:bg-slate-700/30 transition">
                                <td class="py-4 px-4 text-center text-slate-500">{{ idx + 1 }}</td>
                                <td class="py-4 px-4 font-mono text-slate-300">
                                    {{ new Date(item.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' }) }}
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-lg border" :class="getBadgeColor(item.hasil_diagnosa)">
                                        {{ item.hasil_diagnosa }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center font-bold text-emerald-400 text-sm">
                                    {{ item.persentase }}%
                                </td>
                                <td class="py-4 px-4 text-center space-x-2">
                                    <Link
                                        :href="route('diagnosa.show', item.id)"
                                        class="inline-flex items-center p-2 bg-indigo-600/20 hover:bg-indigo-600 text-indigo-300 hover:text-white rounded-lg transition"
                                        title="Detail Hasil"
                                    >
                                        <Eye class="w-4 h-4" />
                                    </Link>

                                    <button
                                        @click="deleteDiagnosa(item.id)"
                                        class="inline-flex items-center p-2 bg-rose-600/20 hover:bg-rose-600 text-rose-300 hover:text-white rounded-lg transition"
                                        title="Hapus"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <footer class="text-center py-4 text-xs text-slate-500">
            &copy; {{ new Date().getFullYear() }} Sistem Pakar Tingkat Depresi Mahasiswa
        </footer>
    </div>
</template>
