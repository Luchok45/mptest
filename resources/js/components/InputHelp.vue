<script setup lang="ts">
defineProps<{
    message?: string;
}>();
</script>

<template>
    <div v-show="message">
        <p class="text-sm font-raleway font-medium text-muted-foreground">
            {{ message }}
        </p>
    </div>
</template>
