<script setup>
const props = defineProps({
    metrics: {
        type: Object,
        default: () => ({
            total_visits: 0,
            unique_companies: 0,
            average_lead_score: 0,
            conversion_rate: 0,
        }),
    },
    loading: { type: Boolean, default: false },
});

const cards = [
    { key: 'total_visits', label: 'Total Visits', icon: '👁' },
    { key: 'unique_companies', label: 'Unique Companies', icon: '🏢' },
    { key: 'average_lead_score', label: 'Avg Lead Score', icon: '⚡' },
    { key: 'conversion_rate', label: 'Conversion Rate', icon: '📈', suffix: '%' },
];
</script>

<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div
            v-for="card in cards"
            :key="card.key"
            class="ipko-card group p-5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md"
        >
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                        {{ card.label }}
                    </p>
                    <p
                        v-if="!loading"
                        class="mt-2 text-3xl font-bold tracking-tight text-slate-900 dark:text-white"
                    >
                        {{ props.metrics?.[card.key] ?? 0 }}{{ card.suffix || '' }}
                    </p>
                    <div v-else class="mt-3 h-9 w-24 animate-pulse rounded-lg bg-slate-200 dark:bg-slate-700" />
                </div>
                <span class="text-2xl opacity-80 transition-transform group-hover:scale-110">{{ card.icon }}</span>
            </div>
        </div>
    </div>
</template>
