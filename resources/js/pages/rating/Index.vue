<script setup lang="ts">
import PageContent from '@/components/appLayoutV2/PageContent.vue';
import PageHeader from '@/components/appLayoutV2/PageHeader.vue';
import PageHeaderTop from '@/components/appLayoutV2/PageHeaderTop.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayoutV2 from '@/layouts/AppLayoutV2.vue';
import type { UserResource } from '@/types/models/user';

type RatingItem = {
    user_id: number;
    user: UserResource;
    points: number;
};

defineProps<{ rating: RatingItem[] }>();
</script>

<template>
    <AppLayoutV2>
        <template #header>
            <PageHeader>
                <template #top-header>
                    <PageHeaderTop title="Рейтинг студентов" />
                </template>
            </PageHeader>
        </template>

        <PageContent>
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="flex-1 text-center">#</TableHead>
                        <TableHead class="flex-1">ID</TableHead>
                        <TableHead class="flex-5">ФИО</TableHead>
                        <TableHead class="flex-1">Баллы</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableRow
                        v-for="(ratingItem, index) in rating"
                        :key="ratingItem.user_id"
                    >
                        <TableCell class="flex-1 text-center">{{ index+1 }}</TableCell>
                        <TableCell class="flex-1">{{ String(ratingItem.user_id).padStart(6, '0') }}</TableCell>
                        <TableCell class="flex-5">{{ ratingItem.user.full_name }}</TableCell>
                        <TableCell class="flex-1">{{ ratingItem.points }}</TableCell>
                    </TableRow>
                </TableBody>
            </Table>
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
    }
}
</style>
