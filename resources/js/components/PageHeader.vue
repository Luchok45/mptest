<script setup lang="ts">

defineProps<{
    title?: undefined | string;
    description?: undefined | string;
    variant?: undefined | 'lg' | 'md'
}>();

</script>

<template>
    <div
        class="flex flex-row"
        :class="{
            'gap-9': variant === undefined || variant === 'lg',
            'gap-4 py-3': variant === 'md',
        }"
    >
        <div v-if="!!title || !!description" class="flex flex-col gap-0">
            <span
                v-if="!!title"
                class="font-semibold leading-none text-foreground"
                :class="{
                    'text-2xl': variant === undefined || variant === 'lg',
                    'text-lg': variant === 'md',
                }"
                >{{ title }}</span
            >
            <span
                v-if="!!description"
                class="font-medium leading-none text-muted-foreground"
                :class="{
                    'text-base': variant === undefined || variant === 'lg',
                    'text-sm': variant === 'md',
                }"
                >{{ description }}</span>
        </div>
    </div>
</template>

<style scoped></style>
