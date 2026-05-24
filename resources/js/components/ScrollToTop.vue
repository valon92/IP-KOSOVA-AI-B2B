<script setup>
import { onMounted, onUnmounted, ref } from 'vue';

const visible = ref(false);
const threshold = 320;

function onScroll() {
    visible.value = window.scrollY > threshold;
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

onMounted(() => {
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
});

onUnmounted(() => {
    window.removeEventListener('scroll', onScroll);
});
</script>

<template>
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="translate-y-4 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-4 opacity-0"
    >
        <button
            v-show="visible"
            type="button"
            class="fixed bottom-6 right-4 z-50 flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-ipko-500 to-ipko-700 text-white shadow-lg shadow-ipko-600/40 ring-1 ring-white/20 transition hover:scale-105 hover:shadow-xl active:scale-95 sm:bottom-8 sm:right-8"
            aria-label="Kthehu në fillim"
            @click="scrollToTop"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </button>
    </Transition>
</template>
