<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { User, GraduationCap, Calendar, Hash, ArrowRight, LogOut, Stethoscope } from 'lucide-vue-next';

const props = defineProps<{
    user: {
        id: number;
        name: string;
        email: string;
        nim: string | null;
        jk: string | null;
        umur: number | null;
        prodi: string | null;
        semester: number | null;
    };
}>();

const form = useForm({
    nim: props.user.nim || '',
    name: props.user.name || '',
    jk: props.user.jk || 'Laki-laki',
    umur: props.user.umur || 21,
    prodi: props.user.prodi || 'Teknik Informatika',
    semester: props.user.semester || 8,
});

const submit = () => {
    form.post(route('user.profile.update'));
};
</script>

<template>
    <Head title="Profil Mahasiswa" />

    <div class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between">
        <!-- HEADER NAV -->
        <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-indigo-600 rounded-xl">
                        <GraduationCap class="w-5 h-5 text-white" />
                    </div>
                    <span class="font-bold text-white">Panel Mahasiswa</span>
                </div>

                <div class="flex items-center space-x-4">
                    <span class="text-sm text-slate-300 hidden sm:inline">{{ props.user.name }}</span>
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

        <!-- MAIN CONTAINER -->
        <main class="max-w-3xl mx-auto w-full px-4 py-8 flex-grow">
            <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-6 sm:p-8 shadow-2xl space-y-6">
                <div>
                    <h1 class="text-2xl font-bold text-white flex items-center space-x-2">
                        <User class="w-6 h-6 text-indigo-400" />
                        <span>Lengkapi Profil Mahasiswa</span>
                    </h1>
                    <p class="text-xs text-slate-400 mt-1">
                        Informasi profil akademik Anda akan digunakan sebagai data identifikasi hasil diagnosa depresi.
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">NIM (Nomor Induk Mahasiswa)</label>
                            <input
                                v-model="form.nim"
                                type="text"
                                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500"
                                placeholder="Masukkan NIM"
                                required
                            />
                            <div v-if="form.errors.nim" class="text-xs text-rose-400 mt-1">{{ form.errors.nim }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Lengkap</label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500"
                                required
                            />
                            <div v-if="form.errors.name" class="text-xs text-rose-400 mt-1">{{ form.errors.name }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Jenis Kelamin</label>
                            <select
                                v-model="form.jk"
                                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500"
                                required
                            >
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Umur (Tahun)</label>
                            <input
                                v-model="form.umur"
                                type="number"
                                min="15"
                                max="80"
                                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500"
                                required
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Semester</label>
                            <input
                                v-model="form.semester"
                                type="number"
                                min="1"
                                max="14"
                                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500"
                                required
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Program Studi</label>
                        <select
                            v-model="form.prodi"
                            class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500"
                            required
                        >
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Pendidikan Teknologi Informasi">Pendidikan Teknologi Informasi</option>
                            <option value="Teknik Elektro">Teknik Elektro</option>
                            <option value="Manajemen Informatika">Manajemen Informatika</option>
                        </select>
                    </div>

                    <div class="pt-4 flex items-center justify-between">
                        <Link
                            :href="route('diagnosa.create')"
                            class="inline-flex items-center space-x-1.5 text-xs text-slate-400 hover:text-slate-200 transition"
                        >
                            <Stethoscope class="w-4 h-4 text-emerald-400" />
                            <span>Langsung ke Diagnosa</span>
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-indigo-600/30 transition disabled:opacity-50"
                        >
                            <span>Simpan Profil & Lanjut</span>
                            <ArrowRight class="w-4 h-4" />
                        </button>
                    </div>
                </form>
            </div>
        </main>

        <footer class="text-center py-4 text-xs text-slate-500">
            &copy; {{ new Date().getFullYear() }} Sistem Pakar Tingkat Depresi Mahasiswa
        </footer>
    </div>
</template>
