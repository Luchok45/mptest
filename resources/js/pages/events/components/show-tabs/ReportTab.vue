<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    ArrowUpRight,
    Copy,
    Users,
    UserPlus,
    UserCheck,
    X,
    Link as LinkIcon,
    Plus,
} from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { TabsContent } from '@/components/ui/tabs';
import Card from '@/pages/events/components/Card.vue';
import CardHeader from '@/pages/events/components/CardHeader.vue';
import SendToAgreementModal from '@/pages/events/modals/SendToAgreementModal.vue';
import { edit } from '@/routes/events';
import type { EventFullResource } from '@/types/models/event';
import RejectAgreementModal from '@/pages/events/modals/RejectAgreementModal.vue';
import ResolveAgreementModal from '@/pages/events/modals/ResolveAgreementModal.vue';
import CardComment from '@/pages/events/components/CardComment.vue';
import CardReportIndicator from '@/pages/events/components/CardReportIndicator.vue';
import AddReportLinkModal from '@/pages/events/modals/AddReportLinkModal.vue';
import DeleteReportLinkModal from '@/pages/events/modals/DeleteReportLinkModal.vue';
import SendToReportAgreementModal from '@/pages/events/modals/SendToReportAgreementModal.vue';
import RejectReportAgreementModal from '@/pages/events/modals/RejectReportAgreementModal.vue';
import ResolveReportAgreementModal from '@/pages/events/modals/ResolveReportAgreementModal.vue';
import { show as showAnnouncement } from '@/routes/announcements';

defineProps<{
    event: EventFullResource;
}>();
</script>

<template>
    <TabsContent value="report">
        <div class="flex flex-row gap-2">
            <div class="w-3/4">
                <div class="flex flex-col gap-2">
                    <Card>
                        <div
                            class="flex flex-row items-center justify-between gap-6"
                        >
                            <CardReportIndicator
                                label="Организаторы"
                                :value="`${event.coauthors_count} человек`"
                                :icon="Users"
                            />

                            <CardReportIndicator
                                label="Зарегистрировано"
                                :value="`${event.members_count} заявок`"
                                :icon="UserPlus"
                            />

                            <CardReportIndicator
                                label="Приняли участие"
                                :value="`${event.members_count} студентов`"
                                :icon="UserCheck"
                            />
                        </div>
                    </Card>

                    <Card>
                        <CardHeader
                            title="Фото и видео с мероприятия"
                            description="Добавьте ссылки материалы"
                        />

                        <div class="mt-2 grid grid-cols-2 gap-3">
                            <a
                                v-for="reportLink in event.report_links"
                                :key="`report-link-${reportLink.id}`"
                                class="flex flex-row items-center gap-2 rounded-xl border border-gray-200 p-2"
                                :href="reportLink.link"
                                target="_blank"
                            >
                                <div
                                    class="rounded-xl bg-blue-500/10 p-2 text-blue-500"
                                >
                                    <LinkIcon class="h-4 w-4" />
                                </div>

                                <span
                                    class="w-full text-sm leading-none font-semibold text-foreground"
                                >
                                    {{ reportLink.name }}
                                </span>

                                <DeleteReportLinkModal
                                    :report-link="reportLink"
                                    v-if="
                                        event.system.status.value === 'in-reporting' ||
                                        event.system.status.value ===
                                            'in-report-revision'
                                    "
                                >
                                    <template #trigger>
                                        <Button
                                            variant="ghost"
                                            @click="$event.preventDefault()"
                                        >
                                            <X class="h-4 w-4" />
                                        </Button>
                                    </template>
                                </DeleteReportLinkModal>
                            </a>

                            <AddReportLinkModal
                                :event_id="event.id"
                                v-if="
                                    event.system.status.value === 'in-reporting' ||
                                    event.system.status.value === 'in-report-revision'
                                "
                            >
                                <template #trigger>
                                    <div
                                        class="flex cursor-pointer flex-row items-center justify-center gap-2 rounded-xl border border-dashed border-gray-200 p-2"
                                    >
                                        <Plus
                                            class="h-4 w-4 text-muted-foreground"
                                        />
                                        <span
                                            class="text-sm leading-6 font-semibold text-muted-foreground"
                                        >
                                            Добавить ссылку
                                        </span>
                                    </div>
                                </template>
                            </AddReportLinkModal>
                        </div>
                    </Card>

<!--                    <Card-->
<!--                        v-if="-->
<!--                            event.system.status.value === 'in-reporting' ||-->
<!--                            event.system.status.value === 'in-report-revision'-->
<!--                        "-->
<!--                    >-->
<!--                        <div-->
<!--                            class="mt-2 flex flex-row items-center justify-between"-->
<!--                        >-->
<!--                            <CardHeader-->
<!--                                title="Отправьте отчёт на проверку администрацией"-->
<!--                                description="Проверка отчёта займёт до 3-х рабочих дней"-->
<!--                            />-->

<!--                            <SendToReportAgreementModal :event="event">-->
<!--                                <template #trigger>-->
<!--                                    <Button variant="default"-->
<!--                                        >Отправить на проверку</Button-->
<!--                                    >-->
<!--                                </template>-->
<!--                            </SendToReportAgreementModal>-->
<!--                        </div>-->
<!--                    </Card>-->
                </div>
            </div>

            <div class="flex w-1/4 flex-col gap-1">
                    <Button :as="Link" :href="showAnnouncement(event.id)" variant="outline">
                        <ArrowUpRight class="h-4 w-4" /> Страница мероприятия
                    </Button>

                <Button
                    variant="outline"
                    v-clipboard:copy="
                        'https://mp.nngasu.ru' + showAnnouncement(event.id, {}).url
                    "
                >
                    <Copy class="h-4 w-4" /> Скопировать ссылку
                </Button>
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
    }

    [data-slot="tabs-content"] > .flex-row > div:last-child {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 8px;
    }

    [data-slot="tabs-content"] > .flex-row > div:last-child > * {
        flex: 1;
    }

    .justify-between.gap-6 {
        flex-wrap: wrap;
        gap: 16px;
    }

    .grid-cols-2 > a {
        min-width: 0;
        overflow-wrap: anywhere;
    }
}

@media (max-width: 767px) {
    [data-slot="tabs-content"] > .flex-row > div:last-child {
        flex-direction: column;
    }

    .justify-between.gap-6 {
        flex-direction: column;
        align-items: flex-start;
    }

    .grid-cols-2 {
        grid-template-columns: 1fr;
    }
}
</style>
