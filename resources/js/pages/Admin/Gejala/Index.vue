<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Stethoscope, Plus, Edit, Trash2, ArrowLeft, X } from 'lucide-vue-next';

interface Gejala {
    id: number;
    kode_gejala: string;
    nama_gejala: string;
    jenis_gejala: 'utama' | 'tambahan';
    cf_pakar: number;
}

const props = defineProps<{
    gejalaList: Gejala[];
}>();

const showModal = ref(false);
const editingId = ref<number | null>(null);

const form = useForm({
    kode_gejala: '',
    nama_gejala: '',
    jenis_gejala: 'utama' as 'utama' | 'tambahan',
    cf_pakar: 0.8,
});

const openAddModal = () => {
    editingId.value = null;
    form.reset();
    showModal.value = true;
};

const openEditModal = (g: Gejala) => {
    editingId.value = g.id;
    form.kode_gejala = g.kode_gejala;
    form.nama_gejala = g.nama_gejala;
    form.jenis_gejala = g.jenis_gejala;
    form.cf_pakar = g.cf_pakar;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const submit = () => {
    if (editingId.value) {
        form.put(route('admin.gejala.update', editingId.value), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('admin.gejala.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteForm = useForm({});
const deleteGejala = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus gejala ini?')) {
        deleteForm.delete(route('admin.gejala.destroy', id));
    }
};
</script>

<template>
    <Head title="Kelola Gejala" />

    <div class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between">
        <header class="border-b border-slate-800 bg-slate-900/90 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-indigo-600 rounded-xl">
                        <Stethoscope class="w-5 h-5 text-white" />
                    </div>
                    <span class="font-bold text-white">Data Gejala Depresi</span>
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
                    <h1 class="text-2xl font-bold text-white">Kelola Gejala Depresi</h1>
                    <p class="text-xs text-slate-400 mt-1">Daftar gejala utama & tambahan beserta bobot Certainty Factor (CF Pakar).</p>
                </div>

                <button
                    @click="openAddModal"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-indigo-600/30 transition flex items-center space-x-1.5"
                >
                    <Plus class="w-4 h-4" />
                    <span>Tambah Gejala</span>
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
                                <th class="py-3.5 px-4">Nama Gejala</th>
                                <th class="py-3.5 px-4 w-32 text-center">Jenis</th>
                                <th class="py-3.5 px-4 w-24 text-center">CF Pakar</th>
                                <th class="py-3.5 px-4 w-28 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700/60 text-xs">
                            <tr v-for="(g, idx) in props.gejalaList" :key="g.id" class="hover:bg-slate-700/30 transition">
                                <td class="py-3.5 px-4 text-center text-slate-500">{{ idx + 1 }}</td>
                                <td class="py-3.5 px-4 font-mono font-bold text-indigo-400">{{ g.kode_gejala }}</td>
                                <td class="py-3.5 px-4 text-white font-medium">{{ g.nama_gejala }}</td>
                                <td class="py-3.5 px-4 text-center">
                                    <span v-if="g.jenis_gejala === 'utama'" class="px-2.5 py-1 text-[10px] font-bold bg-rose-950/80 text-rose-300 border border-rose-700/50 rounded-lg">
                                        Gejala Utama
                                    </span>
                                    <span v-else class="px-2.5 py-1 text-[10px] font-medium bg-slate-700 text-slate-300 rounded-lg">
                                        Gejala Tambahan
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono font-bold text-emerald-400">{{ g.cf_pakar }}</td>
                                <td class="py-3.5 px-4 text-center space-x-1.5">
                                    <button
                                        @click="openEditModal(g)"
                                        class="p-1.5 bg-amber-600/20 text-amber-300 hover:bg-amber-600 hover:text-white rounded-lg transition"
                                    >
                                        <Edit class="w-4 h-4" />
                                    </button>

                                    <button
                                        @click="deleteGejala(g.id)"
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
                    <h3 class="font-bold text-white text-base">{{ editingId ? 'Edit Gejala' : 'Tambah Gejala Baru' }}</h3>
                    <button @click="closeModal" class="text-slate-400 hover:text-white"><X class="w-5 h-5" /></button>
                </div>

                <form @submit.prevent="submit" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Kode Gejala</label>
                        <input v-model="form.kode_gejala" type="text" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-white" required placeholder="Contoh: G01" />
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Nama / Pertanyaan Gejala</label>
                        <textarea v-model="form.nama_gejala" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-white" required></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-slate-300 mb-1">Jenis Gejala</label>
                            <select v-model="form.jenis_gejala" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-white" required>
                                <option value="utama">Utama</option>
                                <option value="tambahan">Tambahan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-300 mb-1">CF Pakar (0 - 1.0)</label>
                            <input v-model="form.cf_pakar" type="number" step="0.1" min="0" max="1" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-white" required />
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-2">
                        <button type="button" @click="closeModal" class="px-4 py-2 bg-slate-700 text-slate-300 rounded-xl hover:bg-slate-600">Batal</button>
                        <button type="submit" :disabled="form.processing" class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-500">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <footer class="text-center py-4 text-xs text-slate-500">
            &copy; {{ new Date().getFullYear() }} Panel Administrator Sistem Pakar Depresi
        </footer>
    </div>
</template>
