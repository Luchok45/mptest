<script setup lang="ts">
defineProps<{
    title?: undefined | string;
    type?: undefined | 'vertical' | 'horizontal';
}>();
</script>

<template>
    <div class="flex flex-col gap-2 rounded-xl border bg-container p-4">
        <span v-if="!!title" class="font-raleway text-2xl text-foreground">
            {{ title }}
        </span>

        <div
            class="flex gap-2"
            :class="{
                'flex-col': type === undefined || type === 'vertical',
                'flex-row': type === 'horizontal',
            }"
        >
            <slot />
        </div>
    </div>
</template>

<style scoped></style>
