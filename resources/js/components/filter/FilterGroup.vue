<script setup lang="ts">
defineProps<{ title: string }>();
</script>

<template>
    <div class="flex flex-col gap-2">
        <span
            class="text-xs leading-none font-semibold text-muted-foreground"
            >{{ title }}</span
        >
        <div class="flex flex-row flex-wrap gap-2">
            <slot/>
        </div>
    </div>
</template>

<style scoped></style>
