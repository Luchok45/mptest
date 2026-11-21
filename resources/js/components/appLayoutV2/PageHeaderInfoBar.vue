<script setup lang="ts"></script>

<template>
    <div class="flex flex-row gap-2 items-center justify-between">
        <slot/>
    </div>
</template>

<style scoped>
@media (max-width: 1023px) {
    div {
        flex-wrap: wrap;
    }
}
</style>
