/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                ipko: {
                    50: '#eef9ff',
                    100: '#d9f1ff',
                    200: '#bce7ff',
                    300: '#8ed7ff',
                    400: '#59bdff',
                    500: '#339dff',
                    600: '#1a7ff5',
                    700: '#1369e1',
                    800: '#1655b6',
                    900: '#18498f',
                    950: '#132d57',
                },
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
            },
            animation: {
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
