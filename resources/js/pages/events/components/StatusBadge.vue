<script setup lang="ts">
import {
    SquarePen,
    Hourglass,
    CircleAlert,
    Check,
    FilePen,
    FileClock,
    FileX,
    FileCheck,
    Archive,
} from 'lucide-vue-next';
import type { EventStatus } from '@/types';

defineProps<{
    status: EventStatus;
}>();
</script>

<template>
    <div
        class="flex w-fit flex-row items-center justify-center gap-0.5 rounded-xl px-2 py-1"
        :class="{
            'bg-gray-200/50 text-muted-foreground': status.color === 'gray',
            'bg-blue-500/10 text-primary': status.color === 'blue',
            'bg-yellow-600/10 text-yellow-500': status.color === 'yellow',
            'bg-red-600/10 text-red-600': status.color === 'red',
            'bg-green-600/10 text-green-600': status.color === 'green',
        }"
    >
        <SquarePen v-if="status.value === 'draft'" class="h-4 w-4" />
        <Hourglass v-if="status.value === 'agreement'" class="h-4 w-4" />
        <CircleAlert v-if="status.value === 'revision'" class="h-4 w-4" />
        <Check v-if="status.value === 'published'" class="h-4 w-4" />
        <FilePen v-if="status.value === 'in-reporting'" class="h-4 w-4" />
        <FileClock
            v-if="status.value === 'in-report-agreement'"
            class="h-4 w-4"
        />
        <FileX v-if="status.value === 'in-report-revision'" class="h-4 w-4" />
        <FileCheck
            v-if="status.value === 'in-report-published'"
            class="h-4 w-4"
        />
        <Archive v-if="status.value === 'archived'" class="h-4 w-4" />

        <span class="font-raleway p-1 text-sm font-semibold">{{
            status.display_name
        }}</span>
    </div>
</template>

<style scoped></style>
