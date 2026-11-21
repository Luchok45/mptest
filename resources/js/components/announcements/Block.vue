<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { show } from '@/routes/announcements';
import type { EventFullResource } from '@/types/models/event';

const props = defineProps<{
    date: string;
    elements: EventFullResource[];
}>();

const date = computed<Date>(() => new Date(props.date));
const isToday = computed<boolean>(() => {
    const today = new Date();

    return (
        date.value.getDate() === today.getDate() &&
        date.value.getMonth() === today.getMonth() &&
        date.value.getFullYear() === today.getFullYear()
    );
});
const isCurrentYear = computed<boolean>(() => {
    const today = new Date();

    return date.value.getFullYear() === today.getFullYear();
});

const datePreview = computed<string>(() => {
    return date.value.toLocaleString(
        'ru-RU',
        isCurrentYear.value
            ? {
                  day: '2-digit',
                  month: 'long',
              }
            : {
                  day: '2-digit',
                  month: 'long',
                  year: 'numeric',
              },
    );
});

const weakdayPreview = computed<string>(() => {
    return isToday.value
        ? 'Сегодня'
        : date.value.toLocaleDateString('ru-RU', {
            weekday: 'long',
        });
});
</script>

<template>
    <div class="flex w-full flex-col gap-4">
        <div class="flex flex-row items-center justify-start gap-1">
            <span class="text-base leading-5 font-semibold text-foreground">{{
                datePreview
            }}</span>
            <span
                class="text-base leading-5 font-semibold text-muted-foreground"
                >{{ weakdayPreview }}</span>
        </div>
        <div class="flex flex-col gap-2">
            <Link
                v-for="element in elements"
                :key="element.id"
                as-child
                :href="show(element.id)"
            >
                <div
                    class="flex flex-row gap-3 rounded-xl border bg-muted/50 p-3"
                >
                    <img
                        v-if="!!element.announcement.image_file"
                        :src="element.announcement.image_file.public_link"
                        class="aspect-square h-30 w-30 rounded-lg border object-cover object-center"
                        :alt="element.main.name"
                    />
                    <div class="flex w-full flex-col gap-1">
                        <span
                            class="font-raleway text-sm leading-none font-semibold text-muted-foreground"
                        >
                            {{ element.dates.start_time.substring(0, 5) }}
                        </span>
                        <span
                            class="font-raleway text-lg font-semibold text-foreground"
                        >
                            {{ element.main.name }}
                        </span>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</template>

<style scoped>
@media (max-width: 1023px) {
    .rounded-xl.border {
        flex-direction: row-reverse;
        justify-content: space-between;
        gap: 12px;
        padding: 16px;
        border-radius: 16px;
        background-color: var(--background);
    }

    .rounded-xl.border > img {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
        border-radius: 8px;
    }

    .rounded-xl.border > div {
        min-width: 0;
        overflow-wrap: anywhere;
    }

    .rounded-xl.border > div > span:first-child {
        font-size: 13px;
    }

    .rounded-xl.border > div > span:last-child {
        font-size: 16px;
        line-height: 22px;
    }
}
</style>
