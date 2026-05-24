import axios from 'axios';

const client = axios.create({
    baseURL: '/api/v1',
    withCredentials: true,
    headers: {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
});

let handlingUnauthorized = false;

async function clearSessionAndGoToLogin() {
    if (handlingUnauthorized) {
        return;
    }

    handlingUnauthorized = true;

    try {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
        await fetch('/logout', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {}),
            },
            credentials: 'include',
        });
    } catch {
        // Session may already be invalid — still send user to login.
    }

    window.location.replace('/login?expired=1');
}

client.interceptors.response.use(
    (response) => response,
    (error) => {
        const path = window.location.pathname;
        const onProtectedPage = path.startsWith('/dashboard');

        if (error.response?.status === 401 && onProtectedPage && !path.startsWith('/login')) {
            clearSessionAndGoToLogin();
        }

        return Promise.reject(error);
    }
);

export default client;
