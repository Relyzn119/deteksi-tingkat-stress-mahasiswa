<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Brain, Stethoscope, Calculator, FileSpreadsheet, ShieldCheck, UserCheck, ArrowRight, BookOpen } from 'lucide-vue-next';
</script>

<template>
    <Head title="Sistem Pakar Depresi Mahasiswa" />

    <div class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between selection:bg-indigo-500 selection:text-white">
        <!-- HEADER / NAVIGATION -->
        <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-500/30">
                        <Brain class="w-6 h-6 text-white" />
                    </div>
                    <span class="font-bold text-lg text-white tracking-wide">Sistem Pakar Depresi</span>
                </div>

                <nav class="flex items-center space-x-3">
                    <Link
                        :href="route('tentang-metode')"
                        class="text-sm font-medium text-slate-300 hover:text-white px-3 py-2 rounded-lg transition"
                    >
                        Metode CF
                    </Link>

                    <template v-if="$page.props.auth.user">
                        <Link
                            :href="route('dashboard')"
                            class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg shadow-md transition"
                        >
                            Dashboard
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="text-sm font-medium text-slate-300 hover:text-white px-3 py-2 rounded-lg transition"
                        >
                            Login
                        </Link>
                        <Link
                            :href="route('register')"
                            class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg shadow-md transition"
                        >
                            Register
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <!-- HERO SECTION -->
        <main class="flex-grow flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center my-auto">
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 bg-indigo-950/80 border border-indigo-700/50 rounded-full text-indigo-300 text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Metode Certainty Factor (CF) & Standard PPDGJ-III</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        Sistem Pakar Diagnosa Tingkat Depresi <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-sky-400 to-emerald-400">Mahasiswa</span>
                    </h1>

                    <p class="text-lg text-slate-300 leading-relaxed">
                        Aplikasi sistem pakar berbasis pengetahuan pakar untuk menentukan tingkat depresi mahasiswa akhir berdasarkan penilaian tingkat keyakinan gejala yang dirasakan.
                    </p>

                    <div class="pt-4 flex flex-wrap gap-4">
                        <template v-if="$page.props.auth.user">
                            <Link
                                :href="route('diagnosa.create')"
                                class="inline-flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-emerald-600 hover:from-indigo-500 hover:to-emerald-500 text-white font-semibold px-6 py-3.5 rounded-xl shadow-lg shadow-indigo-600/30 transition transform hover:-translate-y-0.5"
                            >
                                <Stethoscope class="w-5 h-5" />
                                <span>Mulai Diagnosa Sekarang</span>
                                <ArrowRight class="w-4 h-4 ml-1" />
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                :href="route('register')"
                                class="inline-flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-emerald-600 hover:from-indigo-500 hover:to-emerald-500 text-white font-semibold px-6 py-3.5 rounded-xl shadow-lg shadow-indigo-600/30 transition transform hover:-translate-y-0.5"
                            >
                                <UserCheck class="w-5 h-5" />
                                <span>Daftar Akun Mahasiswa</span>
                                <ArrowRight class="w-4 h-4 ml-1" />
                            </Link>

                            <Link
                                :href="route('login')"
                                class="inline-flex items-center space-x-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold px-6 py-3.5 rounded-xl border border-slate-700 transition"
                            >
                                <ShieldCheck class="w-5 h-5 text-indigo-400" />
                                <span>Login User / Admin</span>
                            </Link>
                        </template>
                    </div>
                </div>

                <!-- FEATURE CARDS GRID -->
                <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-slate-800/80 border border-slate-700/60 p-6 rounded-2xl shadow-xl hover:border-indigo-500/50 transition">
                        <div class="p-3 bg-indigo-900/50 rounded-xl w-max mb-4">
                            <Brain class="w-6 h-6 text-indigo-400" />
                        </div>
                        <h3 class="font-bold text-white mb-1">Profil Mahasiswa</h3>
                        <p class="text-xs text-slate-400">Pengelolaan profil mencakup NIM, Prodi, Semester, Umur, dan Jenis Kelamin.</p>
                    </div>

                    <div class="bg-slate-800/80 border border-slate-700/60 p-6 rounded-2xl shadow-xl hover:border-emerald-500/50 transition">
                        <div class="p-3 bg-emerald-900/50 rounded-xl w-max mb-4">
                            <Stethoscope class="w-6 h-6 text-emerald-400" />
                        </div>
                        <h3 class="font-bold text-white mb-1">Diagnosa Interaktif</h3>
                        <p class="text-xs text-slate-400">Penilaian gejala utama & tambahan dengan tingkat keyakinan (0 - 1.0).</p>
                    </div>

                    <div class="bg-slate-800/80 border border-slate-700/60 p-6 rounded-2xl shadow-xl hover:border-amber-500/50 transition">
                        <div class="p-3 bg-amber-900/50 rounded-xl w-max mb-4">
                            <Calculator class="w-6 h-6 text-amber-400" />
                        </div>
                        <h3 class="font-bold text-white mb-1">Kalkulasi Certainty Factor</h3>
                        <p class="text-xs text-slate-400">Perhitungan $CF_{combine}$ & pencocokan aturan PPDGJ-III yang presisi.</p>
                    </div>

                    <div class="bg-slate-800/80 border border-slate-700/60 p-6 rounded-2xl shadow-xl hover:border-sky-500/50 transition">
                        <div class="p-3 bg-sky-900/50 rounded-xl w-max mb-4">
                            <FileSpreadsheet class="w-6 h-6 text-sky-400" />
                        </div>
                        <h3 class="font-bold text-white mb-1">Cetak Hasil & Rekap</h3>
                        <p class="text-xs text-slate-400">Riwayat diagnosa, solusi rekomendasi, serta dukungan cetak laporan PDF.</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="border-t border-slate-800 bg-slate-900 py-6">
            <div class="max-w-7xl mx-auto px-4 text-center text-xs text-slate-500">
                &copy; {{ new Date().getFullYear() }} Sistem Pakar Tingkat Depresi Mahasiswa — Certainty Factor (CF).
            </div>
        </footer>
    </div>
</template>
