<script setup lang="ts">
import PageContent from '@/components/appLayoutV2/PageContent.vue';
</script>

<template>
    <PageContent class="gap-3">
        <slot name="top-full" />
        <div class="flex flex-row gap-6">
            <div class="flex-1">
                <slot name="left" />
            </div>

            <div class="w-66.5">
                <slot name="right" />
            </div>
        </div>
        <slot name="bottom-full" />
    </PageContent>
</template>

<style scoped>
@media (max-width: 1023px) {
    .flex-row.gap-6 {
        flex-direction: column;
        gap: 16px;
    }

    .flex-row.gap-6 > div:first-child {
        min-width: 0;
    }

    .flex-row.gap-6 > div:last-child {
        order: -1;
        width: 100%;
    }
}
</style>
