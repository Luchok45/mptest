<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';

const props = defineProps<{class?: HTMLAttributes['class']}>();
</script>

<template>
    <div :class="cn('p-6 flex flex-col gap-0', props.class)">
        <slot/>
    </div>
</template>

<style scoped>
@media (max-width: 1023px) {
    .flex-col {
        padding: 16px;
    }
}
</style>
