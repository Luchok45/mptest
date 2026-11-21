<script setup lang="ts"></script>

<template>
    <header
        class="flex flex-col gap-0 border-b border-border bg-background p-0 rounded-tr-3xl"
    >
        <slot name="top-header" />
        <slot name="bottom-header"/>
    </header>
</template>

<style scoped></style>
