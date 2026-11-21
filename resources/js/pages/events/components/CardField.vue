<script setup lang="ts">
defineProps<{
    title: string;
    content?: string;
}>()
</script>

<template>
    <div class="flex flex-col gap-1">
        <span class="font-raleway font-medium text-sm text-muted-foreground">
            {{ title }}
        </span>

        <slot>
            <span v-if="!!content" class="font-raleway font-medium text-base text-foreground">
                {{ content }}
            </span>
        </slot>
    </div>
</template>

<style scoped></style>
