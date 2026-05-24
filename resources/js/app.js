import './bootstrap';
import { createApp } from 'vue';
import Dashboard from './components/Dashboard.vue';
import InfoPage from './components/InfoPage.vue';
import RegisterBusinessPage from './components/RegisterBusinessPage.vue';
import LoginPage from './components/LoginPage.vue';

import PrivacyPage from './components/PrivacyPage.vue';
import TermsPage from './components/TermsPage.vue';
import DpaPage from './components/DpaPage.vue';
import StatusPage from './components/StatusPage.vue';

const dashboardEl = document.getElementById('ipko-dashboard');
const infoEl = document.getElementById('ipko-info');
const registerEl = document.getElementById('ipko-register-business');
const loginEl = document.getElementById('ipko-login');
const privacyEl = document.getElementById('ipko-privacy');
const termsEl = document.getElementById('ipko-terms');
const dpaEl = document.getElementById('ipko-dpa');
const statusEl = document.getElementById('ipko-status');

if (dashboardEl) {
    createApp(Dashboard).mount(dashboardEl);
}

if (infoEl) {
    createApp(InfoPage).mount(infoEl);
}

if (registerEl) {
    createApp(RegisterBusinessPage).mount(registerEl);
}

if (loginEl) {
    createApp(LoginPage).mount(loginEl);
}

if (privacyEl) {
    createApp(PrivacyPage).mount(privacyEl);
}

if (termsEl) {
    createApp(TermsPage).mount(termsEl);
}

if (dpaEl) {
    createApp(DpaPage).mount(dpaEl);
}

if (statusEl) {
    createApp(StatusPage).mount(statusEl);
}
