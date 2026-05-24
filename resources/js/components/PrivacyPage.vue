<script setup>
import AppHeader from './AppHeader.vue';
import AppFooter from './AppFooter.vue';
import ScrollToTop from './ScrollToTop.vue';

const updated = '24 maj 2026';

const sections = [
    { id: 'hyrje', label: 'Hyrje' },
    { id: 'kontrolluesi', label: 'Kontrolluesi' },
    { id: 'qellimi', label: 'Qëllimi B2B' },
    { id: 'te-dhenat', label: 'Të dhënat' },
    { id: 'si-funksionon', label: 'Si funksionon' },
    { id: 'baza-ligjore', label: 'Baza ligjore' },
    { id: 'cookies', label: 'Cookies' },
    { id: 'ruajtja', label: 'Ruajtja & siguria' },
    { id: 'ndarja', label: 'Ndarja' },
    { id: 'te-drejtat', label: 'Të drejtat' },
    { id: 'kontakt', label: 'Kontakt' },
];

const dataCategories = [
    {
        title: 'Të dhëna teknike të vizitorit',
        items: ['Adresa IP publike', 'URL / faqe e vizituar', 'Referrer', 'Lloji i pajisjes', 'Rezolucioni i ekranit', 'session_id anonim', 'Kohëzgjatja në faqe'],
        note: 'Kapen nga ipko-tracker.js në faqen e klientit B2B.',
    },
    {
        title: 'Të dhëna korporative (enrichment)',
        items: ['Emri i biznesit (nëse IP-ja përputhet me regjistrin)', 'Qyteti / industri', 'Lead score B2B', 'Historiku i vizitave korporative'],
        note: 'Jo emra individësh — identifikim në nivel kompanie, jo person fizik.',
    },
    {
        title: 'Të dhëna të llogarisë së klientit',
        items: ['Emri i kompanisë kliente', 'Email & fjalëkalim (hash)', 'Domain i autorizuar', 'API key për tracking'],
        note: 'Për hyrje në dashboard dhe integrim SDK.',
    },
    {
        title: 'Të dhëna të regjistrimit të biznesit',
        items: ['Emri, email, telefon i kontaktit korporativ', 'IP range / rrjeti i deklaruar', 'Website & qyteti'],
        note: 'Kur një biznes regjistrohet në /register-business.',
    },
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
                        Legal · GDPR &amp; LPDP
                    </p>
                    <h1 class="mt-3 max-w-3xl text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                        Politika e Privatësisë
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg dark:text-slate-400">
                        IPKO.ai është platformë <strong class="text-slate-800 dark:text-slate-200">B2B IP Intelligence</strong>
                        për Kosovën dhe Ballkanin. Kjo politikë shpjegon si përpunojmë të dhënat kur klientët tanë
                        identifikojnë vizitorë korporativë përmes reverse IP lookup — jo tracking konsumator.
                    </p>
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-500">
                        Përditësuar: {{ updated }} · Versioni MVP 1.0
                    </p>
                </div>
            </section>

            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-10 lg:grid-cols-4">
                    <!-- Sidebar nav -->
                    <aside class="lg:col-span-1">
                        <nav class="sticky top-24 space-y-1 rounded-xl border border-slate-200/80 bg-white/80 p-4 backdrop-blur-sm dark:border-slate-800 dark:bg-slate-900/60">
                            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-500">Përmbajtja</p>
                            <a
                                v-for="s in sections"
                                :key="s.id"
                                :href="`#${s.id}`"
                                class="block rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-ipko-50 hover:text-ipko-700 dark:text-slate-400 dark:hover:bg-ipko-950/40 dark:hover:text-ipko-300"
                            >
                                {{ s.label }}
                            </a>
                        </nav>
                    </aside>

                    <!-- Content -->
                    <article class="prose prose-slate max-w-none space-y-12 lg:col-span-3 dark:prose-invert">
                        <section id="hyrje" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">1. Hyrje</h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                IPKO.ai (“ne”, “platforma”) ofron analitikë B2B për identifikimin e vizitorëve korporativë
                                në faqet e internetit të klientëve tanë. Ndryshe nga reklamat ose analytics konsumator,
                                fokusi ynë është <em>inteligjenca korporative</em>: cila kompani (biznes) po shikon ofertën tuaj,
                                jo profilizimi i individëve.
                            </p>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                Duke përdorur dashboard-in, tracking SDK-në ose API-në tonë, ju pranoni këtë politikë.
                                Për marrëveshje formale B2B, shihni edhe
                                <a href="/dpa" class="text-ipko-600 hover:underline dark:text-ipko-400">DPA / B2B</a>.
                            </p>
                        </section>

                        <section id="kontrolluesi" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">2. Kontrolluesi i të dhënave</h2>
                            <div class="ipko-card mt-4 space-y-2 p-5 text-sm text-slate-600 dark:text-slate-400">
                                <p><strong class="text-slate-800 dark:text-slate-200">IPKO.ai</strong> · Prishtinë, Kosovë</p>
                                <p>Email: <a href="mailto:privacy@ipko.ai" class="text-ipko-600 dark:text-ipko-400">privacy@ipko.ai</a></p>
                                <p>Për pyetje GDPR / LPDP: <a href="mailto:dpo@ipko.ai" class="text-ipko-600 dark:text-ipko-400">dpo@ipko.ai</a></p>
                            </div>
                            <p class="mt-4 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                Kur klienti B2B vendos tracker-in në faqen e vet, ai vepron si
                                <strong>kontrollues i të dhënave</strong> ndaj vizitorëve të site-it të tij;
                                IPKO.ai vepron si <strong>përpunues (processor)</strong> sipas udhëzimeve të klientit
                                dhe kontratës DPA.
                            </p>
                        </section>

                        <section id="qellimi" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">3. Qëllimi B2B — çfarë bëjmë dhe çfarë JO</h2>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div class="rounded-xl border border-emerald-200/80 bg-emerald-50/50 p-4 dark:border-emerald-900/50 dark:bg-emerald-950/30">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Po — B2B</p>
                                    <ul class="mt-2 space-y-1 text-sm text-slate-700 dark:text-slate-300">
                                        <li>· Identifikim biznesi nga IP korporative</li>
                                        <li>· Lead scoring për ekipin e shitjeve</li>
                                        <li>· Analytics agregate për klientin</li>
                                        <li>· Regjistrim biznesi me pëlqim të kontaktit</li>
                                    </ul>
                                </div>
                                <div class="rounded-xl border border-rose-200/80 bg-rose-50/50 p-4 dark:border-rose-900/50 dark:bg-rose-950/30">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-rose-700 dark:text-rose-400">Jo — nuk bëjmë</p>
                                    <ul class="mt-2 space-y-1 text-sm text-slate-700 dark:text-slate-300">
                                        <li>· Shitje të listave të individëve</li>
                                        <li>· Profil reklamues cross-site (AdTech)</li>
                                        <li>· Fingerprinting invaziv të pajisjes</li>
                                        <li>· Gjurmim jashtë faqeve të klientit</li>
                                    </ul>
                                </div>
                            </div>
                        </section>

                        <section id="te-dhenat" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">4. Kategoritë e të dhënave</h2>
                            <div class="mt-6 space-y-4">
                                <div
                                    v-for="cat in dataCategories"
                                    :key="cat.title"
                                    class="ipko-card p-5"
                                >
                                    <h3 class="font-semibold text-slate-900 dark:text-white">{{ cat.title }}</h3>
                                    <ul class="mt-2 flex flex-wrap gap-2">
                                        <li
                                            v-for="item in cat.items"
                                            :key="item"
                                            class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs text-slate-700 dark:bg-slate-800 dark:text-slate-300"
                                        >
                                            {{ item }}
                                        </li>
                                    </ul>
                                    <p class="mt-3 text-xs text-slate-500">{{ cat.note }}</p>
                                </div>
                            </div>
                        </section>

                        <section id="si-funksionon" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">5. Si funksionon përpunimi</h2>
                            <ol class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-400">
                                <li class="flex gap-3">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-ipko-100 text-xs font-bold text-ipko-700 dark:bg-ipko-950 dark:text-ipko-300">1</span>
                                    <span><strong class="text-slate-800 dark:text-slate-200">Tracking SDK</strong> (<code class="text-xs">ipko-tracker.js</code>) dërgon evente pageview te <code class="text-xs">POST /api/v1/track</code> me API key të klientit.</span>
                                </li>
                                <li class="flex gap-3">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-ipko-100 text-xs font-bold text-ipko-700 dark:bg-ipko-950 dark:text-ipko-300">2</span>
                                    <span>Serveri regjistron IP-në publike dhe e krahason me <strong>Business Registry</strong> (rrjetet IP të verifikuara në Kosovë).</span>
                                </li>
                                <li class="flex gap-3">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-ipko-100 text-xs font-bold text-ipko-700 dark:bg-ipko-950 dark:text-ipko-300">3</span>
                                    <span>Nëse ka përputhje, krijohet ose përditësohet <strong>client_business_lead</strong> — izoluar për çdo klient (<code class="text-xs">client_id</code>).</span>
                                </li>
                                <li class="flex gap-3">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-ipko-100 text-xs font-bold text-ipko-700 dark:bg-ipko-950 dark:text-ipko-300">4</span>
                                    <span>Motori i <strong>lead scoring</strong> llogarit prioritetin (hot / medium / cold) bazuar në sjellje B2B, jo të dhëna personale të ndjeshme.</span>
                                </li>
                            </ol>
                            <p class="mt-4 text-sm text-slate-500">
                                Saktësia e identifikimit varet nga regjistrimi i rrjeteve korporative; IP-të rezidenciale ose mobile shpesh mbeten të paidentifikuara.
                            </p>
                        </section>

                        <section id="baza-ligjore" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">6. Baza ligjore</h2>
                            <div class="mt-4 overflow-hidden rounded-xl border border-slate-200/80 dark:border-slate-800">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-50 dark:bg-slate-900/80">
                                        <tr>
                                            <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">Situata</th>
                                            <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">Baza</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200/80 dark:divide-slate-800">
                                        <tr>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Llogaria B2B &amp; dashboard</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Ekzekutimi i kontratës (Art. 6(1)(b) GDPR)</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Tracking &amp; enrichment korporativ</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Interesi legjitim B2B i klientit (Art. 6(1)(f)), me balancing test</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Regjistrim biznesi në platformë</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Pëlqimi / interesi legjitim i biznesit të regjistruar</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="mt-4 text-sm text-slate-600 dark:text-slate-400">
                                Respektojmë parimet e GDPR dhe Ligjit nr. 06/L-082 për Mbrojtjen e të Dhënave Personale (LPDP) në Kosovë.
                                Klientët duhet të informojnë vizitorët e faqeve të tyre kur kërkohet nga ligji lokal (p.sh. njoftim privacy/cookie).
                            </p>
                        </section>

                        <section id="cookies" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">7. Cookies &amp; teknologji lokale</h2>
                            <div class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-400">
                                <div class="ipko-card p-4">
                                    <p class="font-medium text-slate-800 dark:text-slate-200">Dashboard (sesion)</p>
                                    <p class="mt-1">Cookie <code class="text-xs">laravel_session</code> + <code class="text-xs">XSRF-TOKEN</code> — vetëm për hyrjen e klientit B2B, jo për vizitorët e faqeve të trackuara.</p>
                                </div>
                                <div class="ipko-card p-4">
                                    <p class="font-medium text-slate-800 dark:text-slate-200">Tracking SDK</p>
                                    <p class="mt-1">Përdor <code class="text-xs">session_id</code> anonim në localStorage/sessionStorage për matjen e kohëzgjatjes — pa cookies third-party reklamuese.</p>
                                </div>
                                <div class="ipko-card p-4">
                                    <p class="font-medium text-slate-800 dark:text-slate-200">Preferenca UI</p>
                                    <p class="mt-1">Dark mode ruhet në <code class="text-xs">localStorage</code> (<code class="text-xs">ipko_dark_mode</code>) në browser-in tuaj.</p>
                                </div>
                            </div>
                        </section>

                        <section id="ruajtja" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">8. Ruajtja, siguria &amp; izolimi</h2>
                            <ul class="mt-4 space-y-2 text-sm text-slate-600 dark:text-slate-400">
                                <li>· <strong>Izolim multi-tenant:</strong> çdo klient sheh vetëm leads e veta (<code class="text-xs">client_id</code>).</li>
                                <li>· <strong>Enkriptim:</strong> fjalëkalimet hash (bcrypt); trafiku HTTPS në prodhim.</li>
                                <li>· <strong>Retencion:</strong> page views &amp; leads — deri në 24 muaj ose fshirje sipas kërkesës së klientit.</li>
                                <li>· <strong>Qasje:</strong> e kufizuar për personel të autorizuar; API keys të rotuara periodikisht.</li>
                                <li>· <strong>Backup:</strong> snapshot-e të enkriptuara; test restore periodik.</li>
                            </ul>
                        </section>

                        <section id="ndarja" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">9. Ndarja me palë të treta</h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                <strong>Nuk shesim</strong> të dhëna. Ndarja ndodh vetëm me:
                            </p>
                            <ul class="mt-3 space-y-2 text-sm text-slate-600 dark:text-slate-400">
                                <li>· <strong>Infrastructure providers</strong> (hosting, DB, CDN) — me DPA të nënshkruar</li>
                                <li>· <strong>Klientin B2B</strong> — si controller i të dhënave të vizitorëve të site-it të vet</li>
                                <li>· <strong>Autoritetet</strong> — vetëm kur kërkohet me ligj</li>
                            </ul>
                            <p class="mt-4 text-sm text-slate-500">
                                Transferet jashtë EEA/Kosovës bëhen me mekanizma të përshtatshme (SCC / vendim adekuacioni).
                            </p>
                        </section>

                        <section id="te-drejtat" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">10. Të drejtat tuaja</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                Sipas GDPR / LPDP, subjektet e të dhënave kanë të drejtë të:
                            </p>
                            <div class="mt-4 grid gap-2 sm:grid-cols-2">
                                <span v-for="right in ['Akses', 'Rectifikim', 'Fshirje', 'Kufizim', 'Portabilitet', 'Kundërshtim']" :key="right" class="rounded-lg border border-slate-200/80 px-3 py-2 text-sm dark:border-slate-700">{{ right }}</span>
                            </div>
                            <p class="mt-4 text-sm text-slate-600 dark:text-slate-400">
                                Për të dhëna të mbledhura në faqen e një klienti IPKO.ai, kontaktoni fillimisht atë klient (controller).
                                Për llogarinë tuaj B2B ose regjistrimin e biznesit: <a href="mailto:privacy@ipko.ai" class="text-ipko-600 dark:text-ipko-400">privacy@ipko.ai</a>.
                                Keni të drejtë ankesë te Agjencia për Informim dhe Privatësi (AIP) në Kosovë.
                            </p>
                        </section>

                        <section id="kontakt" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">11. Kontakt &amp; ndryshime</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                Përditësojmë këtë politikë kur shtojmë funksione të reja (p.sh. integrime CRM, AI enrichment).
                                Ndryshimet materiale njoftohen përmes dashboard-it ose email-it të klientit.
                            </p>
                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="mailto:privacy@ipko.ai" class="inline-flex rounded-xl bg-gradient-to-r from-ipko-600 to-ipko-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-ipko-500/25 transition hover:opacity-95">
                                    privacy@ipko.ai
                                </a>
                                <a href="/info" class="inline-flex rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                    Kthehu te Info
                                </a>
                            </div>
                        </section>
                    </article>
                </div>
            </div>
        </main>

        <AppFooter />
        <ScrollToTop />
    </div>
</template>
