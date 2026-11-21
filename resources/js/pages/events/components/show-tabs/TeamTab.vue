<script setup lang="ts">
import { PencilLineIcon, Trash } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { TabsContent } from '@/components/ui/tabs';
import CardHeader from '@/pages/events/components/CardHeader.vue';
import AddCoauthorModal from '@/pages/events/modals/AddCoauthorModal.vue';
import DeleteCoauthorModal from '@/pages/events/modals/DeleteCoauthorModal.vue';
import type { EventFullResource } from '@/types/models/event';

defineProps<{event: EventFullResource}>();
</script>

<template>
    <TabsContent value="team">
        <div class="flex flex-col gap-6">
            <div class="flex flex-row items-start justify-between">
                <CardHeader
                    title="Команда мероприятия"
                    description="Люди, задействованные в организации мероприятия"
                />

                <AddCoauthorModal
                    v-if="
                        event.system.status.value === 'draft' ||
                        event.system.status.value === 'revision'
                    "
                    :event_id="event.id"
                >
                    <template #trigger>
                        <Button variant="secondary"
                            >Добавить соорганизатора</Button
                        >
                    </template>
                </AddCoauthorModal>
            </div>

            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-full">Организатор</TableHead>
                        <TableHead class="w-full">Роль</TableHead>
                        <TableHead
                            v-if="
                                event.system.status.value === 'draft' ||
                                event.system.status.value === 'revision'
                            "
                            class="w-fit"
                        ></TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableRow>
                        <TableCell class="w-full">{{
                            event.creator!.full_name
                        }}</TableCell>
                        <TableCell class="w-full">Создатель</TableCell>
                        <TableCell
                            v-if="
                                event.system.status.value === 'draft' ||
                                event.system.status.value === 'revision'
                            "
                            class="w-fit"
                        ></TableCell>
                    </TableRow>

                    <TableRow
                        v-for="coauthor in event.coauthors"
                        :key="`coauthor-${coauthor.id}`"
                    >
                        <TableCell class="w-full">{{
                            coauthor.user!.full_name
                        }}</TableCell>
                        <TableCell class="w-full">{{
                            coauthor.roles.join(', ')
                        }}</TableCell>
                        <TableCell
                            v-if="
                                event.system.status.value === 'draft' ||
                                event.system.status.value === 'revision'
                            "
                            class="flex w-fit flex-row justify-end gap-1"
                        >
                            <AddCoauthorModal
                                :event_id="event.id"
                                :coauthor="coauthor"
                            >
                                <template #trigger>
                                    <Button variant="ghost">
                                        <PencilLineIcon />
                                    </Button>
                                </template>
                            </AddCoauthorModal>

                            <DeleteCoauthorModal :coauthor="coauthor">
                                <template #trigger>
                                    <Button variant="ghost">
                                        <Trash />
                                    </Button>
                                </template>
                            </DeleteCoauthorModal>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </TabsContent>
</template>

<style scoped>
@media (max-width: 767px) {
    .items-start.justify-between {
        flex-direction: column;
        gap: 12px;
    }
}

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
