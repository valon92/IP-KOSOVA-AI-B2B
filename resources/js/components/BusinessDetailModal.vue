<script setup>
import { ref, watch } from 'vue';
import api from '../api/client';
import LeadScoreBadge from './LeadScoreBadge.vue';
import { businessInitials } from '../composables/useBusinessDisplay';

const props = defineProps({
    businessId: { type: Number, default: null },
    open: { type: Boolean, default: false },
});

const emit = defineEmits(['close']);

const loading = ref(false);
const detail = ref(null);
const error = ref(null);

watch(
    () => [props.open, props.businessId],
    async ([isOpen, id]) => {
        if (!isOpen || !id) {
            detail.value = null;
            return;
        }
        loading.value = true;
        error.value = null;
        try {
            const { data } = await api.get(`/businesses/${id}/detail`);
            detail.value = data.data;
        } catch (e) {
            error.value = 'Nuk u ngarkuan detajet.';
            console.error(e);
        } finally {
            loading.value = false;
        }
    },
    { immediate: true }
);

function close() {
    emit('close');
}

function formatDuration(seconds) {
    if (!seconds) return '0s';
    if (seconds < 60) return `${seconds}s`;
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `${m}m ${s}s`;
}
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="open" class="fixed inset-0 z-[100] flex items-end justify-center sm:items-center sm:p-4">
                <div
                    class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
                    aria-hidden="true"
                    @click="close"
                />
                <div
                    class="relative z-10 flex max-h-[92vh] w-full max-w-2xl flex-col overflow-hidden rounded-t-2xl bg-white shadow-2xl sm:rounded-2xl dark:bg-slate-900"
                    role="dialog"
                    aria-modal="true"
                >
                    <div class="flex items-start justify-between border-b border-slate-200 px-5 py-4 dark:border-slate-700">
                        <div v-if="detail?.business" class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-ipko-500 to-ipko-700 text-sm font-bold text-white">
                                {{ businessInitials(detail.business.name) }}
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900 dark:text-white">{{ detail.business.name }}</h2>
                                <p class="text-sm text-slate-500">{{ detail.business.location }}</p>
                            </div>
                        </div>
                        <button
                            type="button"
                            class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-800"
                            aria-label="Mbyll"
                            @click="close"
                        >
                            ✕
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto px-5 py-5">
                        <div v-if="loading" class="py-12 text-center text-slate-500">Duke ngarkuar detajet…</div>
                        <p v-else-if="error" class="py-12 text-center text-rose-600">{{ error }}</p>

                        <template v-else-if="detail">
                            <div class="mb-6 flex flex-wrap gap-2">
                                <span
                                    v-if="detail.business.is_verified"
                                    class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400"
                                >
                                    ✓ Verified
                                </span>
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                    {{ detail.business.industry?.icon }} {{ detail.business.industry?.name }}
                                </span>
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                    {{ detail.business.size_band }} punonjës
                                </span>
                                <LeadScoreBadge
                                    v-if="detail.lead"
                                    :score="detail.lead.lead_score"
                                    :status="detail.lead.status"
                                />
                            </div>

                            <section class="mb-6 rounded-xl border border-ipko-200/80 bg-ipko-50/50 p-4 dark:border-ipko-900 dark:bg-ipko-950/30">
                                <h3 class="text-sm font-semibold uppercase tracking-wider text-ipko-700 dark:text-ipko-400">
                                    🌐 Identiteti IP
                                </h3>
                                <p class="mt-1 text-xs text-slate-500">{{ detail.ip_identity?.identification_method }}</p>

                                <div v-if="detail.lead?.ip_address" class="mt-3">
                                    <p class="text-xs font-medium text-slate-500">IP e identifikuar (vizitor)</p>
                                    <p class="font-mono text-lg font-semibold text-slate-900 dark:text-white">{{ detail.lead.ip_address }}</p>
                                </div>

                                <ul class="mt-4 space-y-3">
                                    <li
                                        v-for="range in detail.ip_identity?.ranges"
                                        :key="range.id"
                                        class="rounded-lg bg-white/80 p-3 dark:bg-slate-900/80"
                                    >
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="text-xs font-semibold uppercase text-slate-500">{{ range.label }}</span>
                                            <span v-if="range.is_primary" class="text-[10px] font-medium text-ipko-600">Primary</span>
                                        </div>
                                        <p class="mt-1 font-mono text-sm text-slate-900 dark:text-white">
                                            {{ range.ip_start }}
                                            <span v-if="range.ip_start !== range.ip_end" class="text-slate-400"> — {{ range.ip_end }}</span>
                                        </p>
                                    </li>
                                </ul>
                            </section>

                            <section class="mb-6">
                                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-slate-500">Biznesi</h3>
                                <dl class="grid gap-3 sm:grid-cols-2">
                                    <div v-if="detail.business.legal_name">
                                        <dt class="text-xs text-slate-500">Emri ligjor</dt>
                                        <dd class="text-sm font-medium">{{ detail.business.legal_name }}</dd>
                                    </div>
                                    <div v-if="detail.business.website">
                                        <dt class="text-xs text-slate-500">Website</dt>
                                        <dd>
                                            <a :href="detail.business.website" target="_blank" rel="noopener" class="text-sm text-ipko-600 hover:underline">{{ detail.business.website }}</a>
                                        </dd>
                                    </div>
                                    <div v-if="detail.business.email">
                                        <dt class="text-xs text-slate-500">Email</dt>
                                        <dd class="text-sm">{{ detail.business.email }}</dd>
                                    </div>
                                    <div v-if="detail.business.phone">
                                        <dt class="text-xs text-slate-500">Telefoni</dt>
                                        <dd class="text-sm">{{ detail.business.phone }}</dd>
                                    </div>
                                    <div v-if="detail.business.registered_at">
                                        <dt class="text-xs text-slate-500">Regjistruar</dt>
                                        <dd class="text-sm">{{ new Date(detail.business.registered_at).toLocaleDateString('sq-AL') }}</dd>
                                    </div>
                                </dl>
                                <p v-if="detail.business.description" class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                    {{ detail.business.description }}
                                </p>
                            </section>

                            <section v-if="detail.lead || detail.analytics">
                                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-slate-500">Aktiviteti në faqen tuaj</h3>
                                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                                    <div class="rounded-lg bg-slate-50 p-3 dark:bg-slate-800/50">
                                        <p class="text-xs text-slate-500">Vizita</p>
                                        <p class="text-xl font-bold">{{ detail.lead?.visit_count ?? 0 }}</p>
                                    </div>
                                    <div class="rounded-lg bg-slate-50 p-3 dark:bg-slate-800/50">
                                        <p class="text-xs text-slate-500">Koha</p>
                                        <p class="text-xl font-bold">{{ formatDuration(detail.lead?.total_time_spent) }}</p>
                                    </div>
                                    <div class="rounded-lg bg-slate-50 p-3 dark:bg-slate-800/50">
                                        <p class="text-xs text-slate-500">Page views</p>
                                        <p class="text-xl font-bold">{{ detail.analytics?.total_page_views ?? 0 }}</p>
                                    </div>
                                    <div class="rounded-lg bg-slate-50 p-3 dark:bg-slate-800/50">
                                        <p class="text-xs text-slate-500">Sesione</p>
                                        <p class="text-xl font-bold">{{ detail.analytics?.unique_sessions ?? 0 }}</p>
                                    </div>
                                </div>
                                <div v-if="detail.lead?.pages_visited?.length" class="mt-4">
                                    <p class="mb-2 text-xs font-medium text-slate-500">Faqet e vizituara</p>
                                    <div class="flex flex-wrap gap-1.5">
                                        <span
                                            v-for="path in detail.lead.pages_visited"
                                            :key="path"
                                            class="rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium dark:bg-slate-800"
                                        >
                                            {{ path }}
                                        </span>
                                    </div>
                                </div>
                                <p v-if="detail.lead?.last_active_human" class="mt-3 text-xs text-slate-500">
                                    Aktiv së fundi: {{ detail.lead.last_active_human }}
                                </p>
                            </section>
                        </template>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
