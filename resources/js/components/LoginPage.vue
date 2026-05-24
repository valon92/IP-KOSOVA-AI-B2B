<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AppFooter from './AppFooter.vue';

const form = ref({
    email: '',
    password: '',
    remember: true,
});

const loading = ref(false);
const errors = ref({});
const sessionExpired = ref(false);

onMounted(() => {
    sessionExpired.value = new URLSearchParams(window.location.search).has('expired');
});

async function submit() {
    loading.value = true;
    errors.value = {};

    try {
        await axios.get('/sanctum/csrf-cookie', { withCredentials: true });
        await axios.post('/login', form.value, {
            withCredentials: true,
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
            },
        });
        window.location.href = '/dashboard';
    } catch (e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors ?? {};
        } else {
            errors.value = { email: ['Gabim në login. Provoni përsëri.'] };
        }
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <div class="flex min-h-screen flex-col bg-slate-50 dark:bg-slate-950">
        <div class="flex flex-1 items-center justify-center px-4 py-12">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-ipko-500 to-ipko-700 text-xl font-bold text-white shadow-lg shadow-ipko-500/30">
                        IP
                    </div>
                    <h1 class="mt-4 text-2xl font-bold text-slate-900 dark:text-white">IPKO.ai</h1>
                    <p class="mt-1 text-sm text-slate-500">Hyrje për klientët B2B</p>
                </div>

                <form class="ipko-card space-y-5 p-6 sm:p-8" @submit.prevent="submit">
                    <p
                        v-if="sessionExpired"
                        class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-sm text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/40 dark:text-amber-200"
                    >
                        Sesioni skadoi ose API nuk njihet nga browser-i. Hyni përsëri.
                    </p>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            autocomplete="email"
                            class="mt-1 w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800"
                            placeholder="demo@ipko.ai"
                        />
                        <p v-if="errors.email" class="mt-1 text-xs text-rose-600">{{ errors.email[0] }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Fjalëkalimi</label>
                        <input
                            v-model="form.password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="mt-1 w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800"
                        />
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <input v-model="form.remember" type="checkbox" class="rounded border-slate-300 text-ipko-600" />
                        Më mbaj mend
                    </label>

                    <button
                        type="submit"
                        :disabled="loading"
                        class="w-full rounded-xl bg-gradient-to-r from-ipko-600 to-ipko-500 py-3 text-sm font-semibold text-white shadow-lg shadow-ipko-500/25 transition hover:opacity-95 disabled:opacity-60"
                    >
                        {{ loading ? 'Duke u kyçur…' : 'Hyr në platformë' }}
                    </button>
                </form>

                <p class="mt-6 text-center text-xs text-slate-500">
                    <a href="/info" class="text-ipko-600 hover:underline dark:text-ipko-400">Info</a>
                    ·
                    <a href="/register-business" class="text-ipko-600 hover:underline dark:text-ipko-400">Regjistro biznesin</a>
                </p>
            </div>
        </div>
        <AppFooter />
    </div>
</template>
