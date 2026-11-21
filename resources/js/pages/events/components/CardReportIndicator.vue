<script setup lang="ts">
import type { LucideIcon } from 'lucide-vue-next';

defineProps<{
    label: string;
    value: string;
    icon: LucideIcon;
}>();
</script>

<template>
    <div class="flex flex-row items-center gap-3">
        <div class="p-2 rounded-xl bg-blue-500/10 text-blue-500">
            <component v-bind:is="icon" class="h-6 w-6"/>
        </div>

        <div class="flex flex-col gap-1">
            <span class="text-sm leading-none font-medium text-muted-foreground">{{ label }}</span>
            <span class="text-sm leading-none font-semibold text-foreground">{{ value }}</span>
        </div>
    </div>
</template>

<style scoped>
@media (max-width: 1023px) {
    .p-2 {
        flex-shrink: 0;
    }

    .flex-col.gap-1 {
        min-width: 0;
    }

    .flex-col.gap-1 > span {
        line-height: 18px;
    }
}
</style>
