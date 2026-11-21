<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PageContent from '@/components/appLayoutV2/PageContent.vue';
import PageHeader from '@/components/appLayoutV2/PageHeader.vue';
import PageHeaderTop from '@/components/appLayoutV2/PageHeaderTop.vue';
import Pagination from '@/components/pagination/Pagination.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableFooter,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayoutV2 from '@/layouts/AppLayoutV2.vue';
import type { JsonResource } from '@/types';
import type { EventShortResource } from '@/types/models/event';

type Activity = {
    id: number;
    event_id: number;
    event: EventShortResource;
    role?: string;
    modification: number;
};

type ActivityCollection = JsonResource<Activity> & {
    total_points: number
}

defineProps<{activity: ActivityCollection}>();
</script>

<template>
    <Head title="Моя активность" />

    <AppLayoutV2>
        <template #header>
            <PageHeader>
                <template #top-header>
                    <PageHeaderTop title="Моя активность" />
                </template>
            </PageHeader>
        </template>

        <PageContent>
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="flex-5">Мероприятие</TableHead>
                        <TableHead class="flex-1">Роль</TableHead>
                        <TableHead class="flex-1">Баллы</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableRow v-for="activityItem in activity.data" :key="activityItem.id">
                        <TableCell class="flex-5">{{ activityItem.event.name }}</TableCell>
                        <TableCell class="flex-1">{{ activityItem.role ?? '-'}}</TableCell>
                        <TableCell class="flex-1">{{ activityItem.modification }}</TableCell>
                    </TableRow>
                </TableBody>

                <TableFooter>
                    <TableRow>
                        <TableCell colspan="2" class="flex-5"
                            >Общий балл</TableCell
                        >
                        <TableCell class="flex-1">{{ activity.total_points }}</TableCell>
                    </TableRow>
                </TableFooter>
            </Table>

            <Pagination class="mt-4" v-if="activity.meta" :meta="activity.meta"/>
        </PageContent>
    </AppLayoutV2>
</template>

<style scoped>
@media (max-width: 767px) {
    th,
    td {
        height: auto;
        padding: 12px;
        font-size: 13px;
        line-height: 18px;
        white-space: normal;
        overflow-wrap: anywhere;
    }
}
</style>
