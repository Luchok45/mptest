<script setup lang="ts">
import EventStatusBadge from '@/components/pages/events/EventStatusBadge.vue';
import { show } from '@/routes/events';
import type { EventFullResource } from '@/types/models/event';

defineProps<{ item: EventFullResource }>();
</script>

<template>
    <a
        :href="show(item.id).url"
        target="_blank"
        class="flex cursor-pointer flex-row gap-4 rounded-2xl border border-border bg-muted/25 px-4 pt-3.5 pb-4"
    >
        <img
            v-if="
                item.announcement.enabled &&
                !!item.announcement.image_file?.public_link
            "
            :src="item.announcement.image_file?.public_link"
            :alt="item.main.name"
            class="h-30 w-30 rounded-lg object-cover object-center"
        />

        <div class="flex h-full flex-1 flex-col justify-between gap-4">
            <div class="flex flex-col gap-1.5">
                <span
                    class="text-sm leading-none font-semibold text-muted-foreground"
                >
                    {{
                        new Date(item.dates.start_date).toLocaleDateString(
                            'ru-RU',
                            {
                                day: '2-digit',
                                month: 'long',
                            },
                        )
                    }}

                    <template v-if="!!item.dates.end_date">
                        -
                        {{
                            new Date(item.dates.end_date).toLocaleDateString(
                                'ru-RU',
                                {
                                    day: '2-digit',
                                    month: 'long',
                                },
                            )
                        }}
                    </template>
                </span>

                <span class="text-lg leading-6 font-semibold text-foreground">
                    {{ item.main.name }}
                </span>
            </div>

            <div class="flex flex-row items-center gap-3">
                <EventStatusBadge :status="item.system.status" />

                <template
                    v-if="
                        !(
                            item.system.status.sys_name === 'DRAFT' ||
                            item.system.status.sys_name === 'AGREEMENT' ||
                            item.system.status.sys_name === 'REVISION'
                        )
                    "
                >
                    <span class="py-1 leading-5 font-semibold text-sm text-muted-foreground">
                        <template v-if="item.registration.enabled">
                            {{ item.members_count }} <template v-if="(item.registration.members_count ?? 0) > 0">
                            / {{ item.registration.members_count }}
                        </template> регистраций
                        </template>
                        <template v-else>Без регистрации</template>
                    </span>
                </template>
            </div>
        </div>
    </a>
</template>

<style scoped>
@media (max-width: 1023px) {
    .rounded-2xl {
        gap: 12px;
        padding: 16px;
        border-radius: 16px;
        background-color: var(--background);
    }

    .rounded-2xl > img {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
    }

    .rounded-2xl > div {
        min-width: 0;
        gap: 12px;
        overflow-wrap: anywhere;
    }

    .rounded-2xl > div > div:first-child > span:first-child {
        font-size: 13px;
    }

    .rounded-2xl > div > div:first-child > span:last-child {
        font-size: 17px;
        line-height: 22px;
    }

    .flex-row.items-center.gap-3 {
        flex-wrap: wrap;
        row-gap: 4px;
    }
}

@media (max-width: 767px) {
    .rounded-2xl > img {
        display: none;
    }
}
</style>
