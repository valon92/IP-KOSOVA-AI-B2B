<script setup>
import { computed } from 'vue';
import LeadScoreBadge from './LeadScoreBadge.vue';
import { normalizeBusinessLead, businessInitials } from '../composables/useBusinessDisplay';

const props = defineProps({
    leads: { type: Array, default: () => [] },
    loading: { type: Boolean, default: false },
});

const emit = defineEmits(['open-detail']);

const rows = computed(() => props.leads.map(normalizeBusinessLead));

function openRow(row) {
    if (row.business_id) {
        emit('open-detail', row.business_id);
    }
}
</script>

<template>
    <div class="ipko-card overflow-hidden">
        <div class="border-b border-slate-200 px-4 py-3 sm:px-6 sm:py-4 dark:border-slate-700">
            <h2 class="text-base font-semibold text-slate-900 sm:text-lg dark:text-white">Identified Businesses</h2>
            <p class="mt-0.5 text-xs leading-snug text-slate-500 sm:text-sm dark:text-slate-400">
                Kliko mbi biznesin për detaje të IP-së dhe aktivitetit
            </p>
        </div>

        <div class="md:hidden">
            <div v-if="loading" class="px-4 py-10 text-center text-sm text-slate-500">Loading businesses...</div>
            <div v-else-if="rows.length === 0" class="px-4 py-10 text-center text-sm text-slate-500">No identified businesses yet.</div>
            <ul v-else class="divide-y divide-slate-100 dark:divide-slate-800">
                <li
                    v-for="row in rows"
                    :key="row.id"
                    class="cursor-pointer px-4 py-4 active:bg-slate-50 dark:active:bg-slate-800/50"
                    @click="openRow(row)"
                >
                    <div class="flex items-start gap-3">
                        <div class="relative flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-ipko-500 to-ipko-700 text-sm font-bold text-white">
                            {{ businessInitials(row.name) }}
                            <span v-if="row.is_verified" class="absolute -bottom-0.5 -right-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-emerald-500 text-[8px] text-white">✓</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <p class="truncate font-semibold text-slate-900 dark:text-white">{{ row.name }}</p>
                                <LeadScoreBadge class="shrink-0" :score="row.lead_score" :status="row.status" />
                            </div>
                            <p class="mt-0.5 flex items-center gap-1 truncate text-xs text-slate-500">
                                <span v-if="row.industry_icon">{{ row.industry_icon }}</span>
                                {{ row.location }} · {{ row.industry }}
                            </p>
                            <p class="mt-1 text-xs text-slate-600 dark:text-slate-400">
                                <span v-if="row.visit_count === 0" class="font-medium text-amber-600 dark:text-amber-400">Në regjistër — prit vizitë</span>
                                <template v-else>{{ row.time_spent }} · {{ row.visit_count }} visit(s)</template>
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="hidden overflow-x-auto md:block">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:px-6">Business</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:px-6">Location</th>
                        <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:table-cell lg:px-6">Industry</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:px-6">Pages</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:px-6">Time</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:px-6">AI Score</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white dark:divide-slate-800 dark:bg-slate-900">
                    <tr v-if="loading">
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">Loading businesses...</td>
                    </tr>
                    <tr v-else-if="rows.length === 0">
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">No identified businesses yet.</td>
                    </tr>
                    <tr
                        v-for="row in rows"
                        :key="row.id"
                        class="cursor-pointer transition-colors hover:bg-ipko-50/50 dark:hover:bg-ipko-950/20"
                        @click="openRow(row)"
                    >
                        <td class="whitespace-nowrap px-4 py-4 lg:px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-ipko-500 to-ipko-700 text-sm font-bold text-white">
                                    {{ businessInitials(row.name) }}
                                </div>
                                <div>
                                    <span class="font-medium text-slate-900 dark:text-white">{{ row.name }}</span>
                                    <span v-if="row.is_verified" class="ml-1.5 text-[10px] font-semibold text-emerald-600">✓ Verified</span>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-600 lg:px-6 dark:text-slate-300">{{ row.location }}</td>
                        <td class="hidden whitespace-nowrap px-4 py-4 text-sm lg:table-cell lg:px-6 dark:text-slate-300">
                            <span v-if="row.industry_icon" class="mr-1">{{ row.industry_icon }}</span>{{ row.industry }}
                        </td>
                        <td class="px-4 py-4 lg:px-6">
                            <div class="flex max-w-[180px] flex-wrap gap-1.5 xl:max-w-xs">
                                <span
                                    v-for="path in row.pages_visited.slice(0, 4)"
                                    :key="path"
                                    class="inline-flex rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300"
                                >
                                    {{ path }}
                                </span>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm font-medium lg:px-6 dark:text-slate-200">{{ row.time_spent }}</td>
                        <td class="whitespace-nowrap px-4 py-4 lg:px-6">
                            <LeadScoreBadge :score="row.lead_score" :status="row.status" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
