<script setup>
import { businessInitials } from '../composables/useBusinessDisplay';

defineProps({
    businesses: { type: Array, default: () => [] },
    loading: { type: Boolean, default: false },
});

const emit = defineEmits(['open-detail']);
</script>

<template>
    <div class="ipko-card overflow-hidden">
        <div class="border-b border-slate-200 px-4 py-3 dark:border-slate-700 sm:px-6 sm:py-4">
            <h2 class="text-base font-semibold text-slate-900 sm:text-lg dark:text-white">Business Registry</h2>
            <p class="mt-0.5 text-xs text-slate-500 sm:text-sm dark:text-slate-400">
                Të gjitha bizneset e regjistruara në platformë (përfshirë të rejat)
            </p>
        </div>
        <div class="max-h-64 overflow-y-auto p-3 sm:p-4">
            <div v-if="loading" class="py-6 text-center text-sm text-slate-500">Duke ngarkuar…</div>
            <p v-else-if="businesses.length === 0" class="py-6 text-center text-sm text-slate-500">Asnjë biznes në regjistër.</p>
            <ul v-else class="space-y-2">
                <li
                    v-for="b in businesses"
                    :key="b.id"
                    class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-100 px-3 py-2.5 transition hover:border-ipko-200 hover:bg-ipko-50/50 dark:border-slate-800 dark:hover:border-ipko-800 dark:hover:bg-ipko-950/20"
                    @click="emit('open-detail', b.id)"
                >
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-ipko-500 to-ipko-700 text-xs font-bold text-white">
                        {{ businessInitials(b.name) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-slate-900 dark:text-white">{{ b.name }}</p>
                        <p class="truncate text-xs text-slate-500">
                            {{ b.location }} · {{ b.industry?.name ?? '—' }}
                        </p>
                    </div>
                    <span
                        v-if="b.is_verified"
                        class="shrink-0 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400"
                    >
                        ✓
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>
