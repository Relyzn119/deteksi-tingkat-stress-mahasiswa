<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Brain, Plus, Edit, Trash2, ArrowLeft, X } from 'lucide-vue-next';

interface Penyakit {
    id: number;
    kode_penyakit: string;
    nama_penyakit: string;
    deskripsi: string;
    solusi: string;
}

const props = defineProps<{
    penyakitList: Penyakit[];
}>();

const showModal = ref(false);
const editingId = ref<number | null>(null);

const form = useForm({
    kode_penyakit: '',
    nama_penyakit: '',
    deskripsi: '',
    solusi: '',
});

const openAddModal = () => {
    editingId.value = null;
    form.reset();
    showModal.value = true;
};

const openEditModal = (p: Penyakit) => {
    editingId.value = p.id;
    form.kode_penyakit = p.kode_penyakit;
    form.nama_penyakit = p.nama_penyakit;
    form.deskripsi = p.deskripsi;
    form.solusi = p.solusi;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const submit = () => {
    if (editingId.value) {
        form.put(route('admin.penyakit.update', editingId.value), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('admin.penyakit.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteForm = useForm({});
const deletePenyakit = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus data tingkat depresi ini?')) {
        deleteForm.delete(route('admin.penyakit.destroy', id));
    }
};
</script>

<template>
    <Head title="Kelola Tingkat Depresi" />

    <div class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between">
        <header class="border-b border-slate-800 bg-slate-900/90 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-emerald-600 rounded-xl">
                        <Brain class="w-5 h-5 text-white" />
                    </div>
                    <span class="font-bold text-white">Data Tingkat Depresi</span>
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
                    <h1 class="text-2xl font-bold text-white">Kelola Tingkat Depresi (Penyakit)</h1>
                    <p class="text-xs text-slate-400 mt-1">Daftar kategori tingkat depresi beserta deskripsi klinis & rekomendasi solusi.</p>
                </div>

                <button
                    @click="openAddModal"
                    class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-emerald-600/30 transition flex items-center space-x-1.5"
                >
                    <Plus class="w-4 h-4" />
                    <span>Tambah Data</span>
                </button>
            </div>

            <!-- TABLE -->
            <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-950/80 text-xs uppercase text-slate-400 border-b border-slate-700">
                            <tr>
                                <th class="py-3.5 px-4 w-12 text-center">No</th>
                                <th class="py-3.5 px-4 w-20">Kode</th>
                                <th class="py-3.5 px-4 w-44">Tingkat Depresi</th>
                                <th class="py-3.5 px-4">Deskripsi</th>
                                <th class="py-3.5 px-4">Solusi</th>
                                <th class="py-3.5 px-4 w-28 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700/60 text-xs">
                            <tr v-for="(p, idx) in props.penyakitList" :key="p.id" class="hover:bg-slate-700/30 transition">
                                <td class="py-3.5 px-4 text-center text-slate-500">{{ idx + 1 }}</td>
                                <td class="py-3.5 px-4 font-mono font-bold text-emerald-400">{{ p.kode_penyakit }}</td>
                                <td class="py-3.5 px-4 font-bold text-white">{{ p.nama_penyakit }}</td>
                                <td class="py-3.5 px-4 text-slate-300 leading-relaxed max-w-xs">{{ p.deskripsi }}</td>
                                <td class="py-3.5 px-4 text-slate-300 leading-relaxed max-w-xs">{{ p.solusi }}</td>
                                <td class="py-3.5 px-4 text-center space-x-1.5">
                                    <button
                                        @click="openEditModal(p)"
                                        class="p-1.5 bg-amber-600/20 text-amber-300 hover:bg-amber-600 hover:text-white rounded-lg transition"
                                    >
                                        <Edit class="w-4 h-4" />
                                    </button>

                                    <button
                                        @click="deletePenyakit(p.id)"
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

        <!-- FORM MODAL -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4">
            <div class="bg-slate-800 border border-slate-700 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
                <div class="flex justify-between items-center border-b border-slate-700 pb-3">
                    <h3 class="font-bold text-white text-base">{{ editingId ? 'Edit Data Depresi' : 'Tambah Data Depresi' }}</h3>
                    <button @click="closeModal" class="text-slate-400 hover:text-white"><X class="w-5 h-5" /></button>
                </div>

                <form @submit.prevent="submit" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Kode Penyakit</label>
                        <input v-model="form.kode_penyakit" type="text" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-white" required placeholder="Contoh: P01" />
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Nama Tingkat Depresi</label>
                        <input v-model="form.nama_penyakit" type="text" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-white" required placeholder="Contoh: Depresi Berat" />
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Deskripsi</label>
                        <textarea v-model="form.deskripsi" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-white" required></textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Solusi / Rekomendasi</label>
                        <textarea v-model="form.solusi" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-white" required></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-2">
                        <button type="button" @click="closeModal" class="px-4 py-2 bg-slate-700 text-slate-300 rounded-xl hover:bg-slate-600">Batal</button>
                        <button type="submit" :disabled="form.processing" class="px-5 py-2 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-500">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <footer class="text-center py-4 text-xs text-slate-500">
            &copy; {{ new Date().getFullYear() }} Panel Administrator Sistem Pakar Depresi
        </footer>
    </div>
</template>
