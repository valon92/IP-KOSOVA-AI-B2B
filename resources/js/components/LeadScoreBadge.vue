<script setup>
import { computed } from 'vue';

const props = defineProps({
    score: { type: Number, required: true },
    status: { type: String, default: 'cold' },
});

const badgeClass = computed(() => {
    if (props.score > 75 || props.status === 'hot') {
        return 'ipko-badge-hot';
    }
    if (props.score >= 40 || props.status === 'medium') {
        return 'ipko-badge-medium';
    }
    return 'ipko-badge-cold';
});

const label = computed(() => {
    if (props.score > 75) return 'Hot';
    if (props.score >= 40) return 'Medium';
    return 'Low';
});
</script>

<template>
    <span
        class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold transition-transform hover:scale-105"
        :class="badgeClass"
    >
        <span class="h-1.5 w-1.5 rounded-full bg-current opacity-70" />
        {{ score }} · {{ label }}
    </span>
</template>
