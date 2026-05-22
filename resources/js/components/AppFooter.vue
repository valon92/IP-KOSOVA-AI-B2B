<script setup>
const year = new Date().getFullYear();

const productLinks = [
    { label: 'Info — Udhëzues A–Z', href: '/info' },
    { label: 'Analytics Dashboard', href: '/dashboard' },
    { label: 'Tracking SDK', href: '/info#tracking-sdk' },
    { label: 'REST API', href: '/info#api' },
    { label: 'Lead Scoring', href: '/info#lead-scoring' },
];

const platformLinks = [
    { label: 'IP Enrichment', desc: 'Kosovo corporate ranges' },
    { label: 'Live Visitor Feed', desc: 'Real-time B2B signals' },
    { label: 'Company Directory', desc: 'Banking, retail, gov' },
    { label: 'GDPR-Ready', desc: 'B2B data processing' },
];

const techStack = [
    { name: 'Laravel 10', role: 'API' },
    { name: 'Vue 3', role: 'UI' },
    { name: 'PostgreSQL', role: 'Data' },
    { name: 'AI Scoring', role: 'Leads' },
];
</script>

<template>
    <footer class="ipko-footer relative mt-auto overflow-hidden border-t border-slate-200/80 dark:border-slate-800">
        <!-- Ambient background -->
        <div class="pointer-events-none absolute inset-0 ipko-footer-glow" aria-hidden="true" />
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.35] dark:opacity-[0.2]"
            style="background-image: radial-gradient(circle at 1px 1px, rgb(148 163 184 / 0.15) 1px, transparent 0); background-size: 24px 24px;"
            aria-hidden="true"
        />

        <div class="relative mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-12 lg:px-8">
            <!-- Top: brand + status -->
            <div class="flex flex-col gap-8 border-b border-slate-200/60 pb-10 dark:border-slate-800/80 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-md">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-ipko-500 to-ipko-700 text-sm font-bold text-white shadow-lg shadow-ipko-600/30"
                        >
                            IP
                        </div>
                        <div>
                            <p class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">
                                IPKO<span class="text-ipko-500">.ai</span>
                            </p>
                            <p class="text-xs font-medium uppercase tracking-widest text-ipko-600 dark:text-ipko-400">
                                B2B Intelligence Platform
                            </p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        Identifikoni vizitorët korporativë në faqen tuaj përmes
                        <strong class="font-medium text-slate-800 dark:text-slate-200">reverse IP lookup</strong>
                        dhe geolokacionit të specializuar për tregun e Kosovës dhe Ballkanit —
                        si Leadfeeder, i ndërtuar për B2B lokale.
                    </p>
                    <div class="mt-5 inline-flex items-center gap-2 rounded-full border border-emerald-200/80 bg-emerald-50/80 px-3 py-1.5 text-xs font-medium text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-300">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75" />
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500" />
                        </span>
                        Sistemi aktiv · Enrichment &amp; scoring në kohë reale
                    </div>
                </div>

                <!-- Tech stack pills -->
                <div class="flex flex-wrap gap-2 lg:max-w-sm lg:justify-end">
                    <div
                        v-for="tech in techStack"
                        :key="tech.name"
                        class="rounded-lg border border-slate-200/80 bg-white/60 px-3 py-2 backdrop-blur-sm dark:border-slate-700/60 dark:bg-slate-900/60"
                    >
                        <p class="text-xs font-semibold text-slate-900 dark:text-white">{{ tech.name }}</p>
                        <p class="text-[10px] uppercase tracking-wider text-slate-500 dark:text-slate-500">{{ tech.role }}</p>
                    </div>
                </div>
            </div>

            <!-- Middle: link grids -->
            <div class="grid grid-cols-1 gap-8 py-10 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-500">
                        Produkti
                    </h3>
                    <ul class="mt-4 space-y-2.5">
                        <li v-for="link in productLinks" :key="link.label">
                            <a
                                :href="link.href"
                                class="group inline-flex items-center text-sm text-slate-600 transition hover:text-ipko-600 dark:text-slate-400 dark:hover:text-ipko-400"
                            >
                                <span class="mr-2 h-px w-0 bg-ipko-500 transition-all group-hover:w-3" />
                                {{ link.label }}
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-500">
                        Platforma
                    </h3>
                    <ul class="mt-4 space-y-3">
                        <li v-for="item in platformLinks" :key="item.label">
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ item.label }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-500">{{ item.desc }}</p>
                        </li>
                    </ul>
                </div>

                <div class="sm:col-span-2 lg:col-span-1">
                    <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-500">
                        Integrimi
                    </h3>
                    <div class="mt-4 rounded-xl border border-slate-200/80 bg-slate-50/80 p-4 dark:border-slate-700/60 dark:bg-slate-900/50">
                        <p class="font-mono text-[11px] leading-relaxed text-slate-600 dark:text-slate-400">
                            &lt;script src="/ipko-tracker.js"<br>
                            &nbsp;&nbsp;data-api-key="••••••"<br>
                            &nbsp;&nbsp;async&gt;&lt;/script&gt;
                        </p>
                        <p class="mt-3 text-xs text-slate-500">
                            Një rresht kod — identifikim korporativ, lead scoring AI, API REST.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="flex flex-col items-center justify-between gap-4 border-t border-slate-200/60 pt-8 dark:border-slate-800/80 sm:flex-row">
                <p class="text-center text-xs text-slate-500 sm:text-left dark:text-slate-500">
                    © {{ year }} IPKO.ai · Prishtinë, Kosovë · Të gjitha të drejtat e rezervuara.
                </p>
                <nav class="flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-xs text-slate-500">
                    <a href="/info" class="font-medium text-ipko-600 transition hover:text-ipko-700 dark:text-ipko-400 dark:hover:text-ipko-300">Info</a>
                    <a href="#" class="transition hover:text-ipko-600 dark:hover:text-ipko-400">Privatësia</a>
                    <a href="#" class="transition hover:text-ipko-600 dark:hover:text-ipko-400">Kushtet</a>
                    <a href="#" class="transition hover:text-ipko-600 dark:hover:text-ipko-400">DPA / B2B</a>
                    <a href="#" class="transition hover:text-ipko-600 dark:hover:text-ipko-400">Status</a>
                    <a href="mailto:hello@ipko.ai" class="font-medium text-ipko-600 dark:text-ipko-400">hello@ipko.ai</a>
                </nav>
            </div>
        </div>
    </footer>
</template>
