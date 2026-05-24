<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import AppHeader from './AppHeader.vue';
import AppFooter from './AppFooter.vue';
import ScrollToTop from './ScrollToTop.vue';

const loading = ref(true);
const error = ref(null);
const status = ref(null);
let pollTimer = null;

const overall = computed(() => status.value?.status ?? 'unknown');
const overallLabel = computed(() => status.value?.status_label ?? 'Duke u ngarkuar…');

const statusTheme = computed(() => {
    if (overall.value === 'operational') {
        return {
            banner: 'border-emerald-200/80 bg-emerald-50/80 dark:border-emerald-900/50 dark:bg-emerald-950/40',
            dot: 'bg-emerald-500',
            ping: 'bg-emerald-400',
            text: 'text-emerald-800 dark:text-emerald-200',
            badge: 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-200',
        };
    }
    if (overall.value === 'degraded') {
        return {
            banner: 'border-amber-200/80 bg-amber-50/80 dark:border-amber-900/50 dark:bg-amber-950/40',
            dot: 'bg-amber-500',
            ping: 'bg-amber-400',
            text: 'text-amber-900 dark:text-amber-200',
            badge: 'bg-amber-100 text-amber-900 dark:bg-amber-900/60 dark:text-amber-200',
        };
    }
    if (overall.value === 'outage') {
        return {
            banner: 'border-rose-200/80 bg-rose-50/80 dark:border-rose-900/50 dark:bg-rose-950/40',
            dot: 'bg-rose-500',
            ping: 'bg-rose-400',
            text: 'text-rose-900 dark:text-rose-200',
            badge: 'bg-rose-100 text-rose-900 dark:bg-rose-900/60 dark:text-rose-200',
        };
    }
    return {
        banner: 'border-slate-200/80 bg-slate-50/80 dark:border-slate-800 dark:bg-slate-900/40',
        dot: 'bg-slate-400',
        ping: 'bg-slate-300',
        text: 'text-slate-700 dark:text-slate-300',
        badge: 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
    };
});

const checkedAtLabel = computed(() => {
    if (!status.value?.checked_at) return '—';
    return new Date(status.value.checked_at).toLocaleString('sq-AL', {
        dateStyle: 'medium',
        timeStyle: 'short',
    });
});

function serviceDot(s) {
    if (s.status === 'operational') return 'bg-emerald-500';
    return 'bg-rose-500';
}

