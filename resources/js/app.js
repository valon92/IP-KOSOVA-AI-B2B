import './bootstrap';
import { createApp } from 'vue';
import Dashboard from './components/Dashboard.vue';
import InfoPage from './components/InfoPage.vue';

const dashboardEl = document.getElementById('ipko-dashboard');
const infoEl = document.getElementById('ipko-info');

if (dashboardEl) {
    createApp(Dashboard).mount(dashboardEl);
}

if (infoEl) {
    createApp(InfoPage).mount(infoEl);
}
