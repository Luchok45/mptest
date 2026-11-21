<script setup lang="ts">
</script>

<template>
    <div class="flex flex-row items-center justify-between gap-1">
        <div class="flex flex-row items-center justify-start gap-1">
            <slot name="left-buttons"/>
        </div>

        <div class="flex flex-row items-center justify-end gap-1">
            <slot name="right-buttons"/>
        </div>
    </div>
</template>

<style scoped></style>
