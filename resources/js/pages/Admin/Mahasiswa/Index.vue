<script setup lang="ts">
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Users, Trash2, ArrowLeft, Search } from 'lucide-vue-next';

interface Mahasiswa {
    id: number;
    nim: string | null;
    name: string;
    email: string;
    jk: string | null;
    umur: number | null;
    prodi: string | null;
    semester: number | null;
}

const props = defineProps<{
    mahasiswaList: Mahasiswa[];
    search?: string;
}>();

const searchInput = ref(props.search || '');

const handleSearch = () => {
    router.get(route('admin.mahasiswa.index'), { search: searchInput.value }, { preserveState: true });
};

const deleteForm = useForm({});
const deleteMahasiswa = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus data akun mahasiswa ini beserta seluruh riwayat diagnosanya?')) {
        deleteForm.delete(route('admin.mahasiswa.destroy', id));
    }
};
</script>

<template>
    <Head title="Data Mahasiswa" />

    <div class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between">
        <header class="border-b border-slate-800 bg-slate-900/90 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-sky-600 rounded-xl">
                        <Users class="w-5 h-5 text-white" />
                    </div>
                    <span class="font-bold text-white">Data Mahasiswa Terdaftar</span>
                </div>

                <Link
                    :href="route('admin.dashboard')"
                    class="text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 px-3.5 py-2 rounded-lg border border-slate-700 transition flex items-center space-x-1.5"
                >
                    <ArrowLeft class="w-4 h-4" />
                    <span>Dashboard</span>
                </Link>
            </div>
        </header>

        <main class="max-w-7xl mx-auto w-full px-4 py-8 flex-grow space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">Data Mahasiswa</h1>
                    <p class="text-xs text-slate-400 mt-1">Daftar pengguna terdaftar bertipe Mahasiswa.</p>
                </div>

                <!-- SEARCH -->
                <div class="relative w-full sm:w-72">
                    <input
                        v-model="searchInput"
                        @keyup.enter="handleSearch"
                        type="text"
                        placeholder="Cari NIM, Nama, Email..."
                        class="w-full bg-slate-800 border border-slate-700 rounded-xl pl-9 pr-4 py-2 text-xs text-white focus:outline-none focus:border-sky-500"
                    />
                    <Search class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" />
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
                                <th class="py-3.5 px-4">Email</th>
                                <th class="py-3.5 px-4">JK</th>
                                <th class="py-3.5 px-4">Umur</th>
                                <th class="py-3.5 px-4">Program Studi</th>
                                <th class="py-3.5 px-4 w-20 text-center">Semester</th>
                                <th class="py-3.5 px-4 w-20 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700/60 text-xs">
                            <tr v-if="props.mahasiswaList.length === 0">
                                <td colspan="9" class="py-8 text-center text-slate-500">Tidak ada data mahasiswa ditemukan.</td>
                            </tr>

                            <tr v-for="(m, idx) in props.mahasiswaList" :key="m.id" class="hover:bg-slate-700/30 transition">
                                <td class="py-3.5 px-4 text-center text-slate-500">{{ idx + 1 }}</td>
                                <td class="py-3.5 px-4 font-mono font-bold text-sky-400">{{ m.nim || '-' }}</td>
                                <td class="py-3.5 px-4 font-bold text-white">{{ m.name }}</td>
                                <td class="py-3.5 px-4 text-slate-300">{{ m.email }}</td>
                                <td class="py-3.5 px-4 text-slate-300">{{ m.jk || '-' }}</td>
                                <td class="py-3.5 px-4 text-slate-300">{{ m.umur ? m.umur + ' Thn' : '-' }}</td>
                                <td class="py-3.5 px-4 text-slate-300">{{ m.prodi || '-' }}</td>
                                <td class="py-3.5 px-4 text-center font-bold text-slate-200">{{ m.semester || '-' }}</td>
                                <td class="py-3.5 px-4 text-center">
                                    <button
                                        @click="deleteMahasiswa(m.id)"
                                        class="p-1.5 bg-rose-600/20 text-rose-300 hover:bg-rose-600 hover:text-white rounded-lg transition"
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
            &copy; {{ new Date().getFullYear() }} Panel Administrator Sistem Pakar Depresi
        </footer>
    </div>
</template>
