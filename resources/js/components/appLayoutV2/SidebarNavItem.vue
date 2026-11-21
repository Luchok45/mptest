<script setup lang="ts">
import type { InertiaLinkProps} from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

defineProps<{
    icon: LucideIcon;
    title: string;
    isActive?: boolean;
    href: NonNullable<InertiaLinkProps['href']>;
}>();
</script>

<template>
    <Link
        as="div"
        :data-active="isActive ?? false"
        class="group flex flex-row items-center gap-2 rounded-xl px-1.5 py-2 hover:cursor-pointer hover:bg-secondary/10 data-[active=true]:bg-secondary/10"
        prefetch
        :href="href"
    >
        <component
            :is="icon"
            class="h-4 w-4 text-sidebar-foreground group-hover:text-primary group-data-[active=true]:text-primary"
        />
        <span
            class="text-sm leading-5 font-medium text-sidebar-foreground group-hover:text-primary group-data-[active=true]:text-primary"
        >{{ title }}</span>
    </Link>
</template>

<style scoped></style>
