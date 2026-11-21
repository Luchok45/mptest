<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowUpRight, Copy } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { TabsContent } from '@/components/ui/tabs';
import Card from '@/pages/events/components/Card.vue';
import CardHeader from '@/pages/events/components/CardHeader.vue';
import SendToAgreementModal from '@/pages/events/modals/SendToAgreementModal.vue';
import { edit } from '@/routes/events';
import { show as showAnnouncement } from '@/routes/announcements';
import type { EventFullResource } from '@/types/models/event';
import RejectAgreementModal from '@/pages/events/modals/RejectAgreementModal.vue';
import ResolveAgreementModal from '@/pages/events/modals/ResolveAgreementModal.vue';
import CardComment from '@/pages/events/components/CardComment.vue';
import { Progress } from '@/components/ui/progress';
import { canF } from '@/plugins/privileges-plugin';
import SendToReportAgreementModal from '@/pages/events/modals/SendToReportAgreementModal.vue';
import RejectReportAgreementModal from '@/pages/events/modals/RejectReportAgreementModal.vue';
import ResolveReportAgreementModal from '@/pages/events/modals/ResolveReportAgreementModal.vue';

defineProps<{
    event: EventFullResource;
    canModerate: boolean;
}>();
</script>

<template>
    <TabsContent value="controls">
        <div class="flex flex-row gap-2">
            <div class="w-3/4">
                <div class="flex flex-col gap-2">
                    <Card
                        v-if="event.system.status.value === 'draft'"
                        class="bg-muted"
                    >
                        <CardHeader
                            title="Вы создали черновик мероприятия"
                            description="Завершите заполнение информации о мероприятии и предоставьте доступ к управлении соорганизаторам"
                        />
                    </Card>

                    <Card
                        v-if="event.system.status.value === 'revision'"
                        class="bg-muted"
                    >
                        <CardHeader
                            title="Мероприятие не было согласовано, получены правки"
                            description="Внесите необходимые правки и отправьте на повторное согласование"
                        />

                        <CardComment
                            v-if="!!event.system.reject_comment"
                            class="mt-2"
                            :comment="event.system.reject_comment"
                        />
                    </Card>

                    <Card
                        v-if="event.system.status.value === 'agreement'"
                        class="bg-muted"
                    >
                        <CardHeader
                            title="Вы отправили черновик на согласование с администрацией"
                            description="В результате согласования мероприятие будет опубликовано или возвращено на доработку"
                        />
                    </Card>

                    <Card
                        v-if="event.system.status.value === 'published'"
                        class="bg-muted"
                    >
                        <CardHeader
                            title="Мероприятие опубликовано"
                            description="В день проведения мероприятия станет доступна отчётность"
                        />
                    </Card>

                    <Card
                        v-if="event.system.status.value === 'in-reporting'"
                        class="bg-muted"
                    >
                        <CardHeader
                            title="Мероприятие проведено, доступна отчётность"
                            description="Заполните отчёт и отпраьте его на проверку"
                        />
                    </Card>

                    <Card
                        v-if="
                            event.system.status.value === 'in-report-revision'
                        "
                        class="bg-muted"
                    >
                        <CardHeader
                            title="Отчёт не был принят, получены правки"
                            description="Внесите необходимые правки и отправьте отчёт на повторную проверку"
                        />

                        <CardComment
                            v-if="!!event.system.reject_comment"
                            class="mt-2"
                            :comment="event.system.reject_comment"
                        />
                    </Card>

                    <Card
                        v-if="
                            event.system.status.value === 'in-report-agreement'
                        "
                        class="bg-muted"
                    >
                        <CardHeader
                            title="Вы отправили отчёт на проверку"
                            description="Ожидайте, скоро отчёт будет проверен"
                        />
                    </Card>

                    <Card
                        v-if="
                            event.system.status.value === 'in-report-published'
                        "
                        class="bg-muted"
                    >
                        <CardHeader
                            title="Отчёт принят, поздравляем с успешным проведением мероприятия"
                            description="После следующей ежеквартальной отчётности, мероприятие будет перенесено в архив"
                        />
                    </Card>

                    <!--                        <Card>-->
                    <!--                            <CardHeader-->
                    <!--                                title="Соорганизаторы мероприятия"-->
                    <!--                                description="Редактирование списка соорганизаторов доступно только до согласования"-->
                    <!--                            />-->

                    <!--                            <div class="mt-2 grid grid-cols-2 gap-2">-->
                    <!--                                <UserBlock-->
                    <!--                                    :user="event.creator!"-->
                    <!--                                    role="Создатель"-->
                    <!--                                />-->
                    <!--                                <UserBlock-->
                    <!--                                    v-for="coauthor in event.coauthors"-->
                    <!--                                    :key="`coauthor-${coauthor.id}`"-->
                    <!--                                    :user="coauthor.user!"-->
                    <!--                                    :role="coauthor.roles.join(', ')"-->
                    <!--                                />-->

                    <!--                                <AddCoauthorModal :event_id="event.id">-->
                    <!--                                    <template #trigger>-->
                    <!--                                        <AddUserBlock />-->
                    <!--                                    </template>-->
                    <!--                                </AddCoauthorModal>-->
                    <!--                            </div>-->
                    <!--                        </Card>-->

                    <Card
                        v-if="
                            event.system.status.value === 'draft' ||
                            event.system.status.value === 'revision'
                        "
                    >
                        <CardHeader
                            title="Для публикации мероприятия пройдите согласование"
                            description="Учтите, что редактирование информации и списка соорганизаторов не будет доступно после согласования"
                        />

                        <div
                            class="mt-2 flex flex-row items-center justify-between"
                        >
                            <Link as-child :href="edit(event.id)">
                                <Button variant="secondary"
                                    >Редактировать</Button
                                >
                            </Link>

                            <SendToAgreementModal :event="event">
                                <template #trigger>
                                    <Button variant="default"
                                        >Отправить на согласование</Button
                                    >
                                </template>
                            </SendToAgreementModal>
                        </div>
                    </Card>
                    <Card
                        v-if="
                            event.system.status.value === 'in-reporting' ||
                            event.system.status.value === 'in-report-revision'
                        "
                    >
                        <CardHeader
                            title="Отправьте отчёт на проверку администрацией"
                            description="Убедитесь, что всё заполнили правильно"
                        />

                        <div
                            class="mt-2 flex flex-row items-center justify-end"
                        >
                            <SendToReportAgreementModal :event="event">
                                <template #trigger>
                                    <Button variant="default"
                                        >Отправить на проверку</Button
                                    >
                                </template>
                            </SendToReportAgreementModal>
                        </div>
                    </Card>

                    <Card
                        v-if="
                            canF('events.moderate') &&
                            event.system.status.value === 'agreement'
                        "
                    >
                        <CardHeader
                            title="Заявка на согласование мероприятия"
                            description="Проверьте информацию о мероприятии и примите решение по заявке"
                        />

                        <div
                            class="mt-2 flex flex-row items-center justify-end gap-2"
                        >
                            <RejectAgreementModal :event="event">
                                <template #trigger>
                                    <Button variant="destructive">
                                        На доработку
                                    </Button>
                                </template>
                            </RejectAgreementModal>

                            <ResolveAgreementModal :event="event">
                                <template #trigger>
                                    <Button variant="default">
                                        Согласовать
                                    </Button>
                                </template>
                            </ResolveAgreementModal>
                        </div>
                    </Card>

                    <Card
                        v-if="
                            canF('events.moderate') &&
                            event.system.status.value === 'in-report-agreement'
                        "
                    >
                        <CardHeader
                            title="Заявка на проверку отчёта"
                            description="Проверьте предоставленные материалы и примите решение по отчёту"
                        />

                        <div
                            class="mt-2 flex flex-row items-center justify-end gap-2"
                        >
                            <RejectReportAgreementModal :event="event">
                                <template #trigger>
                                    <Button
                                        variant="destructive"
                                    >
                                        На доработку
                                    </Button>
                                </template>
                            </RejectReportAgreementModal>

                            <ResolveReportAgreementModal :event="event">
                                <template #trigger>
                                    <Button variant="default">
                                        Принять отчёт
                                    </Button>
                                </template>
                            </ResolveReportAgreementModal>
                        </div>
                    </Card>
                </div>
            </div>

            <div
                class="flex w-1/4 flex-col gap-1"
                v-if="event.announcement.enabled"
            >
                <Card class="flex flex-col gap-2 !p-2">
                    <Card class="flex flex-col gap-4 !p-4">
                        <div class="flex flex-row items-center gap-4">
                            <img
                                v-if="
                                    !!event.announcement.image_file?.public_link
                                "
                                :src="
                                    event.announcement.image_file?.public_link
                                "
                                :alt="event.main.name"
                                class="aspect-square w-[48px] rounded-lg"
                            />

                            <div class="flex flex-col gap-1.5">
                                <span
                                    class="text-base leading-none font-semibold text-foreground"
                                    >Страница в афише</span
                                >

                                <span
                                    v-if="
                                        event.system.status.sys_name ===
                                        'PUBLISHED'
                                    "
                                    class="text-sm leading-none font-semibold text-success"
                                    >Опубликована</span
                                >
                                <span
                                    v-else
                                    class="text-sm leading-none font-semibold text-muted-foreground"
                                    >Не опубликована</span
                                >
                            </div>
                        </div>

                        <div
                            v-if="
                                !(
                                    event.system.status.sys_name === 'DRAFT' ||
                                    event.system.status.sys_name ===
                                        'AGREEMENT' ||
                                    event.system.status.sys_name === 'REVISION'
                                )
                            "
                            class="flex w-full flex-row gap-2"
                        >
                            <Button
                                :as="Link"
                                :href="showAnnouncement(event.id)"
                                variant="outline"
                                class="flex-1"
                            >
                                Открыть страницу
                            </Button>

                            <Button
                                variant="outline"
                                class=""
                                v-clipboard:copy="
                                    'https://mp.nngasu.ru' +
                                    showAnnouncement(event.id, {}).url
                                "
                            >
                                <Copy class="h-4 w-4" />
                            </Button>
                        </div>
                    </Card>
                    <Card class="flex flex-col gap-4 !p-4">
                        <div class="flex flex-col gap-1.5">
                            <span
                                class="text-base leading-none font-semibold text-foreground"
                                >Регистрация</span
                            >
                            <span
                                v-if="
                                    event.system.status.sys_name === 'PUBLISHED'
                                "
                                class="text-sm leading-none font-semibold text-success"
                                >Открыта до
                                {{
                                    new Date(
                                        event.registration.end_date!,
                                    ).toLocaleDateString('ru-RU', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric',
                                    })
                                }}</span
                            >
                            <span
                                v-else
                                class="text-sm leading-none font-semibold text-muted-foreground"
                                >Не опубликована</span
                            >
                        </div>

                        <div
                            v-if="
                                !(
                                    event.system.status.sys_name === 'DRAFT' ||
                                    event.system.status.sys_name ===
                                        'AGREEMENT' ||
                                    event.system.status.sys_name === 'REVISION'
                                )
                            "
                            class="flex flex-col gap-2"
                        >
                            <div
                                class="flex flex-row items-center justify-between gap-2"
                            >
                                <span
                                    class="text-sm leading-none font-semibold text-muted-foreground"
                                    >{{ event.members_count }}/{{
                                        event.registration.members_count ?? '∞'
                                    }}</span
                                >
                                <span
                                    v-if="
                                        event.registration.enabled &&
                                        (event.registration.members_count ??
                                            0) > 0
                                    "
                                    class="text-sm leading-none font-semibold text-muted-foreground"
                                >
                                    {{
                                        (event.members_count /
                                            (event.registration.members_count ??
                                                0)) *
                                        100
                                    }}%
                                </span>
                            </div>

                            <Progress
                                v-if="
                                    event.registration.enabled &&
                                    (event.registration.members_count ?? 0) > 0
                                "
                                :model-value="
                                    (event.members_count /
                                        (event.registration.members_count ??
                                            0)) *
                                    100
                                "
                            />
                        </div>
                    </Card>
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

    .mt-2.flex-row {
        flex-wrap: wrap;
        gap: 8px;
    }
}

@media (max-width: 767px) {
    .mt-2.flex-row {
        flex-direction: column-reverse;
        align-items: stretch;
    }

    .mt-2.flex-row :deep(button) {
        width: 100%;
    }
}
</style>
