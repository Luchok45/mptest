<script setup lang="ts">
import { File } from 'lucide-vue-next';
import type { PreloadedFile } from '@/types/preloaded-file';

defineProps<{
    title?: string;
    file: PreloadedFile;
}>();
</script>

<template>
    <template v-if="!!file.public_link">
        <a
            :href="file.public_link"
            :download="`${title ?? file.original.filename}.${file.original.extension}`"
        >
            <div
                class="flex flex-row items-center gap-1 rounded-xl border border-border p-2"
            >
                <div class="rounded-[8px] bg-secondary/10 p-2">
                    <File class="h-4 w-4 text-primary" />
                </div>

                <span class="text-sm leading-none font-semibold text-foreground"
                    >{{ title ?? file.original.filename }}.{{
                        file.original.extension
                    }}</span
                >
            </div>
        </a>
    </template>

    <template v-else>
        <div
            class="flex flex-row items-center gap-1 rounded-xl border border-border p-2"
        >
            <div class="rounded-[8px] bg-secondary/10 p-2">
                <File class="h-4 w-4 text-primary" />
            </div>

            <span class="text-sm leading-none font-semibold text-foreground"
                >{{ title ?? file.original.filename }}.{{
                    file.original.extension
                }}</span
            >
        </div>
    </template>
</template>

<style scoped></style>
