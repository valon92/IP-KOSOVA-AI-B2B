<script setup>
import LeadScoreBadge from './LeadScoreBadge.vue';

defineProps({
    companies: { type: Array, default: () => [] },
    loading: { type: Boolean, default: false },
});

function companyInitials(name) {
    if (!name) return '?';
    return name
        .split(' ')
        .slice(0, 2)
        .map((w) => w[0])
        .join('')
        .toUpperCase();
}
</script>

<template>
    <div class="ipko-card overflow-hidden">
        <div class="border-b border-slate-200 px-4 py-3 sm:px-6 sm:py-4 dark:border-slate-700">
            <h2 class="text-base font-semibold text-slate-900 sm:text-lg dark:text-white">Identified Companies</h2>
            <p class="mt-0.5 text-xs leading-snug text-slate-500 sm:text-sm dark:text-slate-400">
                B2B visitors resolved from Kosovo corporate IP ranges
            </p>
        </div>

        <!-- Mobile: card list -->
        <div class="md:hidden">
            <div v-if="loading" class="px-4 py-10 text-center text-sm text-slate-500">
                Loading companies...
            </div>
            <div v-else-if="companies.length === 0" class="px-4 py-10 text-center text-sm text-slate-500">
                No identified companies yet.
            </div>
            <ul v-else class="divide-y divide-slate-100 dark:divide-slate-800">
                <li
                    v-for="company in companies"
                    :key="company.id"
                    class="px-4 py-4 active:bg-slate-50 dark:active:bg-slate-800/50"
                >
                    <div class="flex items-start gap-3">
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-ipko-500 to-ipko-700 text-sm font-bold text-white shadow-sm"
                        >
                            {{ companyInitials(company.company_name) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <p class="truncate font-semibold text-slate-900 dark:text-white">
                                    {{ company.company_name }}
                                </p>
                                <LeadScoreBadge
                                    class="shrink-0"
                                    :score="company.lead_score"
                                    :status="company.status"
                                />
                            </div>
                            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                {{ company.location }} · {{ company.industry }}
                            </p>
                            <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-600 dark:text-slate-300">
                                <span class="font-medium text-slate-700 dark:text-slate-200">
                                    {{ company.time_spent }}
                                </span>
                                <span class="text-slate-300 dark:text-slate-600">|</span>
                                <span>{{ company.visit_count ?? 1 }} visit(s)</span>
                            </div>
                            <div
                                v-if="(company.pages_visited || []).length"
                                class="mt-2.5 flex flex-wrap gap-1.5"
                            >
                                <span
                                    v-for="path in (company.pages_visited || []).slice(0, 3)"
                                    :key="path"
                                    class="inline-flex max-w-full truncate rounded-md bg-slate-100 px-2 py-0.5 text-[11px] font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300"
                                >
                                    {{ path }}
                                </span>
                                <span
                                    v-if="(company.pages_visited || []).length > 3"
                                    class="text-[11px] text-slate-400"
                                >
                                    +{{ company.pages_visited.length - 3 }}
                                </span>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Desktop: table -->
        <div class="hidden overflow-x-auto md:block">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:px-6">Company</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:px-6">Location</th>
                        <th class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:table-cell lg:px-6">Industry</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:px-6">Pages</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:px-6">Time</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:px-6">AI Score</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white dark:divide-slate-800 dark:bg-slate-900">
                    <tr v-if="loading">
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">Loading companies...</td>
                    </tr>
                    <tr v-else-if="companies.length === 0">
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">No identified companies yet.</td>
                    </tr>
                    <tr
                        v-for="company in companies"
                        :key="company.id"
                        class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/40"
                    >
                        <td class="whitespace-nowrap px-4 py-4 lg:px-6">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-ipko-500 to-ipko-700 text-sm font-bold text-white shadow-sm"
                                >
                                    {{ companyInitials(company.company_name) }}
                                </div>
                                <span class="max-w-[140px] truncate font-medium text-slate-900 lg:max-w-none dark:text-white">
                                    {{ company.company_name }}
                                </span>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-600 lg:px-6 dark:text-slate-300">
                            {{ company.location }}
                        </td>
                        <td class="hidden whitespace-nowrap px-4 py-4 text-sm text-slate-600 lg:table-cell lg:px-6 dark:text-slate-300">
                            {{ company.industry }}
                        </td>
                        <td class="px-4 py-4 lg:px-6">
                            <div class="flex max-w-[180px] flex-wrap gap-1.5 xl:max-w-xs">
                                <span
                                    v-for="path in (company.pages_visited || []).slice(0, 4)"
                                    :key="path"
                                    class="inline-flex rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300"
                                >
                                    {{ path }}
                                </span>
                                <span
                                    v-if="(company.pages_visited || []).length > 4"
                                    class="text-xs text-slate-400"
                                >
                                    +{{ company.pages_visited.length - 4 }}
                                </span>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-slate-700 lg:px-6 dark:text-slate-200">
                            {{ company.time_spent }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 lg:px-6">
                            <LeadScoreBadge :score="company.lead_score" :status="company.status" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
