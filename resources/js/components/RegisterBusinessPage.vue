<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import AppHeader from './AppHeader.vue';
import AppFooter from './AppFooter.vue';
import ScrollToTop from './ScrollToTop.vue';

const form = ref({
    name: '',
    industry_id: '',
    city: 'Prishtinë',
    region: 'Kosovë',
    website: '',
    email: '',
    phone: '',
    size_band: '51-200',
    description: '',
    ip_start: '',
    ip_end: '',
    ip_label: 'HQ',
    contact_name: '',
});

const industries = ref([]);
const loading = ref(false);
const errors = ref({});
const success = ref(null);

const sizeBands = [
    { value: '1-10', label: '1–10 punonjës' },
    { value: '11-50', label: '11–50' },
    { value: '51-200', label: '51–200' },
    { value: '201-500', label: '201–500' },
    { value: '500+', label: '500+' },
];

async function loadIndustries() {
    try {
        const { data } = await axios.get('/api/v1/industries');
        industries.value = data.data ?? [];
    } catch (e) {
        console.error('[IPKO] Failed to load industries', e);
    }
}

async function submit() {
    loading.value = true;
    errors.value = {};
    success.value = null;

    try {
        const { data } = await axios.post('/api/v1/businesses/register', {
            ...form.value,
            industry_id: Number(form.value.industry_id),
        });

        success.value = data;
        form.value = {
            name: '',
            industry_id: '',
            city: 'Prishtinë',
            region: 'Kosovë',
            website: '',
            email: '',
            phone: '',
            size_band: '51-200',
            description: '',
            ip_start: '',
            ip_end: '',
            ip_label: 'HQ',
            contact_name: '',
        };
    } catch (e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors ?? {};
        } else {
            errors.value = { form: ['Gabim në server. Provoni përsëri.'] };
        }
    } finally {
        loading.value = false;
    }
}

function fieldError(key) {
    const e = errors.value[key];
    return e ? e[0] : null;
}

onMounted(loadIndustries);
</script>

