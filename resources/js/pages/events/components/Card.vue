<script setup lang="ts">
</script>

<template>
    <div class="rounded-2xl border border-gray-200 py-5 px-6">
        <slot/>
    </div>
</template>

<style scoped>
@media (max-width: 1023px) {
    .rounded-2xl {
        padding: 16px;
    }
}
</style>
