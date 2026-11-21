<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Label } from '@/components/ui/label';

defineProps<{
    id: string,
    title: string,
    errorMessage?: undefined|string,
}>();
</script>

<template>
    <div class="grid gap-2">
        <Label :for="id">{{ title }}</Label>
        <slot/>
        <InputError :message="errorMessage"/>
    </div>
</template>

<style scoped></style>
