<script setup lang="ts">
defineProps<{
    title: string;
    active?: boolean;
}>();
</script>

<template>
    <div
        :data-active="active ?? false"
        class="cursor-pointer rounded-lg border border-border px-2 py-1 text-sm leading-5 font-medium text-muted-foreground data-[active=true]:bg-secondary/10 data-[active=true]:text-primary"
    >
        {{ title }}
    </div>
</template>

<style scoped></style>
