<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { nl2br } from '@/lib/nlUtils';
import RegistryBlock from '@/pages/announcements/RegistryBlock.vue';
import type { EventFullResource } from '@/types/models/event';
import AppLayoutV2 from '@/layouts/AppLayoutV2.vue';
import PageContent from '@/components/appLayoutV2/PageContent.vue';

defineProps<{
    event: EventFullResource;
    registryAvailable: boolean;
    meRegistered: boolean;
}>();
</script>

<template>
    <Head :title="event.main.name" />
    <AppLayoutV2>
        <PageContent>
            <div class="flex flex-row gap-6">
                <div class="flex flex-col">
                    <img
                        v-if="!!event.announcement.image_file"
                        :src="event.announcement.image_file?.public_link"
                        :alt="event.main.name"
                        class="aspect-square w-[320px] rounded-2xl object-cover object-center"
                    />
                </div>

                <div class="flex w-full flex-col gap-6">
                    <span
                        class="text-3xl leading-9 font-semibold text-foreground"
                    >
                        {{ event.main.name }}
                    </span>

                    <RegistryBlock
                        :event="event"
                        :registry-available="registryAvailable"
                        :me-registered="meRegistered"
                    />

                    <div class="flex flex-col gap-3">
                        <span
                            class="text-sm leading-none font-medium text-muted-foreground"
                            >О мероприятии</span
                        >
                        <div class="border-y border-gray-200" />
                        <span
                            class="text-base leading-5 font-medium text-foreground"
                            v-html="
                                nl2br(
                                    event.announcement.description ?? '',
                                    true,
                                    false,
                                )
                            "
                        />
                    </div>
                </div>
            </div>
        </PageContent>
    </AppLayoutV2>
</template>

<style scoped>
@media (max-width: 1023px) {
    .flex-row.gap-6 {
        flex-direction: column;
        gap: 16px;
    }

    img {
        width: 100%;
        max-width: 480px;
        border-radius: 16px;
    }

    .flex-row.gap-6 > div:last-child {
        min-width: 0;
        gap: 16px;
        overflow-wrap: anywhere;
    }

    .flex-row.gap-6 > div:last-child > span:first-child {
        font-size: 20px;
        line-height: 26px;
    }
}
</style>
