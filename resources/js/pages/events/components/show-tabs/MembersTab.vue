<script setup lang="ts">
import { Users, Trash } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableEmpty,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { TabsContent } from '@/components/ui/tabs';
import CardHeader from '@/pages/events/components/CardHeader.vue';
import AddMemberModal from '@/pages/events/modals/AddMemberModal.vue';
import DeleteMemberModal from '@/pages/events/modals/DeleteMemberModal.vue';
import type { EventFullResource } from '@/types/models/event';
import AddWinnerModal from '@/pages/events/modals/AddWinnerModal.vue';
import DeleteWinnerModal from '@/pages/events/modals/DeleteWinnerModal.vue';

defineProps<{ event: EventFullResource }>();
</script>

<template>
    <TabsContent value="members">
        <div class="flex flex-col gap-6">
            <div class="flex flex-row items-start justify-between">
                <CardHeader
                    title="Участники мероприятия"
                    description="Студенты прошедшие регистрацию"
                />

                <AddMemberModal
                    v-if="event.system.status.value === 'published'"
                    :event_id="event.id"
                >
                    <template #trigger>
                        <Button variant="secondary">Добавить участника</Button>
                    </template>
                </AddMemberModal>
            </div>

            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-full">Участник</TableHead>
                        <TableHead class="w-full">Регистрация</TableHead>
                        <TableHead
                            v-if="event.system.status.value === 'published'"
                            class="w-fit"
                        ></TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableEmpty
                        v-if="
                            (event.members?.length ?? 0) <= 0
                        "
                        :colspan="event.system.status.value === 'published' ? 3 : 2"
                    >
                        <div
                            class="flex flex-col items-center justify-center gap-2"
                        >
                            <Users class="h-9 w-9 text-muted-foreground" />
                            <span
                                class="text-sm font-semibold text-muted-foreground"
                            >
                                Здесь пока никого нет
                            </span>
                            <span
                                class="text-sm font-medium text-muted-foreground"
                            >
                                Ожидайте регистрации участников
                            </span>
                        </div>
                    </TableEmpty>
                    <TableRow
                        v-for="member in event.members"
                        :key="`member-${member.id}`"
                    >
                        <TableCell class="w-full">{{
                            member.user!.full_name
                        }}</TableCell>
                        <TableCell class="w-full">{{
                            new Date(member.created_at).toLocaleDateString(
                                'ru-RU',
                                {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                },
                            )
                        }}</TableCell>
                        <TableCell
                            v-if="event.system.status.value === 'published'"
                            class="flex w-fit flex-row justify-end gap-1"
                        >
                            <DeleteMemberModal :member="member">
                                <template #trigger>
                                    <Button variant="ghost">
                                        <Trash />
                                    </Button>
                                </template>
                            </DeleteMemberModal>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>

            <div class="flex flex-row items-start justify-between">
                <CardHeader
                    title="Призёры мероприятия"
                    description="Награждённые участники"
                />

                <AddWinnerModal
                    v-if="event.system.status.value === 'published'"
                    :event_id="event.id"
                >
                    <template #trigger>
                        <Button variant="secondary">Добавить призёра</Button>
                    </template>
                </AddWinnerModal>
            </div>

            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-full">Участник</TableHead>
                        <TableHead class="w-full">Наименование награды</TableHead>
                        <TableHead
                            v-if="event.system.status.value === 'published'"
                            class="w-fit"
                        ></TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableEmpty
                        v-if="
                            (event.winners?.length ?? 0) <= 0
                        "
                        :colspan="event.system.status.value === 'published' ? 3 : 2"
                    >
                        <div
                            class="flex flex-col items-center justify-center gap-2"
                        >
                            <Users class="h-9 w-9 text-muted-foreground" />
                            <span
                                class="text-sm font-semibold text-muted-foreground"
                            >
                                Здесь пока никого нет
                            </span>
                            <span
                                class="text-sm font-medium text-muted-foreground"
                            >
                                Вы пока не добавили призёров из списка участников
                            </span>
                        </div>
                    </TableEmpty>
                    <TableRow
                        v-for="winner in event.winners"
                        :key="`winner-${winner.id}`"
                    >
                        <TableCell class="w-full">{{ winner.member?.user?.full_name }}</TableCell>
                        <TableCell class="w-full">{{ winner.reward_type }}</TableCell>
                        <TableCell
                            v-if="event.system.status.value === 'published'"
                            class="flex w-fit flex-row justify-end gap-1"
                        >
                            <DeleteWinnerModal :member="winner.member">
                                <template #trigger>
                                    <Button variant="ghost">
                                        <Trash />
                                    </Button>
                                </template>
                            </DeleteWinnerModal>
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
