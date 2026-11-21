<script setup lang="ts">
import { SearchX } from 'lucide-vue-next';

defineProps<{
    label: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex items-center justify-center p-8">
        <div class="flex flex-col items-center justify-center gap-4">
            <SearchX class="h-8 w-8 text-muted-foreground" />

            <div class="flex flex-col items-center justify-center gap-1">
                <span
                    class="text-sm leading-5 font-semibold text-muted-foreground"
                >
                    {{ label }}
                </span>

                <span
                    v-if="!!description"
                    class="text-sm leading-5 font-medium text-muted-foreground"
                >
                    {{ description }}
                </span>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
