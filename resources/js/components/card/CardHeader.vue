<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';

const props = defineProps<{
    class?: HTMLAttributes['class'];
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        :class="
            cn(
                'flex flex-row items-center justify-between gap-4 px-6 py-5',
                props.class,
            )
        "
    >
        <div class="flex flex-col gap-1">
            <span v-if="!!title" class="leading-6 font-semibold text-lg text-foreground">{{ title }}</span>
            <span v-if="!!description" class="leading-5 font-medium text-sm text-muted-foreground">{{ description }}</span>
        </div>

        <div class="flew flex-row gap-1 items-center">
            <slot name="actions"/>
        </div>
    </div>
</template>

<style scoped>
@media (max-width: 1023px) {
    .justify-between {
        flex-wrap: wrap;
        padding: 16px 16px 12px;
    }

    .justify-between > div:first-child {
        min-width: 0;
        flex: 1;
    }
}
</style>
