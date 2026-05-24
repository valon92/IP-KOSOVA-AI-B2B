<script setup>
import AppHeader from './AppHeader.vue';
import AppFooter from './AppFooter.vue';
import ScrollToTop from './ScrollToTop.vue';

const updated = '24 maj 2026';

const sections = [
    { id: 'hyrje', label: 'Hyrje' },
    { id: 'perkufizime', label: 'Përkufizime' },
    { id: 'sherbimi', label: 'Shërbimi' },
    { id: 'llogaria', label: 'Llogaria & API' },
    { id: 'detyrimet', label: 'Detyrimet e klientit' },
    { id: 'perdorimi', label: 'Përdorimi i ndaluar' },
    { id: 'tracking', label: 'Tracking SDK' },
    { id: 'saktesia', label: 'Saktësia e të dhënave' },
    { id: 'sla', label: 'SLA & MVP' },
    { id: 'tarifat', label: 'Tarifat' },
    { id: 'pi', label: 'Pronësia intelektuale' },
    { id: 'pergjegjesia', label: 'Përgjegjësia' },
    { id: 'perfundimi', label: 'Përfundimi' },
    { id: 'ligji', label: 'Ligji zbatues' },
    { id: 'kontakt', label: 'Kontakt' },
];

const clientObligations = [
    'Vendosni tracking SDK vetëm në domain-et e autorizuara në llogarinë tuaj.',
    'Mbani API key të fshehtë — mos e ekspozoni në repo publike ose frontend të pa mbrojtur.',
    'Informoni vizitorët e faqes suaj kur ligji kërkon njoftim privacy/cookie.',
    'Përdorni të dhënat vetëm për qëllime B2B legjitime (shitje, marketing korporativ).',
    'Mos dërgoni të dhëna personale të ndjeshme përmes API-së së tracking-ut.',
    'Raportoni menjëherë çdo komprometim të API key te support@ipko.ai.',
];

const prohibitedUses = [
    'Gjurmim i fshehtë i individëve pa bazë ligjore.',
    'Harassment, diskriminim ose shitje e listave të palëve të treta.',
    'Reverse-engineering i motorit të enrichment ose scraping i regjistrit të bizneseve.',
    'Overload i qëllimshëm i API-së (DDoS, spam events).',
    'Përdorim për qëllime që shkelin ligjin e Kosovës, BE-së ose të drejtat e të tretëve.',
    'Rregistrim i rremë i bizneseve ose deklarim i IP range të paautorizuara.',
];
</script>

