<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PageHeader from '@/components/appLayoutV2/PageHeader.vue';
import { Tabs, TabsList, TabsTrigger } from '@/components/ui/tabs';
import ControlsTab from '@/pages/events/components/show-tabs/ControlsTab.vue';
import TeamTab from '@/pages/events/components/show-tabs/TeamTab.vue';
import ViewTab from '@/pages/events/components/show-tabs/ViewTab.vue';
import StatusBadge from '@/pages/events/components/StatusBadge.vue';
import type { EventFullResource } from '@/types/models/event';
import MembersTab from '@/pages/events/components/show-tabs/MembersTab.vue';
import ReportTab from '@/pages/events/components/show-tabs/ReportTab.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import AppLayoutV2 from '@/layouts/AppLayoutV2.vue';
import PageHeaderTop from '@/components/appLayoutV2/PageHeaderTop.vue';
import PageHeaderInfoBar from '@/components/appLayoutV2/PageHeaderInfoBar.vue';
import EventStatusBadge from '@/components/pages/events/EventStatusBadge.vue';
import PageContent from '@/components/appLayoutV2/PageContent.vue';
import { Button } from '@/components/ui/button';

defineProps<{
    event: EventFullResource;
    canModerate: boolean;
}>();
</script>

<template>
    <Head :title="event.main.name" />

    <Tabs default-value="controls" class="w-full">
    <AppLayoutV2>
        <template #header>
            <PageHeader>
                <template #top-header>
                    <PageHeaderTop :title="event.main.name">
                        <template #info-bar>
                            <PageHeaderInfoBar>
                                <EventStatusBadge
                                    :status="event.system.status"
                                />
                                <span
                                    v-if="!!event.created_at"
                                    class="font-raleway text-sm font-semibold text-muted-foreground"
                                >
                                    Создано
                                    {{
                                        new Date(
                                            event.created_at!,
                                        ).toLocaleDateString('ru-RU', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric',

                                            hour: '2-digit',
                                            minute: '2-digit',
                                        })
                                    }}
                                </span>
                            </PageHeaderInfoBar>
                        </template>
                    </PageHeaderTop>
                </template>

                <template #bottom-header>
                    <div
                        class="flex flex-row items-end justify-between gap-3 px-6"
                    >
                        <TabsList class="w-full">
                            <TabsTrigger class="w-fit" value="controls"
                                >Управление</TabsTrigger
                            >
                            <TabsTrigger class="w-fit" value="view"
                                >Обзор</TabsTrigger
                            >
                            <TabsTrigger class="w-fit" value="team"
                                >Команда</TabsTrigger
                            >
                            <TabsTrigger
                                class="w-fit"
                                value="members"
                                :disabled="
                                    event.system.status.value === 'draft' ||
                                    event.system.status.value === 'revision' ||
                                    event.system.status.value === 'agreement'
                                "
                                >Участники</TabsTrigger
                            >
                            <TabsTrigger
                                class="w-fit"
                                value="report"
                                :disabled="
                                    event.system.status.value === 'draft' ||
                                    event.system.status.value === 'revision' ||
                                    event.system.status.value === 'agreement' ||
                                    event.system.status.value === 'published'
                                "
                                >Отчётность</TabsTrigger
                            >
                            <div class="w-full" />
                        </TabsList>

<!--                        <span class="w-fit whitespace-nowrap">Связь с администрацией</span>-->
                    </div>
                </template>
            </PageHeader>
        </template>

        <PageContent>
                <ControlsTab :event="event" :can-moderate="canModerate" />
                <ViewTab :event="event" />
                <TeamTab :event="event" />
                <MembersTab :event="event" />
                <ReportTab :event="event" />
        </PageContent>
    </AppLayoutV2>
    </Tabs>
</template>

<style scoped>
@media (max-width: 1023px) {
    .items-end.justify-between {
        padding: 0 16px;
        overflow-x: auto;
        scrollbar-width: none;
    }

    [data-slot="tabs-list"] {
        justify-content: flex-start;
        gap: 20px;
        width: max-content;
        min-width: 100%;
    }

    [data-slot="tabs-trigger"] {
        flex-shrink: 0;
        white-space: nowrap;
    }

    [data-slot="tabs-list"] > .w-full {
        display: none;
    }
}
</style>
