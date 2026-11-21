<script setup lang="ts">
import { TabsContent } from '@/components/ui/tabs';
import { nl2br } from '@/lib/nlUtils';
import Card from '@/pages/events/components/Card.vue';
import CardField from '@/pages/events/components/CardField.vue';
import type { EventFullResource } from '@/types/models/event';
import FileInfoBlock from '@/components/FileInfoBlock.vue';

defineProps<{ event: EventFullResource }>();
</script>

<template>
    <TabsContent value="view">
        <div class="flex flex-row gap-2">
            <div class="w-3/4">
                <Card class="flex flex-col gap-4">
                    <span
                        class="text-lg leading-6 font-semibold text-foreground"
                    >
                        {{ event.main.name }}
                    </span>

                    <CardField
                        title="Целевая аудитория"
                        :content="event.plan.target_audience"
                    />

                    <CardField title="Полное описание">
                        <div
                            v-html="
                                nl2br(event.plan.description ?? '', true, false)
                            "
                        />
                    </CardField>

                    <CardField title="Цель мероприятия по SMART">
                        <div
                            v-html="
                                nl2br(
                                    event.plan.target_smart ?? '',
                                    true,
                                    false,
                                )
                            "
                        />
                    </CardField>

                    <CardField title="Качественные показатели">
                        <div
                            v-html="
                                nl2br(
                                    event.plan.qualitative_indicators ?? '',
                                    true,
                                    false,
                                )
                            "
                        />
                    </CardField>

                    <!--                    <div class="border-y border-gray-200" />-->

                    <!--                    <div class="flex flex-row gap-4">-->
                    <!--                                            <CardField-->
                    <!--                                                title="Регистрация"-->
                    <!--                                                :content="-->
                    <!--                                                    'До 23:59 ' +-->
                    <!--                                                    new Date(-->
                    <!--                                                        event.registry_end_date,-->
                    <!--                                                    ).toLocaleDateString('ru-RU', {-->
                    <!--                                                        day: '2-digit',-->
                    <!--                                                        month: 'long',-->
                    <!--                                                        year: 'numeric',-->
                    <!--                                                    })-->
                    <!--                                                "-->
                    <!--                                            />-->

                    <!--                                            <CardField-->
                    <!--                                                title="Участников"-->
                    <!--                                                :content="-->
                    <!--                                                    event.registry_members_count > 0-->
                    <!--                                                        ? 'До ' + event.registry_members_count-->
                    <!--                                                        : 'Неограничено'-->
                    <!--                                                "-->
                    <!--                                            />-->
                    <!--                    </div>-->

                    <div class="grid grid-cols-3 gap-2">
                        <FileInfoBlock
                            v-if="!!event.plan.scenario_file"
                            title="Сценарий"
                            :file="event.plan.scenario_file"
                        />

                        <FileInfoBlock
                            v-if="!!event.plan.estimate_file"
                            title="Смета"
                            :file="event.plan.estimate_file"
                        />
                    </div>
                </Card>
            </div>
            <div class="flex w-1/4 flex-col gap-2">
                <Card class="flex flex-col gap-4">
                    <CardField
                        title="Дата проведения"
                        :content="
                            new Date(event.dates.start_date).toLocaleDateString(
                                'ru-RU',
                                {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric',
                                },
                            )
                        "
                    />

                    <CardField
                        title="Время начала"
                        :content="event.dates.start_date.substring(0, 4)"
                    />

                    <template v-if="Boolean(event.registration.enabled)">
                        <div class="border-y border-gray-200" />

                        <CardField
                            title="Регистрация"
                            :content="
                                'До 23:59 ' +
                                new Date(
                                    event.registration.end_date!,
                                ).toLocaleDateString('ru-RU', {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric',
                                })
                            "
                        />

                        <CardField
                            title="Лимит заявок"
                            :content="
                                !!event.registration.members_count &&
                                event.registration.members_count > 0
                                    ? 'До ' + event.registration.members_count
                                    : 'Неограничено'
                            "
                        />
                    </template>
                </Card>
                <Card class="flex flex-col gap-4">
                    <CardField
                        title="Уровень мероприятия"
                        :content="event.main.event_level.display_name"
                    />

                    <CardField
                        title="Направление деятельности"
                        :content="event.main.activity_direction.display_name"
                    />

                    <CardField
                        title="Направление молодёжной политики"
                        :content="
                            event.main.youth_policy_direction.display_name
                        "
                    />
                </Card>
            </div>
        </div>
    </TabsContent>
</template>

<style scoped>
@media (max-width: 1023px) {
    [data-slot="tabs-content"] > .flex-row {
        flex-direction: column;
    }

    [data-slot="tabs-content"] > .flex-row > div {
        width: 100%;
        min-width: 0;
        overflow-wrap: anywhere;
    }

    [data-slot="tabs-content"] > .flex-row > div:last-child {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .grid-cols-3 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 767px) {
    [data-slot="tabs-content"] > .flex-row > div:last-child {
        grid-template-columns: 1fr;
    }

    .grid-cols-3 {
        grid-template-columns: 1fr;
    }
}
</style>
