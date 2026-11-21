<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
// import CustomLayout from '@/layouts/app/CustomLayout.vue';
import type { BreadcrumbItem } from '@/types';

const { breadcrumbs = [] } = defineProps<{
    breadcrumbs?: BreadcrumbItem[];
}>();
</script>

<template>
<!--    <CustomLayout>-->
<!--        <slot/>-->
<!--    </CustomLayout>-->
    <AppShell variant="sidebar">
        <AppSidebar />
        <AppContent variant="sidebar" class="overflow-x-hidden">
            <AppSidebarHeader>
                <slot name="header"/>
            </AppSidebarHeader>
            <slot />
        </AppContent>
    </AppShell>
</template>