<template>
    <div class="flex min-h-screen flex-col bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
        <AppHeader active="register" />

        <main class="mx-auto w-full max-w-2xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white">
                    Regjistro biznesin në IPKO.ai
                </h1>
                <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                    Shtoni kompaninë tuaj në regjistrin B2B të Kosovës me intervalin IP korporativ.
                    Pas verifikimit, vizitorët nga rrjeti juaj identifikohen automatikisht në dashboard.
                </p>
            </div>

            <div
                v-if="success"
                class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-900 dark:bg-emerald-950/40"
            >
                <p class="font-semibold text-emerald-800 dark:text-emerald-300">{{ success.message }}</p>
                <p v-if="success.data" class="mt-1 text-sm text-emerald-700 dark:text-emerald-400">
                    {{ success.data.name }} · {{ success.data.city }}
                    <span v-if="success.data.is_verified" class="ml-1">(✓ aktiv)</span>
                    <span v-else class="ml-1">(në pritje verifikimi)</span>
                </p>
                <p class="mt-2 text-xs text-emerald-700/90 dark:text-emerald-400/90">
                    Shfaqet në Dashboard te <strong>Business Registry</strong> dhe <strong>Identified Businesses</strong>.
                    Për scoring live, vendosni tracker-in dhe vizitoni faqen nga IP-ja e regjistruar.
                </p>
                <a href="/dashboard" class="mt-3 inline-block text-sm font-medium text-ipko-600 hover:underline dark:text-ipko-400">
                    Shko te Dashboard →
                </a>
            </div>

            <form class="ipko-card space-y-6 p-5 sm:p-8" @submit.prevent="submit">
                <p v-if="errors.form" class="text-sm text-rose-600">{{ errors.form[0] }}</p>

                <fieldset class="space-y-4">
                    <legend class="text-sm font-semibold uppercase tracking-wider text-slate-500">Biznesi</legend>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Emri i biznesit *</label>
                        <input
                            v-model="form.name"
                            type="text"
                            required
                            class="mt-1 w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800"
                            placeholder="p.sh. NLB Banka HQ"
                        />
                        <p v-if="fieldError('name')" class="mt-1 text-xs text-rose-600">{{ fieldError('name') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Sektori *</label>
                        <select
                            v-model="form.industry_id"
                            required
                            class="mt-1 w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800"
                        >
                            <option value="" disabled>Zgjidhni industrinë</option>
                            <option v-for="ind in industries" :key="ind.id" :value="ind.id">
                                {{ ind.icon }} {{ ind.name }}
                            </option>
                        </select>
                        <p v-if="fieldError('industry_id')" class="mt-1 text-xs text-rose-600">{{ fieldError('industry_id') }}</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Qyteti *</label>
                            <input v-model="form.city" type="text" required class="mt-1 w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Madhësia</label>
                            <select v-model="form.size_band" class="mt-1 w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800">
                                <option v-for="s in sizeBands" :key="s.value" :value="s.value">{{ s.label }}</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Website</label>
                        <input v-model="form.website" type="url" class="mt-1 w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800" placeholder="https://" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Përshkrimi</label>
                        <textarea v-model="form.description" rows="3" class="mt-1 w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800" />
                    </div>
                </fieldset>

                <fieldset class="space-y-4 border-t border-slate-200 pt-6 dark:border-slate-700">
                    <legend class="text-sm font-semibold uppercase tracking-wider text-slate-500">IP korporativ *</legend>
                    <p class="text-xs text-slate-500">
                        Intervali publik i rrjetit të zyrës (p.sh. nga IT ose ISP). Vizitorët nga këto IP identifikohen si ky biznes.
                    </p>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium">IP fillimi</label>
                            <input v-model="form.ip_start" type="text" required placeholder="185.132.50.0" class="mt-1 w-full rounded-lg border-slate-300 font-mono text-sm dark:border-slate-600 dark:bg-slate-800" />
                            <p v-if="fieldError('ip_start')" class="mt-1 text-xs text-rose-600">{{ fieldError('ip_start') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">IP fundi</label>
                            <input v-model="form.ip_end" type="text" required placeholder="185.132.50.255" class="mt-1 w-full rounded-lg border-slate-300 font-mono text-sm dark:border-slate-600 dark:bg-slate-800" />
                            <p v-if="fieldError('ip_end')" class="mt-1 text-xs text-rose-600">{{ fieldError('ip_end') }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Etiketa (HQ, Degë…)</label>
                        <input v-model="form.ip_label" type="text" class="mt-1 w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800" />
                    </div>
                </fieldset>

                <fieldset class="space-y-4 border-t border-slate-200 pt-6 dark:border-slate-700">
                    <legend class="text-sm font-semibold uppercase tracking-wider text-slate-500">Kontakti</legend>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium">Personi kontaktues</label>
                            <input v-model="form.contact_name" type="text" class="mt-1 w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Email</label>
                            <input v-model="form.email" type="email" class="mt-1 w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Telefoni</label>
                        <input v-model="form.phone" type="tel" class="mt-1 w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800" />
                    </div>
                </fieldset>

                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full rounded-xl bg-gradient-to-r from-ipko-600 to-ipko-500 py-3 text-sm font-semibold text-white shadow-lg shadow-ipko-500/25 transition hover:opacity-95 disabled:opacity-60"
                >
                    {{ loading ? 'Duke regjistruar…' : 'Regjistro biznesin' }}
                </button>
            </form>

            <div class="mt-8 rounded-xl border border-slate-200 bg-slate-100/80 p-4 text-sm text-slate-600 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-400">
                <strong class="text-slate-800 dark:text-slate-200">API (programatik):</strong>
                <code class="mt-2 block rounded bg-slate-900 p-3 text-xs text-slate-300">POST /api/v1/businesses/register</code>
            </div>
        </main>

        <AppFooter />
        <ScrollToTop />
    </div>
</template>
