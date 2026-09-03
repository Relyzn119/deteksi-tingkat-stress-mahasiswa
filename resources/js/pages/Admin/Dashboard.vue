<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Users, Stethoscope, Network, Activity, Brain, FileText, LogOut, LayoutDashboard } from 'lucide-vue-next';

const props = defineProps<{
    totalUser: number;
    totalGejala: number;
    totalRule: number;
    totalDiagnosa: number;
    chartData: {
        tidak: number;
        ringan: number;
        sedang: number;
        berat: number;
    };
}>();

const maxVal = Math.max(props.chartData.tidak, props.chartData.ringan, props.chartData.sedang, props.chartData.berat, 1);
</script>

<template>
    <Head title="Dashboard Admin" />

    <div class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between">
        <!-- ADMIN NAV HEADER -->
        <header class="border-b border-slate-800 bg-slate-900/90 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-600/30">
                        <LayoutDashboard class="w-5 h-5 text-white" />
                    </div>
                    <span class="font-bold text-white tracking-wide">Panel Administrator</span>
                </div>

                <div class="flex items-center space-x-4">
                    <span class="text-xs font-semibold text-indigo-400 bg-indigo-950/80 border border-indigo-700/50 px-3 py-1 rounded-full">
                        Admin Mode
                    </span>

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="text-xs font-semibold bg-rose-600/20 text-rose-300 hover:bg-rose-600 hover:text-white px-3 py-1.5 rounded-lg border border-rose-500/30 transition flex items-center space-x-1"
                    >
                        <LogOut class="w-3.5 h-3.5" />
                        <span>Logout</span>
                    </Link>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="max-w-7xl mx-auto w-full px-4 py-8 flex-grow space-y-8">
            <!-- BANNER WELCOME -->
            <div class="bg-gradient-to-r from-indigo-950/90 via-slate-800 to-sky-950/90 border border-slate-700/80 rounded-2xl p-6 shadow-2xl">
                <h1 class="text-2xl font-bold text-white">Selamat Datang di Panel Administrator</h1>
                <p class="text-xs text-slate-300 mt-1">Kelola data gejala, tingkat depresi, basis pengetahuan rule, akun mahasiswa, serta analisis laporan diagnosa.</p>
            </div>

            <!-- METRIC CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-5 shadow-xl flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-extrabold text-white">{{ props.totalUser }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">Total Mahasiswa</div>
                    </div>
                    <div class="p-3 bg-indigo-900/50 rounded-xl">
                        <Users class="w-6 h-6 text-indigo-400" />
                    </div>
                </div>

                <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-5 shadow-xl flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-extrabold text-white">{{ props.totalGejala }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">Total Gejala</div>
                    </div>
                    <div class="p-3 bg-emerald-900/50 rounded-xl">
                        <Stethoscope class="w-6 h-6 text-emerald-400" />
                    </div>
                </div>

                <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-5 shadow-xl flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-extrabold text-white">{{ props.totalRule }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">Total Rule (Aturan)</div>
                    </div>
                    <div class="p-3 bg-amber-900/50 rounded-xl">
                        <Network class="w-6 h-6 text-amber-400" />
                    </div>
                </div>

                <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-5 shadow-xl flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-extrabold text-white">{{ props.totalDiagnosa }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">Total Diagnosa</div>
                    </div>
                    <div class="p-3 bg-rose-900/50 rounded-xl">
                        <Activity class="w-6 h-6 text-rose-400" />
                    </div>
                </div>
            </div>

            <!-- DIAGNOSIS DISTRIBUTION CHART -->
            <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-6 shadow-2xl space-y-4">
                <h3 class="text-base font-bold text-white flex items-center space-x-2">
                    <Activity class="w-5 h-5 text-indigo-400" />
                    <span>Grafik Distribusi Hasil Diagnosa</span>
                </h3>

                <div class="space-y-4 pt-2">
                    <!-- Tidak Depresi -->
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-emerald-400">Tidak Depresi</span>
                            <span class="text-slate-300">{{ props.chartData.tidak }} Mahasiswa</span>
                        </div>
                        <div class="w-full bg-slate-900 rounded-full h-3 overflow-hidden border border-slate-700">
                            <div class="bg-emerald-500 h-full rounded-full transition-all duration-750" :style="{ width: (props.chartData.tidak / maxVal * 100) + '%' }"></div>
                        </div>
                    </div>

                    <!-- Depresi Ringan -->
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-sky-400">Depresi Ringan</span>
                            <span class="text-slate-300">{{ props.chartData.ringan }} Mahasiswa</span>
                        </div>
                        <div class="w-full bg-slate-900 rounded-full h-3 overflow-hidden border border-slate-700">
                            <div class="bg-sky-500 h-full rounded-full transition-all duration-750" :style="{ width: (props.chartData.ringan / maxVal * 100) + '%' }"></div>
                        </div>
                    </div>

                    <!-- Depresi Sedang -->
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-amber-400">Depresi Sedang</span>
                            <span class="text-slate-300">{{ props.chartData.sedang }} Mahasiswa</span>
                        </div>
                        <div class="w-full bg-slate-900 rounded-full h-3 overflow-hidden border border-slate-700">
                            <div class="bg-amber-500 h-full rounded-full transition-all duration-750" :style="{ width: (props.chartData.sedang / maxVal * 100) + '%' }"></div>
                        </div>
                    </div>

                    <!-- Depresi Berat -->
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-rose-400">Depresi Berat</span>
                            <span class="text-slate-300">{{ props.chartData.berat }} Mahasiswa</span>
                        </div>
                        <div class="w-full bg-slate-900 rounded-full h-3 overflow-hidden border border-slate-700">
                            <div class="bg-rose-500 h-full rounded-full transition-all duration-750" :style="{ width: (props.chartData.berat / maxVal * 100) + '%' }"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NAVIGATION QUICK CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <Link
                    :href="route('admin.gejala.index')"
                    class="bg-slate-800/90 border border-slate-700 hover:border-indigo-500 p-5 rounded-2xl shadow-xl transition text-center group"
                >
                    <Stethoscope class="w-8 h-8 text-indigo-400 mx-auto group-hover:scale-110 transition" />
                    <div class="text-sm font-bold text-white mt-3">Kelola Gejala</div>
                </Link>

                <Link
                    :href="route('admin.penyakit.index')"
                    class="bg-slate-800/90 border border-slate-700 hover:border-emerald-500 p-5 rounded-2xl shadow-xl transition text-center group"
                >
                    <Brain class="w-8 h-8 text-emerald-400 mx-auto group-hover:scale-110 transition" />
                    <div class="text-sm font-bold text-white mt-3">Kelola Depresi</div>
                </Link>

                <Link
                    :href="route('admin.aturan.index')"
                    class="bg-slate-800/90 border border-slate-700 hover:border-amber-500 p-5 rounded-2xl shadow-xl transition text-center group"
                >
                    <Network class="w-8 h-8 text-amber-400 mx-auto group-hover:scale-110 transition" />
                    <div class="text-sm font-bold text-white mt-3">Kelola Rule</div>
                </Link>

                <Link
                    :href="route('admin.mahasiswa.index')"
                    class="bg-slate-800/90 border border-slate-700 hover:border-sky-500 p-5 rounded-2xl shadow-xl transition text-center group"
                >
                    <Users class="w-8 h-8 text-sky-400 mx-auto group-hover:scale-110 transition" />
                    <div class="text-sm font-bold text-white mt-3">Data Mahasiswa</div>
                </Link>

                <Link
                    :href="route('admin.laporan.index')"
                    class="bg-slate-800/90 border border-slate-700 hover:border-rose-500 p-5 rounded-2xl shadow-xl transition text-center group sm:col-span-2 lg:col-span-1"
                >
                    <FileText class="w-8 h-8 text-rose-400 mx-auto group-hover:scale-110 transition" />
                    <div class="text-sm font-bold text-white mt-3">Laporan Diagnosa</div>
                </Link>
            </div>
        </main>

        <footer class="text-center py-4 text-xs text-slate-500">
            &copy; {{ new Date().getFullYear() }} Panel Administrator Sistem Pakar Depresi
        </footer>
    </div>
</template>
