<script setup lang="ts">
// import { SidebarTrigger } from '@/components/ui/sidebar';
</script>

<template>
    <header
        class="flex shrink-0 items-center border-b border-sidebar-border/70 py-5 px-6 transition-[width,height] ease-linear md:px-4"
    >
        <div class="w-full flex items-center gap-3">
<!--            <SidebarTrigger class="-ml-1" />-->
            <slot/>
        </div>
    </header>

<!--    <header-->
<!--        class="flex flex-col gap-1 shrink-0 border-b border-sidebar-border/70 transition-[width,height] ease-linear"-->
<!--    >-->
<!--        <slot/>-->
<!--    </header>-->
</template>
