import axios from 'axios';

const apiKey = import.meta.env.VITE_IPKO_API_KEY || window.IPKO_DASHBOARD_API_KEY || '';

const client = axios.create({
    baseURL: '/api/v1',
    headers: {
        Accept: 'application/json',
        'X-Api-Key': apiKey,
    },
});

export default client;
