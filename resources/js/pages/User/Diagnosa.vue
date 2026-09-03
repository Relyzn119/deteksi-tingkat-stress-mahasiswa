<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { Stethoscope, AlertCircle, CheckCircle2, ArrowRight, History, User } from 'lucide-vue-next';

interface Gejala {
    id: number;
    kode_gejala: string;
    nama_gejala: string;
    jenis_gejala: 'utama' | 'tambahan';
    cf_pakar: number;
}

const props = defineProps<{
    gejalaList: Gejala[];
    existingDiagnosaId?: number | null;
}>();

// Initialize form answers
const initialGejalaState: Record<number, number> = {};
props.gejalaList.forEach((g) => {
    initialGejalaState[g.id] = 0;
});

const form = useForm({
    gejala: initialGejalaState,
});

const submit = () => {
    form.post(route('diagnosa.store'));
};
</script>

<template>
    <Head title="Form Diagnosa Tingkat Depresi" />

    <div class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between">
        <!-- NAV HEADER -->
        <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-emerald-600 rounded-xl shadow-lg shadow-emerald-500/20">
                        <Stethoscope class="w-5 h-5 text-white" />
                    </div>
                    <span class="font-bold text-white">Form Diagnosa Depresi</span>
                </div>

                <div class="flex items-center space-x-3">
                    <Link
                        :href="route('diagnosa.history')"
                        class="text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 px-3 py-1.5 rounded-lg border border-slate-700 transition flex items-center space-x-1.5"
                    >
                        <History class="w-3.5 h-3.5 text-indigo-400" />
                        <span>Riwayat Diagnosa</span>
                    </Link>

                    <Link
                        :href="route('user.profile')"
                        class="text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 px-3 py-1.5 rounded-lg border border-slate-700 transition flex items-center space-x-1.5"
                    >
                        <User class="w-3.5 h-3.5 text-emerald-400" />
                        <span>Profil</span>
                    </Link>
                </div>
            </div>
        </header>

        <!-- CONTAINER -->
        <main class="max-w-5xl mx-auto w-full px-4 py-8 flex-grow space-y-6">
            <!-- EXISTING DIAGNOSA ALERT -->
            <div v-if="props.existingDiagnosaId" class="bg-indigo-950/80 border border-indigo-700/60 rounded-2xl p-4 flex items-center justify-between">
                <div class="flex items-center space-x-3 text-sm text-indigo-200">
                    <CheckCircle2 class="w-5 h-5 text-indigo-400 flex-shrink-0" />
                    <span>Anda sudah pernah melakukan diagnosa sebelumnya.</span>
                </div>

                <Link
                    :href="route('diagnosa.show', props.existingDiagnosaId)"
                    class="text-xs font-semibold bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-xl transition"
                >
                    Lihat Hasil Terakhir
                </Link>
            </div>

            <!-- INSTRUCTIONS -->
            <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-6 shadow-xl space-y-3">
                <div class="flex items-center space-x-2 text-amber-400 font-semibold text-sm">
                    <AlertCircle class="w-5 h-5" />
                    <span>Petunjuk Pengisian Diagnosa</span>
                </div>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Pilihlah tingkat keyakinan yang paling menggambarkan kondisi yang Anda rasakan selama <strong>lebih dari 2 minggu terakhir</strong>. Jawablah secara jujur untuk memperoleh hasil evaluasi tingkat depresi yang akurat.
                </p>
            </div>

            <!-- DIAGNOSA FORM -->
            <form @submit.prevent="submit" class="space-y-6">
                <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl overflow-hidden shadow-2xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-300">
                            <thead class="bg-slate-950/80 text-xs uppercase text-slate-400 border-b border-slate-700">
                                <tr>
                                    <th class="py-3.5 px-4 w-16 text-center">Kode</th>
                                    <th class="py-3.5 px-4">Pertanyaan Gejala</th>
                                    <th class="py-3.5 px-4 w-56 text-center">Tingkat Keyakinan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-700/60">
                                <tr
                                    v-for="g in props.gejalaList"
                                    :key="g.id"
                                    class="hover:bg-slate-700/30 transition"
                                >
                                    <td class="py-4 px-4 text-center font-mono font-bold text-xs text-indigo-400">
                                        {{ g.kode_gejala }}
                                    </td>

                                    <td class="py-4 px-4 space-y-1">
                                        <div class="text-sm font-medium text-white">{{ g.nama_gejala }}</div>
                                        <div>
                                            <span
                                                v-if="g.jenis_gejala === 'utama'"
                                                class="inline-block px-2 py-0.5 text-[10px] font-bold bg-rose-950/80 text-rose-300 border border-rose-700/50 rounded-md"
                                            >
                                                Gejala Utama
                                            </span>
                                            <span
                                                v-else
                                                class="inline-block px-2 py-0.5 text-[10px] font-medium bg-slate-700 text-slate-300 rounded-md"
                                            >
                                                Gejala Tambahan
                                            </span>
                                        </div>
                                    </td>

                                    <td class="py-4 px-4 text-center">
                                        <select
                                            v-model="form.gejala[g.id]"
                                            class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-indigo-500 font-semibold"
                                        >
                                            <option :value="0">Tidak (0.0)</option>
                                            <option :value="0.4">Mungkin (0.4)</option>
                                            <option :value="0.6">Kemungkinan Besar (0.6)</option>
                                            <option :value="0.8">Hampir Pasti (0.8)</option>
                                            <option :value="1">Pasti (1.0)</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-if="form.errors.gejala" class="p-4 bg-rose-950/80 border border-rose-700 rounded-xl text-xs text-rose-300 font-medium">
                    {{ form.errors.gejala }}
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center space-x-2 bg-gradient-to-r from-emerald-600 to-indigo-600 hover:from-emerald-500 hover:to-indigo-500 text-white font-semibold px-8 py-3 rounded-xl shadow-lg shadow-emerald-600/30 transition disabled:opacity-50"
                    >
                        <span>Proses Perhitungan CF</span>
                        <ArrowRight class="w-4 h-4" />
                    </button>
                </div>
            </form>
        </main>

        <footer class="text-center py-4 text-xs text-slate-500">
            &copy; {{ new Date().getFullYear() }} Sistem Pakar Tingkat Depresi Mahasiswa
        </footer>
    </div>
</template>
