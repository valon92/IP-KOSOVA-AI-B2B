<script setup>
import AppHeader from './AppHeader.vue';
import AppFooter from './AppFooter.vue';
import ScrollToTop from './ScrollToTop.vue';

const updated = '24 maj 2026';

const sections = [
    { id: 'hyrje', label: 'Hyrje' },
    { id: 'palet', label: 'Palët' },
    { id: 'objekti', label: 'Objekti & afati' },
    { id: 'natyra', label: 'Natyra e përpunimit' },
    { id: 'te-dhenat', label: 'Të dhënat' },
    { id: 'processor', label: 'Detyrimet e IPKO.ai' },
    { id: 'controller', label: 'Detyrimet e klientit' },
    { id: 'udhezimet', label: 'Udhëzimet' },
    { id: 'nen-procesues', label: 'Nën-përpunuesit' },
    { id: 'siguria', label: 'Siguria' },
    { id: 'shkeljet', label: 'Shkeljet e të dhënave' },
    { id: 'te-drejtat', label: 'Të drejtat' },
    { id: 'transferet', label: 'Transferet' },
    { id: 'audit', label: 'Audit & regjistrat' },
    { id: 'perfundimi', label: 'Përfundimi' },
    { id: 'kontakt', label: 'Kontakt' },
];

const processorDuties = [
    'Përpunon të dhënat vetëm sipas udhëzimeve të dokumentuara të klientit dhe kësaj DPA.',
    'Siguron që personeli me qasje është i detyruar me konfidencialitet.',
    'Zbaton masa teknike dhe organizative të përshtatshme (Art. 32 GDPR).',
    'Ndihmon klientin në përgjigje ndaj kërkesave të subjekteve të të dhënave (akses, fshirje, etj.).',
    'Njofton klientin brenda 72 orëve pas diturisë për shkelje të mundshme të të dhënave.',
    'Fshin ose kthen të dhënat pas përfundimit të shërbimit, sipas zgjedhjes së klientit.',
    'Mbaj regjistër të aktiviteteve të përpunimit dhe ofron informacion për audit (me njoftim).',
];

const controllerDuties = [
    'Siguron bazën ligjore për përpunimin e të dhënave të vizitorëve në faqen e vet.',
    'Vendos tracking SDK vetëm pas vlerësimit të nevojës për njoftim privacy/cookie.',
    'Jep udhëzime të qarta IPKO.ai për përpunim, fshirje ose eksport të dhënash.',
    'Informon IPKO.ai pa vonesë nëse merr ankesë nga subjekt i të dhënave ose autoritet.',
    'Mos udhëzojë përpunim që shkel GDPR, LPDP ose ligje të tjera të zbatueshme.',
];

