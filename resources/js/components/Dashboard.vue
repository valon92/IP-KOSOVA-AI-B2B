<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import api from '../api/client';
import MetricsBar from './MetricsBar.vue';
import LiveFeed from './LiveFeed.vue';
import CompaniesTable from './CompaniesTable.vue';
import AppFooter from './AppFooter.vue';
import AppHeader from './AppHeader.vue';

const metrics = ref({
    total_visits: 0,
    unique_companies: 0,
    average_lead_score: 0,
    conversion_rate: 0,
});
const liveFeed = ref([]);
const companies = ref([]);
const loadingMetrics = ref(true);
const loadingFeed = ref(true);
const loadingCompanies = ref(true);
let pollTimer = null;

async function fetchMetrics() {
    loadingMetrics.value = true;
    try {
        const { data } = await api.get('/dashboard/metrics');
        if (data?.data) {
            metrics.value = { ...metrics.value, ...data.data };
        }
    } catch (e) {
        console.error('[IPKO] Failed to load metrics', e);
    } finally {
        loadingMetrics.value = false;
    }
}

async function fetchLiveFeed() {
    loadingFeed.value = true;
    try {
        const { data } = await api.get('/dashboard/live-feed');
        liveFeed.value = Array.isArray(data?.data) ? data.data : [];
    } catch (e) {
        console.error('[IPKO] Failed to load live feed', e);
        liveFeed.value = [];
    } finally {
        loadingFeed.value = false;
    }
}

async function fetchCompanies() {
    loadingCompanies.value = true;
    try {
        const { data } = await api.get('/dashboard/companies', { params: { per_page: 50 } });
        companies.value = Array.isArray(data?.data) ? data.data : [];
    } catch (e) {
        console.error('[IPKO] Failed to load companies', e);
        companies.value = [];
    } finally {
        loadingCompanies.value = false;
    }
}

async function refreshAll() {
    await Promise.all([fetchMetrics(), fetchLiveFeed(), fetchCompanies()]);
}

onMounted(() => {
    refreshAll();
    pollTimer = setInterval(() => {
        fetchLiveFeed();
        fetchMetrics();
    }, 15000);
});

onUnmounted(() => {
    if (pollTimer) clearInterval(pollTimer);
});
</script>

<template>
    <div class="flex min-h-screen flex-col bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
        <AppHeader active="dashboard" />

        <main class="mx-auto max-w-7xl space-y-4 px-3 py-5 sm:space-y-6 sm:px-6 sm:py-8 lg:px-8">
            <div class="flex justify-end">
                <button
                    type="button"
                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium transition hover:bg-slate-100 dark:border-slate-700 dark:hover:bg-slate-800"
                    @click="refreshAll"
                >
                    Refresh
                </button>
            </div>
            <MetricsBar :metrics="metrics" :loading="loadingMetrics" />

            <div class="grid grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-3">
                <div class="order-2 lg:order-1 lg:col-span-1">
                    <LiveFeed :items="liveFeed" :loading="loadingFeed" />
                </div>
                <div class="order-1 lg:order-2 lg:col-span-2">
                    <CompaniesTable :companies="companies" :loading="loadingCompanies" />
                </div>
            </div>
        </main>

        <AppFooter />
    </div>
</template>
