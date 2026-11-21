<script setup lang="ts">
import type { InertiaLinkProps } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import type { VariantProps } from 'class-variance-authority';
import { cva } from 'class-variance-authority';
import { ChevronLeft } from 'lucide-vue-next';
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';

const pageHeaderTopVariants = cva('flex flex-col gap-3', {
    variants: {
        variant: {
            sm: 'px-6 py-2',
            lg: 'px-6 py-5',
        },
    },
    defaultVariants: {
        variant: 'sm',
    },
});

interface Props {
    variant?: VariantProps<typeof pageHeaderTopVariants>['variant'];
    class?: HTMLAttributes['class'];
    title?: string;
    description?: string;
    backHref?: InertiaLinkProps['href'];
}

const props = defineProps<Props>();
</script>

<template>
    <div :class="cn(pageHeaderTopVariants({ variant }), props.class)">
        <div class="flex flex-row items-center gap-3">
            <Link
                v-if="!!backHref"
                :href="backHref"
                class="flex h-8 w-8 items-center justify-center"
                prefetch
            >
                <ChevronLeft class="h-4 w-4 text-foreground" />
            </Link>
            <div class="flex flex-1 flex-col gap-1">
                <span
                    v-if="!!title"
                    class="text-xl leading-7 font-semibold text-foreground"
                    >{{ title }}</span
                >
                <span
                    v-if="!!description"
                    class="text-sm leading-5 font-medium text-muted-foreground"
                    >{{ description }}</span
                >
            </div>

            <div v-if="!!$slots.actions" class="flex flex-row gap-1">
                <slot name="actions" />
            </div>
        </div>

        <slot name="info-bar"/>
    </div>
</template>

<style scoped>
@media (max-width: 1023px) {
    .flex-col.gap-3 {
        padding: 16px 16px 12px;
    }

    .flex-row.gap-3 {
        flex-wrap: wrap;
        row-gap: 12px;
    }

    .flex-row.gap-3 > a {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        border: 1px solid var(--border);
        border-radius: 9999px;
    }

    .flex-1.flex-col {
        min-width: 0;
        overflow-wrap: anywhere;
    }

    .flex-1.flex-col > span:first-child {
        font-size: 20px;
        line-height: 26px;
    }

    .flex-1.flex-col > span:nth-child(2) {
        font-size: 13px;
        line-height: 18px;
    }
}

@media (max-width: 767px) {
    .flex-row.gap-1 {
        width: 100%;
    }

    .flex-row.gap-1 > :deep(*) {
        flex: 1;
    }
}
</style>