async function fetchStatus() {
    try {
        const res = await fetch('/api/v1/status', {
            headers: { Accept: 'application/json' },
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const json = await res.json();
        status.value = json.data;
        error.value = null;
    } catch (e) {
        error.value = 'Nuk u arrit të lexohet statusi. Provoni përsëri.';
        console.error('[IPKO Status]', e);
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    fetchStatus();
    pollTimer = setInterval(fetchStatus, 60000);
});

onUnmounted(() => {
    if (pollTimer) clearInterval(pollTimer);
});
</script>

<template>
    <div class="flex min-h-screen flex-col bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
        <AppHeader active="info" />

        <main class="flex-1">
            <section class="relative overflow-hidden border-b border-slate-200/80 dark:border-slate-800">
                <div class="pointer-events-none absolute inset-0 ipko-footer-glow" aria-hidden="true" />
                <div class="relative mx-auto max-w-4xl px-4 py-12 sm:px-6 sm:py-16">
                    <p class="text-xs font-semibold uppercase tracking-widest text-ipko-600 dark:text-ipko-400">
                        System Status · Live
                    </p>
                    <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                        Statusi i IPKO.ai
                    </h1>
                    <p class="mt-3 text-slate-600 dark:text-slate-400">
                        Monitorim në kohë reale të komponentëve B2B: tracking, enrichment, dashboard dhe auth.
                    </p>
                </div>
            </section>

            <div class="mx-auto max-w-4xl space-y-6 px-4 py-10 sm:px-6">
                <!-- Overall banner -->
                <div
                    class="rounded-2xl border p-6 transition"
                    :class="statusTheme.banner"
                >
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3">
                            <span class="relative flex h-3 w-3">
                                <span
                                    v-if="overall === 'operational'"
                                    class="absolute inline-flex h-full w-full animate-ping rounded-full opacity-75"
                                    :class="statusTheme.ping"
                                />
                                <span class="relative inline-flex h-3 w-3 rounded-full" :class="statusTheme.dot" />
                            </span>
                            <div>
                                <p class="text-lg font-bold" :class="statusTheme.text">{{ overallLabel }}</p>
                                <p v-if="status" class="text-xs text-slate-500 dark:text-slate-400">
                                    Kontrolluar: {{ checkedAtLabel }} · {{ status.region }} · v{{ status.version }}
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex w-fit rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider" :class="statusTheme.badge">
                            {{ overall }}
                        </span>
                    </div>
                </div>

                <p v-if="error" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900 dark:bg-rose-950/40 dark:text-rose-200">
                    {{ error }}
                </p>

                <!-- Services -->
                <section class="ipko-card overflow-hidden">
                    <div class="border-b border-slate-200/80 px-5 py-4 dark:border-slate-800">
                        <h2 class="font-semibold text-slate-900 dark:text-white">Komponentët</h2>
                        <p class="text-xs text-slate-500">Rifreskohet automatikisht çdo 60 sekonda</p>
                    </div>

                    <ul v-if="loading" class="divide-y divide-slate-200/80 dark:divide-slate-800">
                        <li v-for="n in 6" :key="n" class="flex animate-pulse items-center justify-between px-5 py-4">
                            <div class="h-4 w-40 rounded bg-slate-200 dark:bg-slate-800" />
                            <div class="h-4 w-24 rounded bg-slate-200 dark:bg-slate-800" />
                        </li>
                    </ul>

                    <ul v-else-if="status?.services" class="divide-y divide-slate-200/80 dark:divide-slate-800">
                        <li
                            v-for="svc in status.services"
                            :key="svc.name"
                            class="flex flex-col gap-2 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
                        >
                            <div class="flex items-start gap-3">
                                <span class="mt-1.5 h-2.5 w-2.5 shrink-0 rounded-full" :class="serviceDot(svc)" />
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-white">{{ svc.name }}</p>
                                    <p class="font-mono text-[11px] text-slate-500">{{ svc.component }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 pl-5 sm:pl-0">
                                <span
                                    v-if="svc.latency_ms != null"
                                    class="text-xs text-slate-500"
                                >{{ svc.latency_ms }} ms</span>
                                <span
                                    class="rounded-full px-2.5 py-0.5 text-xs font-medium"
                                    :class="svc.status === 'operational'
                                        ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300'
                                        : 'bg-rose-100 text-rose-800 dark:bg-rose-950/50 dark:text-rose-300'"
                                >
                                    {{ svc.status_label }}
                                </span>
                            </div>
                        </li>
                    </ul>
                </section>

                <!-- Metrics -->
                <section v-if="status?.metrics" class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="ipko-card p-5 text-center">
                        <p class="text-2xl font-bold text-ipko-600 dark:text-ipko-400">{{ status.metrics.active_clients }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wider text-slate-500">Klientë aktivë</p>
                    </div>
                    <div class="ipko-card p-5 text-center">
                        <p class="text-2xl font-bold text-ipko-600 dark:text-ipko-400">{{ status.metrics.registered_businesses }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wider text-slate-500">Biznese në registry</p>
                    </div>
                    <div class="ipko-card p-5 text-center">
                        <p class="text-sm font-bold capitalize" :class="status.metrics.cache === 'operational' ? 'text-emerald-600' : 'text-amber-600'">
                            {{ status.metrics.cache === 'operational' ? 'Operacional' : 'Degraded' }}
                        </p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wider text-slate-500">Cache layer</p>
                    </div>
                </section>

                <!-- Uptime / incidents -->
                <section class="ipko-card p-5">
                    <h2 class="font-semibold text-slate-900 dark:text-white">Incidentet (30 ditë)</h2>
                    <p v-if="overall === 'operational'" class="mt-3 flex items-center gap-2 text-sm text-emerald-700 dark:text-emerald-300">
                        <span class="text-lg">✓</span>
                        Asnjë incident i raportuar — uptime MVP ~99% (best effort).
                    </p>
                    <p v-else class="mt-3 text-sm text-amber-800 dark:text-amber-200">
                        Disa komponentë nuk janë fully operational. Ekipi është njoftuar automatikisht.
                        Për urgjenca: <a href="mailto:support@ipko.ai" class="underline">support@ipko.ai</a>
                    </p>

                    <!-- Uptime bar visual (decorative MVP) -->
                    <div class="mt-5">
                        <p class="mb-2 text-xs text-slate-500">Uptime vizual (30 ditë)</p>
                        <div class="flex gap-0.5">
                            <span
                                v-for="d in 30"
                                :key="d"
                                class="h-8 flex-1 rounded-sm transition"
                                :class="overall === 'outage' && d === 30
                                    ? 'bg-rose-400'
                                    : overall === 'degraded' && d >= 28
                                        ? 'bg-amber-400'
                                        : 'bg-emerald-400/90 dark:bg-emerald-500/80'"
                                :title="`Dita ${d}`"
                            />
                        </div>
                    </div>
                </section>

                <!-- Subscribe -->
                <section class="rounded-xl border border-slate-200/80 bg-white/60 p-5 text-center dark:border-slate-800 dark:bg-slate-900/40">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Dëshironi njoftime për ndërprerje?
                    </p>
                    <a
                        href="mailto:status@ipko.ai?subject=Subscribe%20IPKO%20Status"
                        class="mt-3 inline-flex rounded-xl bg-gradient-to-r from-ipko-600 to-ipko-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-ipko-500/25 transition hover:opacity-95"
                    >
                        Abonohu via email
                    </a>
                </section>

                <p class="text-center text-xs text-slate-500">
                    <a href="/info" class="text-ipko-600 hover:underline dark:text-ipko-400">Info</a>
                    ·
                    <a href="/kushtet" class="text-ipko-600 hover:underline dark:text-ipko-400">Kushtet</a>
                    ·
                    <a href="/privatesia" class="text-ipko-600 hover:underline dark:text-ipko-400">Privatësia</a>
                </p>
            </div>
        </main>

        <AppFooter />
        <ScrollToTop />
    </div>
</template>
