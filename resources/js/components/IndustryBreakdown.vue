<script setup>
defineProps({
    industries: { type: Array, default: () => [] },
    loading: { type: Boolean, default: false },
});
</script>

<template>
    <div class="ipko-card p-4 sm:p-5">
        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Industries on your site</h3>
        <p class="text-xs text-slate-500 dark:text-slate-400">Distribution by Kosovo business sector</p>
        <div v-if="loading" class="mt-4 h-20 animate-pulse rounded-lg bg-slate-100 dark:bg-slate-800" />
        <ul v-else-if="industries.length" class="mt-4 space-y-2">
            <li
                v-for="ind in industries"
                :key="ind.slug"
                class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 dark:bg-slate-800/50"
            >
                <span class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                    <span>{{ ind.icon }}</span>
                    {{ ind.name }}
                </span>
                <span class="text-xs font-semibold text-ipko-600 dark:text-ipko-400">{{ ind.lead_count }} leads</span>
            </li>
        </ul>
        <p v-else class="mt-4 text-xs text-slate-500">No industry data yet.</p>
    </div>
</template>
