<script setup lang="ts">
defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div v-if="!!title || !!description" class="flex flex-col gap-1">
        <span
            v-if="!!title"
            class="font-raleway text-lg font-semibold text-foreground"
            >
            {{ title}}
        </span>

        <span
            v-if="!!description"
            class="font-raleway text-sm font-medium text-muted-foreground"
            >
            {{ description }}
        </span>
    </div>
</template>

<style scoped></style>
