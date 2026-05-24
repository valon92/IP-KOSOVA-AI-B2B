<script setup>
import { ref, onMounted } from 'vue';
import api from '../api/client';

defineProps({
    active: {
        type: String,
        default: 'dashboard',
    },
    showSession: { type: Boolean, default: false },
});

const darkMode = ref(false);
const sessionUser = ref(null);
const loggingOut = ref(false);

function toggleDarkMode() {
    darkMode.value = !darkMode.value;
    document.documentElement.classList.toggle('dark', darkMode.value);
    localStorage.setItem('ipko_dark_mode', darkMode.value ? '1' : '0');
}

async function loadSession() {
    try {
        const { data } = await api.get('/auth/me');
        sessionUser.value = data.data;
    } catch {
        sessionUser.value = null;
    }
}

async function logout() {
    loggingOut.value = true;
    try {
        await fetch('/logout', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
            },
            credentials: 'include',
        });
    } finally {
        window.location.href = '/login';
    }
}

onMounted(() => {
    const saved = localStorage.getItem('ipko_dark_mode');
    if (saved === '1') {
        darkMode.value = true;
        document.documentElement.classList.add('dark');
    }
    if (document.getElementById('ipko-dashboard')) {
        loadSession();
    }
});
</script>

<template>
    <header class="sticky top-0 z-20 border-b border-slate-200/80 bg-white/80 backdrop-blur-lg dark:border-slate-800 dark:bg-slate-900/80">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-3 py-3 sm:px-6 sm:py-4 lg:px-8">
            <a href="/dashboard" class="flex items-center gap-3 transition opacity-90 hover:opacity-100">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-ipko-500 to-ipko-700 text-lg font-bold text-white shadow-lg shadow-ipko-500/25">
                    IP
                </div>
                <div>
                    <p class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">IPKO.ai</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        <span v-if="sessionUser">{{ sessionUser.name }}</span>
                        <span v-else>B2B IP Intelligence · Kosovo</span>
                    </p>
                </div>
            </a>

            <nav class="flex items-center gap-1 sm:gap-2">
                <a
                    href="/dashboard"
                    class="rounded-lg px-2.5 py-2 text-xs font-medium transition sm:px-3 sm:text-sm"
                    :class="active === 'dashboard'
                        ? 'bg-ipko-50 text-ipko-700 dark:bg-ipko-950 dark:text-ipko-300'
                        : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                >
                    Dashboard
                </a>
                <a
                    href="/register-business"
                    class="hidden rounded-lg px-2.5 py-2 text-xs font-medium transition sm:inline-block sm:px-3 sm:text-sm"
                    :class="active === 'register'
                        ? 'bg-ipko-50 text-ipko-700 dark:bg-ipko-950 dark:text-ipko-300'
                        : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                >
                    Regjistro
                </a>
                <a
                    href="/info"
                    class="rounded-lg px-2.5 py-2 text-xs font-medium transition sm:px-3 sm:text-sm"
                    :class="active === 'info'
                        ? 'bg-ipko-50 text-ipko-700 dark:bg-ipko-950 dark:text-ipko-300'
                        : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                >
                    Info
                </a>
                <button
                    v-if="sessionUser"
                    type="button"
                    class="hidden rounded-lg border border-slate-200 px-2.5 py-2 text-xs font-medium text-slate-600 transition hover:bg-slate-100 sm:inline-block dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                    :disabled="loggingOut"
                    @click="logout"
                >
                    Dil
                </button>
                <button
                    type="button"
                    class="ml-1 rounded-lg border border-slate-200 px-2.5 py-2 text-sm transition hover:bg-slate-100 dark:border-slate-700 dark:hover:bg-slate-800"
                    @click="toggleDarkMode"
                    :aria-label="darkMode ? 'Light mode' : 'Dark mode'"
                >
                    {{ darkMode ? '☀️' : '🌙' }}
                </button>
            </nav>
        </div>
    </header>
</template>
