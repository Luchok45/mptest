<script setup lang="ts">
import { EventFullResource } from '@/types/models/event';
import CardReportIndicator from '@/pages/events/components/CardReportIndicator.vue';
import { Calendar, Ticket } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { register } from '@/routes/announcements';
import { Link } from '@inertiajs/vue3';

defineProps<{
    event: EventFullResource;
    registryAvailable: boolean;
    meRegistered: boolean;
}>();
</script>

<template>
    <div
        class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-gray-100/50 p-4"
    >
        <div class="flex flex-row gap-4">
            <CardReportIndicator
                label="Даты проведения"
                :value="
                    (new Date(event.dates.start_date).toLocaleDateString('ru-RU', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric',
                    }))
                    + (!!event.dates.end_date ? ' - ' + (new Date(event.dates.end_date).toLocaleDateString('ru-RU', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric',
                    })) : '')
                "
                :icon="Calendar"
            />
            <CardReportIndicator
                v-if="event.registration.enabled && !!event.registration.end_date"
                label="Закрытие регистрации"
                :value="
                    new Date(event.registration.end_date).toLocaleDateString(
                        'ru-RU',
                        {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric',
                        },
                    ) + ' в 23:59'
                "
                :icon="Ticket"
            />
        </div>
        <div v-if="!meRegistered" class="border-b border-gray-200" />
        <div v-if="!meRegistered">
            <span
                v-if="!registryAvailable"
                class="w-full text-center text-sm leading-6 font-semibold text-muted-foreground"
                >Регистрация на мероприятие закрыта</span
            >
            <template v-else>
                <Link as-child :href="register(event.id)" class="w-full">
                    <Button variant="default" class="w-full"
                        >Стать участником мероприятия</Button
                    >
                </Link>
            </template>
        </div>
    </div>
</template>

<style scoped>
@media (max-width: 1023px) {
    .flex-row.gap-4 {
        flex-wrap: wrap;
    }
}

@media (max-width: 767px) {
    .rounded-2xl {
        gap: 12px;
        padding: 12px;
    }

    .flex-row.gap-4 {
        flex-direction: column;
        gap: 12px;
    }
}
</style>
