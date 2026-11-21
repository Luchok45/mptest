<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { getLocalTimeZone, parseAbsolute } from '@internationalized/date';
import type { DateValue } from 'reka-ui';
import Block from '@/components/announcements/Block.vue';
import PageContent from '@/components/appLayoutV2/PageContent.vue';
import PageHeader from '@/components/appLayoutV2/PageHeader.vue';
import PageHeaderTop from '@/components/appLayoutV2/PageHeaderTop.vue';
import NoContent from '@/components/NoContent.vue';
import { Calendar } from '@/components/ui/calendar';
import { Input } from '@/components/ui/input';
import AppLayoutV2 from '@/layouts/AppLayoutV2.vue';
import type { EventFullResource } from '@/types/models/event';

defineProps<{
    announcements: {
        [key: string]: EventFullResource[];
    };
}>();

function onSearch(value) {
    router.reload({
        data: {
            search: value ?? null,
        },
    });
}

function onDate(date?: DateValue) {
    router.reload({
        data: {
            date: !!date ? date.toDate(getLocalTimeZone()).setHours(12) : null,
        },
    });
}
</script>

<template>
    <Head title="Афиша мероприятий" />

    <AppLayoutV2>
        <template #header>
            <PageHeader>
                <template #top-header>
                    <PageHeaderTop title="Афиша мероприятий" />
                </template>
            </PageHeader>
        </template>

        <PageContent>
            <div class="flex flex-row gap-3">
                <div class="flex w-full flex-col gap-3">
                    <template v-if="Object.keys(announcements).length > 0">
                        <Block
                            v-for="(elements, date) in announcements"
                            :key="date"
                            :date="date as string"
                            :elements="elements"
                        />
                    </template>

                    <template v-else>
                        <NoContent
                            label="Мероприятия не найдены"
                            description="Попробуйте изменить параметры поиска или настройки фильтрации"
                        />
                    </template>
                </div>

                <div class="flex flex-col gap-3">
                    <Input
                        id="search"
                        name="search"
                        type="text"
                        placeholder="Поиск"
                        :default-value="$page.props.query.search"
                        @change="(e) => onSearch(e.target.value)"
                    />

                    <div class="rounded-lg border">
                        <Calendar
                            layout="month-and-year"
                            locale="ru-RU"
                            @update:model-value="onDate"
                            :model-value="
                                !!$page.props.query.date
                                    ? parseAbsolute(
                                          new Date(
                                              Number($page.props.query.date),
                                          ).toISOString(),
                                          getLocalTimeZone(),
                                      )
                                    : undefined
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
    .flex-row.gap-3 {
        flex-direction: column;
        gap: 16px;
    }

    .flex-row.gap-3 > div:first-child {
        min-width: 0;
    }

    .flex-row.gap-3 > div:last-child {
        display: contents;
    }

    .flex-row.gap-3 > div:last-child > input {
        order: -1;
    }

    .rounded-lg.border {
        order: 1;
        display: flex;
        justify-content: center;
    }
}

@media (max-width: 767px) {
    .rounded-lg.border {
        display: none;
    }
}
</style>
