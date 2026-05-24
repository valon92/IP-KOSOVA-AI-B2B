<script setup>
import AppHeader from './AppHeader.vue';
import AppFooter from './AppFooter.vue';
import ScrollToTop from './ScrollToTop.vue';

const steps = [
    {
        step: 'A',
        title: 'Aktivizoni llogarinë B2B',
        desc: 'Merrni API key unike dhe domain-in e autorizuar për faqen tuaj. Çdo klient IPKO.ai ka izolim të plotë të të dhënave.',
    },
    {
        step: 'B',
        title: 'Vendosni Tracking SDK',
        desc: 'Kopjoni snippet-in JavaScript para </body>. Skripti është async, i lehtë (<3KB), dhe nuk bllokon ngarkimin e faqes.',
    },
    {
        step: 'C',
        title: 'Vizitori hyn në faqe',
        desc: 'Kur dikush nga një rrjet korporativ viziton site-in tuaj, tracker-i dërgon URL, referrer, pajisje dhe rezolucion ekrani.',
    },
    {
        step: 'D',
        title: 'Kapja e IP-së publike',
        desc: 'Serveri Laravel regjistron IP-në reale të vizitorit përmes request()->ip() — pa nevojë për geolocation nga browser.',
    },
    {
        step: 'E',
        title: 'Enrichment — Identifikimi',
        desc: 'IP-ja krahasohet me Business Registry (industries + business_ip_ranges): NLB, Albi Mall, ministri, banka, retail etj.',
    },
    {
        step: 'F',
        title: 'Regjistrimi i Page View',
        desc: 'Çdo vizitë ruhet në page_views me session_id, url_path, duration dhe business_id (nëse u identifikua).',
    },
    {
        step: 'G',
        title: 'Ping & kohëzgjatja',
        desc: 'Çdo 15 sekonda (dhe kur përdoruesi largohet) tracker-i dërgon ping/beacon për të matur kohën reale në faqe.',
    },
    {
        step: 'H',
        title: 'AI Lead Scoring',
        desc: 'Motori llogarit lead_score 0–100: kohë në site, faqe me vlerë (/pricing, /contact), vizita të përsëritura brenda 7 ditëve.',
    },
    {
        step: 'I',
        title: 'Identified Leads',
        desc: 'Për çdo kombinim client + business + IP krijohet client_business_lead me status: hot, medium, cold.',
    },
    {
        step: 'J',
        title: 'Dashboard në kohë reale',
        desc: 'Hapni /dashboard: metrikat, live feed (30 min), dhe tabela e kompanive me score, faqe dhe kohë.',
    },
    {
        step: 'K',
        title: 'Veprimi mbi leads',
        desc: 'Prioritizoni vizitorët “Hot” (>75), kontaktoni medium (40–75), dhe monitoroni cold për nurturing.',
    },
    {
        step: 'L',
        title: 'API & integrime',
        desc: 'Përdorni REST API: /businesses, /industries, /dashboard/business-leads — lidhni me CRM ose Slack.',
    },
];

const features = [
    {
        icon: '🎯',
        title: 'Reverse IP Lookup B2B',
        text: 'Zbuloni cila kompani nga Kosova po shikon ofertën tuaja — jo vetëm “IPKO” ose “ISP”.',
    },
    {
        icon: '📊',
        title: 'Analytics Dashboard',
        text: 'Metrika, live feed dhe tabela e kompanive të identifikuara në një UI moderne.',
    },
    {
        icon: '⚡',
        title: 'AI Lead Scoring',
        text: 'Prioritizim automatik i vizitorëve me potencial konvertimi të lartë.',
    },
    {
        icon: '🔒',
        title: 'B2B & GDPR-Ready',
        text: 'Të dhëna korporative, jo individë — i përshtatshëm për procesim B2B në Kosovë/EU.',
    },
];

const scoreRules = [
    { label: 'Koha në site', points: 'deri në 40', detail: '5 pikë për çdo minutë' },
    { label: 'Faqe me vlerë', points: '+30', detail: '/pricing, /checkout, /contact, /demo' },
    { label: 'Vizita të përsëritura (7 ditë)', points: '+8 deri +25', detail: '2+ sesione nga i njëjti IP korporativ' },
];
</script>

