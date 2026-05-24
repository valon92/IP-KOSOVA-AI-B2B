<script setup>
import LeadScoreBadge from './LeadScoreBadge.vue';

defineProps({
    items: { type: Array, default: () => [] },
    loading: { type: Boolean, default: false },
});

function statusDot(status) {
    if (status === 'hot') return 'bg-rose-500 animate-pulse';
    if (status === 'medium') return 'bg-amber-500';
    return 'bg-slate-400';
}
</script>

<template>
    <div class="ipko-card flex h-full flex-col overflow-hidden">
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 dark:border-slate-700">
            <div>
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Live Feed</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Companies browsing right now</p>
            </div>
            <span class="relative flex h-3 w-3">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75" />
                <span class="relative inline-flex h-3 w-3 rounded-full bg-emerald-500" />
            </span>
        </div>

        <div class="flex-1 overflow-y-auto p-3">
            <div v-if="loading" class="space-y-3 p-2">
                <div v-for="n in 5" :key="n" class="h-16 animate-pulse rounded-lg bg-slate-100 dark:bg-slate-800" />
            </div>

            <p v-else-if="items.length === 0" class="px-3 py-8 text-center text-sm text-slate-500">
                No active visitors in the last 30 minutes.
            </p>

            <ul v-else class="space-y-2">
                <li
                    v-for="item in items"
                    :key="item.id"
                    class="flex items-center gap-3 rounded-lg border border-transparent px-3 py-3 transition-colors hover:border-ipko-200 hover:bg-ipko-50/50 dark:hover:border-ipko-800 dark:hover:bg-ipko-950/30"
                >
                    <span class="h-2.5 w-2.5 shrink-0 rounded-full" :class="statusDot(item.status)" />
                    <div class="min-w-0 flex-1">
                        <p class="truncate font-medium text-slate-900 dark:text-white">
                            {{ item.business?.name ?? item.company_name }}
                        </p>
                        <p class="truncate text-xs text-slate-500">
                            {{ item.business?.industry?.name ?? item.industry }} · {{ item.current_page }}
                        </p>
                    </div>
                    <div class="shrink-0 text-right">
                        <LeadScoreBadge :score="item.lead_score" :status="item.status" />
                        <p class="mt-1 text-xs text-slate-400">{{ item.last_active_human }}</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>
