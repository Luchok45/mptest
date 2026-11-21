<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <div :class="cn('px-6 pb-5', props.class)">
        <slot />
    </div>
</template>

<style scoped>
@media (max-width: 1023px) {
    div {
        padding: 0 16px 16px;
    }
}
</style>