const securityMeasures = [
    { title: 'Izolim multi-tenant', desc: 'Të dhënat e çdo klienti izolohen me client_id — nuk ka qasje cross-client.' },
    { title: 'Enkriptim & hashing', desc: 'HTTPS në prodhim; fjalëkalime bcrypt; API keys të fshehura nga UI publik.' },
    { title: 'Kontroll qasjeje', desc: 'Role-based access; autentifikim sesioni për dashboard; throttle për API.' },
    { title: 'Backup & recovery', desc: 'Snapshot-e të enkriptuara; procedura restore të testuara.' },
    { title: 'Logging & monitorim', desc: 'Regjistrim i eventeve kritike; faqe statusi publike (/status).' },
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
                        Legal · Data Processing Agreement
                    </p>
                    <h1 class="mt-3 max-w-3xl text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                        DPA / B2B — Marrëveshja e Përpunimit të të Dhënave
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg dark:text-slate-400">
                        Dokumenti që përcakton marrëdhënien
                        <strong class="text-slate-800 dark:text-slate-200">Controller → Processor</strong>
                        kur klienti B2B përdor IPKO.ai për identifikim korporativ përmes reverse IP lookup,
                        tracking SDK dhe lead scoring.
                    </p>
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-500">
                        Përditësuar: {{ updated }} · Në harmonim me GDPR (Art. 28) dhe LPDP Kosovë
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
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">1. Hyrje</h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                Kjo Marrëveshje e Përpunimit të të Dhënave (“DPA”) është pjesë integruese e
                                <a href="/kushtet" class="text-ipko-600 hover:underline dark:text-ipko-400">Kushteve të Përdorimit</a>
                                dhe
                                <a href="/privatesia" class="text-ipko-600 hover:underline dark:text-ipko-400">Politikës së Privatësisë</a>.
                                Aplikohet automatikisht kur klienti B2B aktivizon llogarinë dhe vendos
                                <code class="text-xs">ipko-tracker.js</code> në faqen e vet.
                            </p>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                Për kontrata enterprise me klauzola shtesë (SCC, SLA credits, DPO i dedikuar),
                                kontaktoni <a href="mailto:legal@ipko.ai" class="text-ipko-600 dark:text-ipko-400">legal@ipko.ai</a>.
                            </p>
                        </section>

                        <section id="palet" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">2. Palët</h2>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div class="ipko-card border-l-4 border-l-ipko-500 p-5">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-ipko-600 dark:text-ipko-400">Controller</p>
                                    <p class="mt-2 font-semibold text-slate-900 dark:text-white">Klienti B2B</p>
                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                                        Kompania që ka llogari IPKO.ai dhe vendos tracker-in në website-in e vet.
                                        Përcakton qëllimin dhe bazën ligjore të përpunimit ndaj vizitorëve.
                                    </p>
                                </div>
                                <div class="ipko-card border-l-4 border-l-slate-400 p-5 dark:border-l-slate-600">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Processor</p>
                                    <p class="mt-2 font-semibold text-slate-900 dark:text-white">IPKO.ai</p>
                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                                        Prishtinë, Kosovë · përpunon të dhënat në emër të klientit:
                                        enrichment IP, scoring, ruajtje page views dhe dashboard analytics.
                                    </p>
                                </div>
                            </div>
                        </section>

                        <section id="objekti" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">3. Objekti &amp; kohëzgjatja</h2>
                            <div class="mt-4 overflow-hidden rounded-xl border border-slate-200/80 dark:border-slate-800">
                                <table class="w-full text-left text-sm">
                                    <tbody class="divide-y divide-slate-200/80 dark:divide-slate-800">
                                        <tr>
                                            <td class="bg-slate-50 px-4 py-3 font-medium text-slate-700 dark:bg-slate-900/80 dark:text-slate-300">Objekti</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Përpunimi i eventeve të vizitorëve për identifikim B2B dhe lead intelligence</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-slate-50 px-4 py-3 font-medium text-slate-700 dark:bg-slate-900/80 dark:text-slate-300">Kohëzgjatja</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Gjatë kohës së kontratës / llogarisë aktive + periudha e fshirjes (max 90 ditë)</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-slate-50 px-4 py-3 font-medium text-slate-700 dark:bg-slate-900/80 dark:text-slate-300">Vendndodhja</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">EU / Kosovë (ose sipas kontratës enterprise)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <section id="natyra" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">4. Natyra &amp; qëllimi i përpunimit</h2>
                            <ul class="mt-4 space-y-2 text-sm text-slate-600 dark:text-slate-400">
                                <li class="flex gap-2"><span class="text-ipko-500">1.</span> Mbledhje eventesh pageview përmes Tracking SDK</li>
                                <li class="flex gap-2"><span class="text-ipko-500">2.</span> Reverse IP lookup kundrejt Business Registry (Kosovë)</li>
                                <li class="flex gap-2"><span class="text-ipko-500">3.</span> Llogaritje lead score dhe kategorizim hot / medium / cold</li>
                                <li class="flex gap-2"><span class="text-ipko-500">4.</span> Shfaqje në dashboard dhe eksport/API për ekipin e shitjeve të klientit</li>
                                <li class="flex gap-2"><span class="text-ipko-500">5.</span> Ruajtje historiku analitik me izolim tenant</li>
                            </ul>
                        </section>

                        <section id="te-dhenat" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">5. Kategoritë e të dhënave &amp; subjektet</h2>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div class="ipko-card p-4">
                                    <h3 class="font-semibold text-slate-900 dark:text-white">Të dhëna të përpunuara</h3>
                                    <ul class="mt-2 space-y-1 text-sm text-slate-600 dark:text-slate-400">
                                        <li>· IP publike, URL, referrer</li>
                                        <li>· Device type, screen resolution</li>
                                        <li>· session_id, duration, timestamp</li>
                                        <li>· Emër biznesi (nëse enrichment sukses)</li>
                                        <li>· Lead score &amp; metadata B2B</li>
                                    </ul>
                                </div>
                                <div class="ipko-card p-4">
                                    <h3 class="font-semibold text-slate-900 dark:text-white">Subjektet e të dhënave</h3>
                                    <ul class="mt-2 space-y-1 text-sm text-slate-600 dark:text-slate-400">
                                        <li>· Vizitorë korporativë të site-it të klientit</li>
                                        <li>· Përdorues të autorizuar të llogarisë B2B</li>
                                        <li>· Kontaktet e bizneseve të regjistruara në platformë</li>
                                    </ul>
                                    <p class="mt-3 text-xs text-slate-500">
                                        Fokusi B2B: identifikim kompanie, jo profil individi konsumator.
                                    </p>
                                </div>
                            </div>
                        </section>

                        <section id="processor" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">6. Detyrimet e IPKO.ai (Processor)</h2>
                            <ul class="mt-4 space-y-2">
                                <li
                                    v-for="(item, i) in processorDuties"
                                    :key="i"
                                    class="flex gap-3 rounded-lg border border-ipko-200/60 bg-ipko-50/30 px-4 py-3 text-sm text-slate-700 dark:border-ipko-900/40 dark:bg-ipko-950/20 dark:text-slate-300"
                                >
                                    <span class="font-bold text-ipko-600 dark:text-ipko-400">{{ i + 1 }}.</span>
                                    {{ item }}
                                </li>
                            </ul>
                        </section>

                        <section id="controller" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">7. Detyrimet e klientit (Controller)</h2>
                            <ul class="mt-4 space-y-2">
                                <li
                                    v-for="(item, i) in controllerDuties"
                                    :key="i"
                                    class="flex gap-3 rounded-lg border border-slate-200/80 bg-white/60 px-4 py-3 text-sm text-slate-700 dark:border-slate-800 dark:bg-slate-900/40 dark:text-slate-300"
                                >
                                    <span class="font-bold text-slate-500">{{ i + 1 }}.</span>
                                    {{ item }}
                                </li>
                            </ul>
                        </section>

                        <section id="udhezimet" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">8. Udhëzimet e përpunimit</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                Klienti autorizon IPKO.ai të përpunojë të dhënat për qëllimet e përshkruara në këtë DPA.
                                Udhëzime shtesë (fshirje e leads, eksport, kufizim përpunimi) dërgohen te
                                <a href="mailto:dpo@ipko.ai" class="text-ipko-600 dark:text-ipko-400">dpo@ipko.ai</a>
                                ose përmes ticket-it të supportit.
                                IPKO.ai informon klientin nëse një udhëzim duket i paligjshëm.
                            </p>
                        </section>

                        <section id="nen-procesues" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">9. Nën-përpunuesit (Sub-processors)</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                IPKO.ai mund të përdorë nën-përpunues për infrastrukturë:
                            </p>
                            <div class="mt-4 overflow-hidden rounded-xl border border-slate-200/80 dark:border-slate-800">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-50 dark:bg-slate-900/80">
                                        <tr>
                                            <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">Kategoria</th>
                                            <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">Qëllimi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200/80 dark:divide-slate-800">
                                        <tr>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Cloud hosting / VPS</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Ekzekutim API, dashboard, DB</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Database &amp; backup</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Ruajtje page_views, leads, registry</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">CDN / DNS (opsionale)</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Shpërndarje statike, tracker.js</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="mt-3 text-sm text-slate-500">
                                Lista e përditësuar publikohet me njoftim 30 ditë para ndryshimeve materiale.
                                Të gjithë nën-përpunuesit lidhen me DPA të njëjtë standard.
                            </p>
                        </section>

                        <section id="siguria" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">10. Masat e sigurisë (Art. 32 GDPR)</h2>
                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                <div v-for="m in securityMeasures" :key="m.title" class="ipko-card p-4">
                                    <h3 class="font-semibold text-slate-900 dark:text-white">{{ m.title }}</h3>
                                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ m.desc }}</p>
                                </div>
                            </div>
                        </section>

                        <section id="shkeljet" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">11. Njoftimi i shkeljeve</h2>
                            <div class="mt-4 rounded-xl border border-rose-200/80 bg-rose-50/50 p-4 text-sm text-rose-950 dark:border-rose-900/50 dark:bg-rose-950/30 dark:text-rose-100">
                                <p class="font-medium">Procedura 72-orëshe</p>
                                <p class="mt-2 leading-relaxed opacity-90">
                                    IPKO.ai njofton klientin pa vonesë të panevojshme dhe jo më vonë se
                                    <strong>72 orë</strong> pas diturisë për shkelje të të dhënave personale që prek
                                    përpunimin në platformë. Njoftimi përfshin natyrën e shkeljes, kategoritë e prekura
                                    dhe masat e ndërmarra. Klienti mbetet përgjegjës për njoftimin e AIP / autoriteteve
                                    dhe subjekteve, si controller.
                                </p>
                            </div>
                        </section>

                        <section id="te-drejtat" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">12. Të drejtat e subjekteve</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                Kërkesat e subjekteve të të dhënave (akses, rectifikim, fshirje, kufizim, portabilitet,
                                kundërshtim) adresohen te <strong>klienti si controller</strong>.
                                IPKO.ai ndihmon me mjete teknike brenda 30 ditëve nga kërkesa e autorizuar e klientit:
                                eksport leads, fshirje IP specifike, ose anonimizim.
                            </p>
                        </section>

                        <section id="transferet" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">13. Transferet ndërkombëtare</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                Të dhënat ruhen prioritet në EU / Kosovë. Nëse nevojitet transfer jashtë EEA,
                                aplikohen Klauzolat Standarde Kontraktuale (SCC) të Komisionit Evropian ose
                                vendim adekuacioni. Klienti autorizon transferet e nevojshme për funksionimin e shërbimit.
                            </p>
                        </section>

                        <section id="audit" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">14. Audit &amp; regjistrat</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                IPKO.ai mbaj regjistër të aktiviteteve të përpunimit (Art. 30 GDPR).
                                Klientët enterprise mund të kërkojnë audit ose questionnaire sigurie me njoftim 30 ditë.
                                Rezultatet e audit-it trajtohen konfidencial.
                            </p>
                        </section>

                        <section id="perfundimi" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">15. Përfundimi &amp; fshirja</h2>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                                Pas përfundimit të kontratës ose mbylljes së llogarisë, klienti zgjedh:
                                (a) fshirje të plotë të të dhënave brenda 90 ditëve, ose
                                (b) eksport JSON/CSV para fshirjes.
                                IPKO.ai certifikon fshirjen me email në kërkesë.
                                Të dhënat mund të mbahen më gjatë vetëm kur ligji e kërkon (p.sh. regjistrat fiskalë).
                            </p>
                        </section>

                        <section id="kontakt" class="scroll-mt-24">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">16. Kontakt DPO &amp; legal</h2>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div class="ipko-card p-4">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Data Protection Officer</p>
                                    <a href="mailto:dpo@ipko.ai" class="mt-2 block font-medium text-ipko-600 dark:text-ipko-400">dpo@ipko.ai</a>
                                </div>
                                <div class="ipko-card p-4">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Legal / kontrata enterprise</p>
                                    <a href="mailto:legal@ipko.ai" class="mt-2 block font-medium text-ipko-600 dark:text-ipko-400">legal@ipko.ai</a>
                                </div>
                            </div>
                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="/privatesia" class="inline-flex rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                    Privatësia
                                </a>
                                <a href="/kushtet" class="inline-flex rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                    Kushtet
                                </a>
                                <a href="/info" class="inline-flex rounded-xl bg-gradient-to-r from-ipko-600 to-ipko-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-ipko-500/25 transition hover:opacity-95">
                                    Info A–Z
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
