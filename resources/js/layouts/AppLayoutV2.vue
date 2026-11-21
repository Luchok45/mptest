<script setup lang="ts">
import axios from 'axios';
import { onMounted, ref } from 'vue';
import Sidebar from '@/components/appLayoutV2/Sidebar.vue';
import { useCheatCode } from '@/composables/useCheatCode';

const easterEggActivated = ref(false);

useCheatCode(
    ['KeyH', 'KeyE', 'KeyS', 'KeyO', 'KeyY', 'KeyA', 'KeyM'],
    () => {
        easterEggActivated.value = true;

        window.setTimeout(() => {
            easterEggActivated.value = false;
        }, 5000);
    },
    { usePhysicalKeys: true },
);

onMounted(() => { axios.get('/sanctum/csrf-cookie'); });
</script>

<template>
    <div class="min-h-svh bg-muted p-[1svh]">
        <div
            class="flex min-h-[98svh] flex-row rounded-3xl border border-border bg-background"
        >
            <Sidebar />

            <main class="min-h-[98svh] flex-1 rounded-r-3xl bg-background">
                <slot name="header" />

                <slot />
            </main>
        </div>
    </div>

    <Transition name="cheat">
        <div v-if="easterEggActivated" class="cheat-notification">
            <strong>Чит активирован</strong>
            <span>Здоровье, броня и $250 000</span>
        </div>
    </Transition>
</template>

<style scoped>
.cheat-notification {
    position: fixed;
    top: 32px;
    right: 32px;
    z-index: 9999;

    display: flex;
    flex-direction: column;
    gap: 4px;

    padding: 16px 24px;
    border: 2px solid #fff;
    border-radius: 4px;

    color: #fff;
    background: rgb(0 0 0 / 85%);
    font-family: monospace;
    text-transform: uppercase;
    box-shadow: 0 8px 30px rgb(0 0 0 / 35%);
}

.cheat-enter-active,
.cheat-leave-active {
    transition:
        opacity 0.25s ease,
        transform 0.25s ease;
}

.cheat-enter-from,
.cheat-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}

@media (max-width: 1023px) {
    .bg-muted {
        padding: 0;
        background-color: var(--background);
    }

    .bg-muted > div {
        flex-direction: column;
        min-height: 100svh;
        border: none;
        border-radius: 0;
    }

    .bg-muted > div > main {
        min-height: auto;
        min-width: 0;
        border-radius: 0;
        padding-bottom: 96px;
    }
}

@media (max-width: 767px) {
    .cheat-notification {
        top: 16px;
        right: 16px;
        left: 16px;
    }
}
</style>
