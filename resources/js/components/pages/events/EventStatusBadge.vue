<script setup lang="ts">
import { cva } from 'class-variance-authority';
import {
    Archive,
    CircleAlert,
    FileX2,
    Check,
    SquarePen,
    FilePen,
    Hourglass,
    FileClock,
    FileCheck,
} from 'lucide-vue-next';
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';
import type { EventStatus } from '@/types';

const eventStatusVariants = cva(
    'flex flex-row items-center gap-0.5 rounded-xl px-2 py-1',
    {
        variants: {
            color: {
                blue: 'bg-secondary/10 text-primary',
                yellow: 'bg-warning/10 text-warning',
                red: 'bg-destructive/10 text-destructive',
                green: 'bg-success/10 text-success',
                gray: 'bg-accent/50 text-muted-foreground',
            },
        },
        defaultVariants: {
            color: 'gray',
        },
    },
);

const props = defineProps<{
    class?: HTMLAttributes['class'];
    status: EventStatus;
}>();
</script>

<template>
    <div
        :class="
            cn(eventStatusVariants({ color: props.status.color }), props.class)
        "
    >
        <CircleAlert class="h-4 w-4" v-if="status.value === 'revision'" />
        <FileX2 class="h-4 w-4" v-if="status.value === 'in-report-revision'" />
        <Check class="h-4 w-4" v-if="status.value === 'published'" />
        <SquarePen class="h-4 w-4" v-if="status.value === 'draft'" />
        <FilePen class="h-4 w-4" v-if="status.value === 'in-reporting'" />
        <Hourglass class="h-4 w-4" v-if="status.value === 'agreement'" />
        <FileClock
            class="h-4 w-4"
            v-if="status.value === 'in-report-agreement'"
        />
        <Archive class="h-4 w-4" v-if="status.value === 'archived'" />
        <FileCheck
            class="h-4 w-4"
            v-if="status.value === 'in-report-published'"
        />

        <span class="px-1 text-sm leading-5 font-semibold">{{
            status.display_name
        }}</span>
    </div>
</template>

<style scoped></style>