<template>
    <div class="flex min-h-screen flex-col bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
        <AppHeader active="info" />

        <main class="flex-1">
            <section class="relative overflow-hidden border-b border-slate-200/80 dark:border-slate-800">
                <div class="pointer-events-none absolute inset-0 ipko-footer-glow" aria-hidden="true" />
                <div class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8">
                    <p class="text-xs font-semibold uppercase tracking-widest text-ipko-600 dark:text-ipko-400">
                        Legal · B2B SaaS
                    </p>
                    <h1 class="mt-3 max-w-3xl text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                        Kushtet e Përdorimit
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg dark:text-slate-400">
                        Këto kushte rregullojnë marrëdhënien mes jush dhe
                        <strong class="text-slate-800 dark:text-slate-200">IPKO.ai</strong>
                        kur përdorni platformën B2B për reverse IP lookup, lead scoring dhe analytics
                        korporativ në Kosovë dhe rajon.
                    </p>
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-500">
                        Përditësuar: {{ updated }} · Versioni MVP 1.0
                    </p>
                </div>
            </section>

            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-10 lg:grid-cols-4">
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

                    <article class="max-w-none space-y-12 lg:col-span-3">
                        <section id="hyrje" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">1. Hyrje &amp; pranimi</h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                Duke krijuar llogari, vendosur <code class="text-xs">ipko-tracker.js</code>, regjistruar biznes
                                ose përdorur dashboard-in, ju pranoni këto Kushte dhe
                                <a href="/privatesia" class="text-ipko-600 hover:underline dark:text-ipko-400">Politikën e Privatësisë</a>.
                                Nëse veproni në emër të një kompanie, deklaroni se keni autoritet të lidhni atë subjekt.
                            </p>
                        </section>

                        <section id="perkufizime" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">2. Përkufizime</h2>
                            <dl class="mt-4 space-y-3 text-sm">
                                <div class="ipko-card p-4">
                                    <dt class="font-semibold text-slate-900 dark:text-white">Klienti B2B</dt>
                                    <dd class="mt-1 text-slate-600 dark:text-slate-400">Subjekti që ka llogari, API key dhe vendos tracker-in në faqen e vet.</dd>
                                </div>
                                <div class="ipko-card p-4">
                                    <dt class="font-semibold text-slate-900 dark:text-white">Platforma</dt>
                                    <dd class="mt-1 text-slate-600 dark:text-slate-400">IPKO.ai — dashboard, REST API, Business Registry dhe motori i enrichment/scoring.</dd>
                                </div>
                                <div class="ipko-card p-4">
                                    <dt class="font-semibold text-slate-900 dark:text-white">Vizitor / Lead</dt>
                                    <dd class="mt-1 text-slate-600 dark:text-slate-400">Sesion nga IP publike e identifikuar ose jo si biznes korporativ në site-in e klientit.</dd>
                                </div>
                                <div class="ipko-card p-4">
                                    <dt class="font-semibold text-slate-900 dark:text-white">Të dhëna</dt>
                                    <dd class="mt-1 text-slate-600 dark:text-slate-400">Page views, metadate teknike, përputhje me regjistrin e bizneseve dhe lead scores.</dd>
                                </div>
                            </dl>
                        </section>

                        <section id="sherbimi" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">3. Shërbimi</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">IPKO.ai ofron:</p>
                            <ul class="mt-3 space-y-2 text-sm text-slate-600 dark:text-slate-400">
                                <li class="flex gap-2"><span class="text-ipko-500">→</span> Tracking SDK asinkron për faqet e klientit</li>
                                <li class="flex gap-2"><span class="text-ipko-500">→</span> Identifikim korporativ përmes reverse IP lookup (Kosovë / Ballkan)</li>
                                <li class="flex gap-2"><span class="text-ipko-500">→</span> Dashboard me metrika, live feed dhe tabela leads</li>
                                <li class="flex gap-2"><span class="text-ipko-500">→</span> REST API për integrime CRM / automatizime</li>
                                <li class="flex gap-2"><span class="text-ipko-500">→</span> Regjistrim publik i bizneseve dhe Business Registry</li>
                            </ul>
                            <p class="mt-4 text-sm text-slate-500">
                                Funksionaliteti MVP mund të ndryshojë; veçoritë beta etiketohen në dashboard ose changelog.
                            </p>
                        </section>

                        <section id="llogaria" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">4. Llogaria, sesioni &amp; API key</h2>
                            <div class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-400">
                                <p>
                                    <strong class="text-slate-800 dark:text-slate-200">Dashboard:</strong>
                                    hyrje me email/fjalëkalim dhe sesion cookie (Sanctum). Ju jeni përgjegjës për kredencialet.
                                </p>
                                <p>
                                    <strong class="text-slate-800 dark:text-slate-200">API key:</strong>
                                    identifikon klientin te <code class="text-xs">POST /api/v1/track</code>.
                                    Mos e ndani publikisht; rotacioni bëhet nga dashboard ose support.
                                </p>
                                <p>
                                    <strong class="text-slate-800 dark:text-slate-200">Domain i autorizuar:</strong>
                                    tracking pranohet vetëm për domain-et e regjistruara në llogarinë tuaj.
                                </p>
                            </div>
                        </section>

                        <section id="detyrimet" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">5. Detyrimet e klientit</h2>
                            <ul class="mt-4 space-y-2">
                                <li
                                    v-for="(item, i) in clientObligations"
                                    :key="i"
                                    class="flex gap-3 rounded-lg border border-slate-200/80 bg-white/60 px-4 py-3 text-sm text-slate-700 dark:border-slate-800 dark:bg-slate-900/40 dark:text-slate-300"
                                >
                                    <span class="font-bold text-ipko-600 dark:text-ipko-400">{{ i + 1 }}.</span>
                                    {{ item }}
                                </li>
                            </ul>
                        </section>

                        <section id="perdorimi" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">6. Përdorimi i ndaluar</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">Ndalohet:</p>
                            <ul class="mt-3 space-y-2">
                                <li
                                    v-for="(item, i) in prohibitedUses"
                                    :key="i"
                                    class="flex gap-2 text-sm text-slate-600 dark:text-slate-400"
                                >
                                    <span class="text-rose-500">✕</span>
                                    {{ item }}
                                </li>
                            </ul>
                            <p class="mt-4 text-sm text-slate-500">
                                Shkelja mund të çojë në pezullim të menjëhershëm të llogarisë dhe API key pa rimbursim.
                            </p>
                        </section>

                        <section id="tracking" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">7. Tracking SDK &amp; faqja juaj</h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                Klienti është <strong>controller</strong> i të dhënave të vizitorëve të site-it të vet.
                                IPKO.ai vepron si <strong>processor</strong> sipas
                                <a href="/dpa" class="text-ipko-600 hover:underline dark:text-ipko-400">DPA / B2B</a>.
                            </p>
                            <div class="mt-4 rounded-xl border border-slate-200/80 bg-slate-50/80 p-4 font-mono text-[11px] leading-relaxed text-slate-600 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-400">
                                &lt;script src="/ipko-tracker.js"<br>
                                &nbsp;&nbsp;data-api-key="YOUR_KEY"<br>
                                &nbsp;&nbsp;data-endpoint="/api/v1/track"<br>
                                &nbsp;&nbsp;async&gt;&lt;/script&gt;
                            </div>
                            <p class="mt-3 text-sm text-slate-500">
                                Skripti dërgon pageview, referrer, device type dhe ping çdo ~15s për kohëzgjatjen.
                                Nuk instalon cookies reklamuese third-party.
                            </p>
                        </section>

                        <section id="saktesia" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">8. Saktësia e enrichment-it</h2>
                            <div class="mt-4 rounded-xl border border-amber-200/80 bg-amber-50/50 p-4 text-sm text-amber-950 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-100">
                                <p class="font-medium">Disclaimer i rëndësishëm</p>
                                <p class="mt-2 leading-relaxed opacity-90">
                                    Identifikimi bazohet në regjistrin e rrjeteve IP korporative dhe heuristika B2B.
                                    IP-të rezidenciale, mobile, VPN ose ISP të përbashkëta shpesh
                                    <strong>nuk identifikohen</strong>. Përputhjet janë “best effort”, jo garanci juridike
                                    se vizitori përfaqëson biznesin e shfaqur.
                                </p>
                            </div>
                        </section>

                        <section id="sla" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">9. Disponueshmëria (SLA MVP)</h2>
                            <div class="mt-4 overflow-hidden rounded-xl border border-slate-200/80 dark:border-slate-800">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-50 dark:bg-slate-900/80">
                                        <tr>
                                            <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">Komponenti</th>
                                            <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">Objektivi MVP</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200/80 dark:divide-slate-800">
                                        <tr>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Tracking API</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">99% uptime (best effort)</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Dashboard &amp; REST API</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">99% uptime (best effort)</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Maintenance</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Njoftim 24h për ndërprerje të planifikuar</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="mt-3 text-sm text-slate-500">
                                Statusi aktual: <a href="/status" class="text-ipko-600 hover:underline dark:text-ipko-400">/status</a>.
                                SLA formale me SLA credits vlen vetëm me kontratë enterprise të nënshkruar.
                            </p>
                        </section>

                        <section id="tarifat" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">10. Tarifat &amp; prova</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                Faza MVP mund të ofrojë akses demo ose trial pa pagesë. Tarifat e ardhshme, limite të eventeve
                                dhe plani enterprise publikohen në faqen e çmimeve ose kontratë individuale.
                                Mospagesa pas afatit mund të çojë në pezullim të shërbimit.
                            </p>
                        </section>

                        <section id="pi" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">11. Pronësia intelektuale</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                IPKO.ai, logot, UI, algoritmet e scoring, Business Registry dhe
                                <code class="text-xs">ipko-tracker.js</code> mbeten pronë e IPKO.ai ose licencuesve.
                                Klienti mban pronësinë e të dhënave që gjeneron në platformë dhe të përmbajtjes së site-it të vet.
                                Ju merrni licencë të kufizuar, jo-ekskluzive për përdorim sipas këtyre Kushteve.
                            </p>
                        </section>

                        <section id="pergjegjesia" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">12. Kufizimi i përgjegjësisë</h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                Platforma jepet “as is” në fazën MVP. Në masën maksimale të lejuar nga ligji,
                                IPKO.ai nuk përgjigjet për: humbje fitimi, humbje leads, vendime biznesi bazuar në scoring,
                                ose dëme indirekte. Përgjegjësia totale nuk tejkalon shumën e paguar nga klienti
                                në 12 muajt e fundit (ose €100 për trial falas).
                            </p>
                        </section>

                        <section id="perfundimi" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">13. Pezullimi &amp; përfundimi</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                Mund të pezullojmë ose mbyllim llogarinë për shkelje të kushteve, kërkesë të autoriteteve,
                                ose mospagesë. Klienti mund të kërkojë fshirje llogarie me email.
                                Pas përfundimit, të dhënat fshihen ose anonimizohen brenda 90 ditëve, përveç kur ligji kërkon ruajtje.
                            </p>
                        </section>

                        <section id="ligji" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">14. Ligji zbatues &amp; mosmarrëveshje</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                Këto kushte rregullohen nga ligjet e Republikës së Kosovës.
                                Mosmarrëveshjet zgjidhen fillimisht me negociata të mirëkuptimit;
                                nëse dështojnë, kompetencë kanë gjykatat e Prishtinës, përveç kur kontrata enterprise
                                parashikon arbitrazh tjetër.
                            </p>
                        </section>

                        <section id="kontakt" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">15. Kontakt</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">Pyetje ligjore ose kontraktore:</p>
                            <div class="mt-4 flex flex-wrap gap-3">
                                <a href="mailto:legal@ipko.ai" class="inline-flex rounded-xl bg-gradient-to-r from-ipko-600 to-ipko-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-ipko-500/25 transition hover:opacity-95">
                                    legal@ipko.ai
                                </a>
                                <a href="/privatesia" class="inline-flex rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                    Privatësia
                                </a>
                                <a href="/info" class="inline-flex rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                    Info
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