<template>
    <div class="flex min-h-screen flex-col bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
        <AppHeader active="info" />

        <main class="flex-1">
            <!-- Hero -->
            <section class="relative overflow-hidden border-b border-slate-200/80 dark:border-slate-800">
                <div class="pointer-events-none absolute inset-0 ipko-footer-glow" aria-hidden="true" />
                <div class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8">
                    <p class="text-xs font-semibold uppercase tracking-widest text-ipko-600 dark:text-ipko-400">
                        Dokumentacion · A deri në Z
                    </p>
                    <h1 class="mt-3 max-w-3xl text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl dark:text-white">
                        Çfarë është IPKO.ai dhe si e përdorni nga fillimi deri në fund
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg dark:text-slate-400">
                        Platformë B2B për <strong class="text-slate-800 dark:text-slate-200">identifikimin e vizitorëve korporativë</strong>
                        përmes reverse IP lookup dhe geolokacionit të specializuar për Kosovën —
                        e ngjashme me Leadfeeder/Snitcher, e optimizuar për tregun lokal.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="/dashboard"
                            class="inline-flex items-center rounded-xl bg-gradient-to-r from-ipko-600 to-ipko-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-ipko-500/30 transition hover:opacity-95"
                        >
                            Hap Dashboard
                        </a>
                        <a
                            href="#udhezuesi"
                            class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                        >
                            Lexo udhëzuesin A–Z
                        </a>
                    </div>
                </div>
            </section>

            <!-- What it does -->
            <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Çfarë shërben platforma?</h2>
                <p class="mt-2 max-w-3xl text-slate-600 dark:text-slate-400">
                    IPKO.ai transformon trafikun anonim të faqes suaj në inteligjencë B2B të veprueshme.
                </p>
                <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="f in features"
                        :key="f.title"
                        class="ipko-card p-5 transition hover:-translate-y-0.5 hover:shadow-md"
                    >
                        <span class="text-2xl">{{ f.icon }}</span>
                        <h3 class="mt-3 font-semibold text-slate-900 dark:text-white">{{ f.title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ f.text }}</p>
                    </div>
                </div>
            </section>

            <!-- Flow diagram -->
            <section class="border-y border-slate-200/80 bg-white/50 py-12 dark:border-slate-800 dark:bg-slate-900/30">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Si funksionon (arkitektura)</h2>
                    <div class="mt-8 flex flex-col items-stretch gap-3 sm:flex-row sm:flex-wrap sm:justify-center lg:flex-nowrap lg:gap-2">
                        <div
                            v-for="(node, i) in ['Website', 'ipko-tracker.js', 'API /track', 'IP Enrichment', 'Lead Score', 'Dashboard']"
                            :key="node"
                            class="flex items-center gap-2"
                        >
                            <div class="ipko-card min-w-[120px] flex-1 px-4 py-3 text-center text-sm font-medium sm:flex-none">
                                {{ node }}
                            </div>
                            <span
                                v-if="i < 5"
                                class="hidden text-slate-400 sm:inline lg:text-ipko-500"
                            >→</span>
                            <span v-if="i < 5" class="text-center text-slate-400 sm:hidden">↓</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- A-Z Guide -->
            <section id="udhezuesi" class="mx-auto max-w-7xl scroll-mt-20 px-4 py-12 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Udhëzuesi A–Z</h2>
                <p class="mt-2 text-slate-600 dark:text-slate-400">
                    Hapat e plotë për integrim dhe përdorim të platformës.
                </p>
                <ol class="mt-10 space-y-4">
                    <li
                        v-for="item in steps"
                        :key="item.step"
                        class="ipko-card flex gap-4 p-4 sm:gap-6 sm:p-5"
                    >
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-ipko-500 to-ipko-700 text-lg font-bold text-white"
                        >
                            {{ item.step }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-semibold text-slate-900 dark:text-white">{{ item.title }}</h3>
                            <p class="mt-1 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ item.desc }}</p>
                        </div>
                    </li>
                </ol>
            </section>

            <!-- Business registration -->
            <section id="register-business" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Regjistrimi i biznesit</h2>
                <p class="mt-2 max-w-2xl text-slate-600 dark:text-slate-400">
                    Çdo kompani B2B në Kosovë mund të shtohet në regjistrin IPKO.ai me intervalin IP të zyrës.
                    Pas verifikimit, vizitorët nga ai rrjet identifikohen automatikisht.
                </p>
                <ol class="mt-6 list-inside list-decimal space-y-2 text-sm text-slate-600 dark:text-slate-400">
                    <li>Hapni <a href="/register-business" class="font-medium text-ipko-600 hover:underline dark:text-ipko-400">/register-business</a></li>
                    <li>Plotësoni emrin, sektorin, qytetin dhe intervalin IP (fillim–fund)</li>
                    <li>Dërgoni formularin — API: <code class="rounded bg-slate-200 px-1 text-xs dark:bg-slate-800">POST /api/v1/businesses/register</code></li>
                    <li>Nëse <code class="text-xs">IPKO_AUTO_VERIFY_BUSINESSES=true</code>, biznesi aktivizohet menjëherë; përndryshe pritet verifikimi</li>
                </ol>
                <a
                    href="/register-business"
                    class="mt-6 inline-flex rounded-xl border border-ipko-200 bg-ipko-50 px-5 py-2.5 text-sm font-semibold text-ipko-700 transition hover:bg-ipko-100 dark:border-ipko-800 dark:bg-ipko-950 dark:text-ipko-300"
                >
                    Regjistro biznesin tani →
                </a>
            </section>

            <!-- Tracking snippet -->
            <section id="tracking-sdk" class="border-t border-slate-200/80 bg-slate-100/50 py-12 dark:border-slate-800 dark:bg-slate-900/20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Integrimi — Tracking SDK</h2>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                        Vendoseni në çdo faqe publike të domain-it tuaj.
                    </p>
                    <pre class="mt-6 overflow-x-auto rounded-xl border border-slate-200 bg-slate-900 p-4 text-xs leading-relaxed text-slate-100 sm:text-sm dark:border-slate-700"><code>&lt;script
  src="https://your-domain.com/ipko-tracker.js"
  data-api-key="YOUR_API_KEY"
  data-endpoint="https://your-domain.com/api/v1/track"
  data-ping-interval="15000"
  async
&gt;&lt;/script&gt;</code></pre>
                    <ul class="mt-4 list-inside list-disc space-y-1 text-sm text-slate-600 dark:text-slate-400">
                        <li><code class="rounded bg-slate-200 px-1 dark:bg-slate-800">event: pageview</code> — vizitë e re</li>
                        <li><code class="rounded bg-slate-200 px-1 dark:bg-slate-800">event: ping</code> — përditësim kohëzgjatjeje</li>
                        <li><code class="rounded bg-slate-200 px-1 dark:bg-slate-800">event: beacon</code> — kur përdoruesi mbyll tab-in</li>
                    </ul>
                </div>
            </section>

            <!-- Lead scoring -->
            <section id="lead-scoring" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">AI Lead Scoring</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    <div
                        v-for="rule in scoreRules"
                        :key="rule.label"
                        class="ipko-card p-5"
                    >
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ rule.label }}</p>
                        <p class="mt-2 text-2xl font-bold text-ipko-600 dark:text-ipko-400">{{ rule.points }}</p>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ rule.detail }}</p>
                    </div>
                </div>
                <div class="mt-6 flex flex-wrap gap-3">
                    <span class="ipko-badge-hot rounded-full px-3 py-1 text-xs font-semibold">Hot &gt; 75</span>
                    <span class="ipko-badge-medium rounded-full px-3 py-1 text-xs font-semibold">Medium 40–75</span>
                    <span class="ipko-badge-cold rounded-full px-3 py-1 text-xs font-semibold">Cold &lt; 40</span>
                </div>
            </section>

            <!-- API -->
            <section id="api" class="border-t border-slate-200/80 py-12 dark:border-slate-800">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">REST API</h2>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                        Header: <code class="rounded bg-slate-200 px-1.5 py-0.5 text-xs dark:bg-slate-800">X-Api-Key: your_key</code>
                    </p>
                    <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700">
                        <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-700">
                            <thead class="bg-slate-50 dark:bg-slate-800/50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-600">Metoda</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-600">Endpoint</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-600">Përshkrimi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white dark:divide-slate-800 dark:bg-slate-900">
                                <tr>
                                    <td class="px-4 py-3 font-mono text-emerald-600">POST</td>
                                    <td class="px-4 py-3 font-mono text-xs">/api/v1/track</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Regjistron vizita &amp; ping</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-mono text-ipko-600">GET</td>
                                    <td class="px-4 py-3 font-mono text-xs">/api/v1/dashboard/metrics</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Metrikat kryesore</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-mono text-ipko-600">GET</td>
                                    <td class="px-4 py-3 font-mono text-xs">/api/v1/dashboard/live-feed</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Vizitorë aktivë (30 min)</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-mono text-ipko-600">GET</td>
                                    <td class="px-4 py-3 font-mono text-xs">/api/v1/dashboard/business-leads</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Leads B2B të identifikuara</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-mono text-ipko-600">GET</td>
                                    <td class="px-4 py-3 font-mono text-xs">/api/v1/businesses</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Regjistri i bizneseve</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-mono text-ipko-600">GET</td>
                                    <td class="px-4 py-3 font-mono text-xs">/api/v1/industries</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Sektoret ekonomik</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- CTA -->
            <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
                <div class="rounded-2xl bg-gradient-to-br from-ipko-600 to-ipko-800 p-8 text-center text-white shadow-xl sm:p-12">
                    <h2 class="text-2xl font-bold">Gati për të identifikuar vizitorët B2B?</h2>
                    <p class="mx-auto mt-3 max-w-lg text-sm text-ipko-100">
                        Filloni me dashboard-in demo dhe integroni tracker-in në faqen tuaj brenda minutave.
                    </p>
                    <a
                        href="/dashboard"
                        class="mt-6 inline-flex rounded-xl bg-white px-6 py-3 text-sm font-semibold text-ipko-700 transition hover:bg-ipko-50"
                    >
                        Shko te Dashboard →
                    </a>
                </div>
            </section>
        </main>

        <AppFooter />
        <ScrollToTop />
    </div>
</template>
