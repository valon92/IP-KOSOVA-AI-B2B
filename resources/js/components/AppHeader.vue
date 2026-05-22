<script setup>
import { ref, onMounted } from 'vue';

defineProps({
    active: {
        type: String,
        default: 'dashboard',
    },
});

const darkMode = ref(false);

function toggleDarkMode() {
    darkMode.value = !darkMode.value;
    document.documentElement.classList.toggle('dark', darkMode.value);
    localStorage.setItem('ipko_dark_mode', darkMode.value ? '1' : '0');
}

onMounted(() => {
    const saved = localStorage.getItem('ipko_dark_mode');
    if (saved === '1') {
        darkMode.value = true;
        document.documentElement.classList.add('dark');
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
                    <p class="text-xs text-slate-500 dark:text-slate-400">B2B IP Intelligence · Kosovo</p>
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
                    href="/info"
                    class="rounded-lg px-2.5 py-2 text-xs font-medium transition sm:px-3 sm:text-sm"
                    :class="active === 'info'
                        ? 'bg-ipko-50 text-ipko-700 dark:bg-ipko-950 dark:text-ipko-300'
                        : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                >
                    Info
                </a>
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
