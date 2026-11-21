<script setup lang="ts">
import { nl2br } from '@/lib/nlUtils';

defineProps<{ comment?: undefined | null | string }>();
</script>

<template>
    <div
        class="flex flex-col gap-0.5 rounded-xl border border-gray-200 bg-gray-200/50 p-4"
    >
        <span class="text-xs font-medium text-muted-foreground"
            >Комментарий администратора</span
        >
        <span
            class="text-sm font-medium text-foreground"
            v-html="nl2br(comment ?? '', true, false)"
        />
    </div>
</template>

<style scoped></style>
