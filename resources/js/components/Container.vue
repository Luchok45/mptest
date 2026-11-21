<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <div
        :class="cn('bg-container rounded-xl border', props.class)"
    >
        <slot/>
    </div>
</template>

<style scoped></style>
