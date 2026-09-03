<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Brain, ArrowLeft, CheckCircle, HelpCircle } from 'lucide-vue-next';
</script>

<template>
    <Head title="Tentang Metode Certainty Factor" />

    <div class="min-h-screen bg-slate-900 text-slate-100 p-6 flex flex-col justify-between">
        <div class="max-w-4xl mx-auto w-full space-y-8 py-8">
            <div class="flex items-center justify-between">
                <Link
                    :href="route('home')"
                    class="inline-flex items-center space-x-2 text-sm font-medium text-indigo-400 hover:text-indigo-300 transition"
                >
                    <ArrowLeft class="w-4 h-4" />
                    <span>Kembali ke Beranda</span>
                </Link>

                <div class="flex items-center space-x-2">
                    <Brain class="w-6 h-6 text-indigo-500" />
                    <span class="font-bold text-white">Method Explanation</span>
                </div>
            </div>

            <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-8 shadow-2xl space-y-6">
                <h1 class="text-3xl font-extrabold text-white">Metode Certainty Factor (CF) & PPDGJ-III</h1>
                <p class="text-slate-300 leading-relaxed">
                    Certainty Factor (CF) diintroduksikan oleh Shortliffe dan Buchanan pada tahun 1975 untuk mengakomodasi ketidakpastian hipotesis yang disebabkan oleh ketidakpastian bukti dalam sistem pakar medis.
                </p>

                <div class="border-t border-slate-700 pt-6 space-y-4">
                    <h2 class="text-xl font-bold text-indigo-400">1. Rumus Perhitungan Certainty Factor</h2>
                    <div class="bg-slate-950/80 p-4 rounded-xl font-mono text-sm border border-slate-800 text-emerald-400 space-y-2">
                        <div>CF(H, E) = CF(User) &times; CF(Pakar)</div>
                        <div>CF(Combine) = CF<sub>lama</sub> + CF<sub>baru</sub> &times; (1 - CF<sub>lama</sub>)</div>
                    </div>
                </div>

                <div class="border-t border-slate-700 pt-6 space-y-4">
                    <h2 class="text-xl font-bold text-indigo-400">2. Bobot Keyakinan User</h2>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <li class="p-3 bg-slate-900/60 rounded-xl border border-slate-700/50 flex items-center justify-between">
                            <span class="text-slate-300">Tidak</span>
                            <span class="font-bold text-rose-400">0.0</span>
                        </li>
                        <li class="p-3 bg-slate-900/60 rounded-xl border border-slate-700/50 flex items-center justify-between">
                            <span class="text-slate-300">Mungkin</span>
                            <span class="font-bold text-amber-400">0.4</span>
                        </li>
                        <li class="p-3 bg-slate-900/60 rounded-xl border border-slate-700/50 flex items-center justify-between">
                            <span class="text-slate-300">Kemungkinan Besar</span>
                            <span class="font-bold text-sky-400">0.6</span>
                        </li>
                        <li class="p-3 bg-slate-900/60 rounded-xl border border-slate-700/50 flex items-center justify-between">
                            <span class="text-slate-300">Hampir Pasti</span>
                            <span class="font-bold text-indigo-400">0.8</span>
                        </li>
                        <li class="p-3 bg-slate-900/60 rounded-xl border border-slate-700/50 flex items-center justify-between col-span-1 sm:col-span-2">
                            <span class="text-slate-300">Pasti</span>
                            <span class="font-bold text-emerald-400">1.0</span>
                        </li>
                    </ul>
                </div>

                <div class="border-t border-slate-700 pt-6 space-y-4">
                    <h2 class="text-xl font-bold text-indigo-400">3. Aturan Pengkategorian Depresi (PPDGJ-III)</h2>
                    <div class="space-y-3 text-sm text-slate-300">
                        <div class="p-4 bg-slate-900/60 rounded-xl border border-rose-500/30">
                            <span class="font-bold text-rose-400">Depresi Berat:</span> Minimal 3 Gejala Utama + minimal 4 Gejala Tambahan.
                        </div>
                        <div class="p-4 bg-slate-900/60 rounded-xl border border-amber-500/30">
                            <span class="font-bold text-amber-400">Depresi Sedang:</span> (2 Gejala Utama + &ge;3 Gejala Tambahan) ATAU (3 Gejala Utama + &lt;4 Gejala Tambahan).
                        </div>
                        <div class="p-4 bg-slate-900/60 rounded-xl border border-sky-500/30">
                            <span class="font-bold text-sky-400">Depresi Ringan:</span> 2 Gejala Utama + &ge;2 Gejala Tambahan.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="text-center py-6 text-xs text-slate-500">
            &copy; {{ new Date().getFullYear() }} Sistem Pakar Tingkat Depresi Mahasiswa
        </footer>
    </div>
</template>
