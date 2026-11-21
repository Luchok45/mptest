<script setup lang="ts">
import { Plus } from 'lucide-vue-next';

const emits = defineEmits<{ (e: 'click'): void }>();
</script>

<template>
    <div
        class="font-raleway flex flex-row items-center justify-center gap-2 rounded-xl border border-dashed bg-container p-2 text-sm font-semibold text-muted-foreground"
        @click="emits('click')"
    >
        <Plus /> <span>Добавить соорганизатора</span>
    </div>
</template>

<style scoped></style>
