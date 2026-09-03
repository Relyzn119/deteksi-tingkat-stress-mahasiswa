<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Network, Plus, Trash2, ArrowLeft, X } from 'lucide-vue-next';

interface Penyakit {
    id: number;
    kode_penyakit: string;
    nama_penyakit: string;
}

interface Gejala {
    id: number;
    kode_gejala: string;
    nama_gejala: string;
}

interface Aturan {
    id: number;
    penyakit_id: number;
    gejala_id: number;
    penyakit: Penyakit;
    gejala: Gejala;
}

const props = defineProps<{
    aturanList: Aturan[];
    penyakitList: Penyakit[];
    gejalaList: Gejala[];
}>();

const showModal = ref(false);

const form = useForm({
    penyakit_id: props.penyakitList[0]?.id || '',
    gejala_id: props.gejalaList[0]?.id || '',
});

const openAddModal = () => {
    form.reset();
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const submit = () => {
    form.post(route('admin.aturan.store'), {
        onSuccess: () => closeModal(),
    });
};

const deleteForm = useForm({});
const deleteAturan = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus relasi aturan ini?')) {
        deleteForm.delete(route('admin.aturan.destroy', id));
    }
};
</script>

<template>
    <Head title="Basis Pengetahuan (Rule)" />

    <div class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between">
        <header class="border-b border-slate-800 bg-slate-900/90 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-amber-600 rounded-xl">
                        <Network class="w-5 h-5 text-white" />
                    </div>
                    <span class="font-bold text-white">Basis Pengetahuan (Rule)</span>
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
                    <h1 class="text-2xl font-bold text-white">Basis Pengetahuan (Rule Database)</h1>
                    <p class="text-xs text-slate-400 mt-1">Pemetaan relasi antara kategori tingkat depresi (Penyakit) dan Gejala indikasi.</p>
                </div>

                <button
                    @click="openAddModal"
                    class="bg-amber-600 hover:bg-amber-500 text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-amber-600/30 transition flex items-center space-x-1.5"
                >
                    <Plus class="w-4 h-4" />
                    <span>Tambah Rule Baru</span>
                </button>
            </div>

            <!-- TABLE -->
            <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-950/80 text-xs uppercase text-slate-400 border-b border-slate-700">
                            <tr>
                                <th class="py-3.5 px-4 w-12 text-center">No</th>
                                <th class="py-3.5 px-4 w-64">Tingkat Depresi (Penyakit)</th>
                                <th class="py-3.5 px-4">Gejala Indikasi</th>
                                <th class="py-3.5 px-4 w-24 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700/60 text-xs">
                            <tr v-for="(r, idx) in props.aturanList" :key="r.id" class="hover:bg-slate-700/30 transition">
                                <td class="py-3.5 px-4 text-center text-slate-500">{{ idx + 1 }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="font-mono font-bold text-emerald-400 mr-2">[{{ r.penyakit?.kode_penyakit }}]</span>
                                    <span class="font-bold text-white">{{ r.penyakit?.nama_penyakit }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-mono font-bold text-indigo-400 mr-2">[{{ r.gejala?.kode_gejala }}]</span>
                                    <span class="text-slate-300">{{ r.gejala?.nama_gejala }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <button
                                        @click="deleteAturan(r.id)"
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
                    <h3 class="font-bold text-white text-base">Tambah Rule / Aturan Baru</h3>
                    <button @click="closeModal" class="text-slate-400 hover:text-white"><X class="w-5 h-5" /></button>
                </div>

                <form @submit.prevent="submit" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Penyakit / Tingkat Depresi</label>
                        <select v-model="form.penyakit_id" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-white" required>
                            <option v-for="p in props.penyakitList" :key="p.id" :value="p.id">
                                [{{ p.kode_penyakit }}] - {{ p.nama_penyakit }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Gejala Indikasi</label>
                        <select v-model="form.gejala_id" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-white" required>
                            <option v-for="g in props.gejalaList" :key="g.id" :value="g.id">
                                [{{ g.kode_gejala }}] - {{ g.nama_gejala }}
                            </option>
                        </select>
                    </div>

                    <div v-if="form.errors.penyakit_id" class="text-rose-400 font-semibold">
                        {{ form.errors.penyakit_id }}
                    </div>

                    <div class="flex justify-end space-x-3 pt-2">
                        <button type="button" @click="closeModal" class="px-4 py-2 bg-slate-700 text-slate-300 rounded-xl hover:bg-slate-600">Batal</button>
                        <button type="submit" :disabled="form.processing" class="px-5 py-2 bg-amber-600 text-white font-semibold rounded-xl hover:bg-amber-500">Simpan Rule</button>
                    </div>
                </form>
            </div>
        </div>

        <footer class="text-center py-4 text-xs text-slate-500">
            &copy; {{ new Date().getFullYear() }} Panel Administrator Sistem Pakar Depresi
        </footer>
    </div>
</template>
