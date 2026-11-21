<script setup lang="ts">
import { DateFormatter, getLocalTimeZone, parseAbsolute } from '@internationalized/date';
import { useVModel } from '@vueuse/core';
import { CalendarIcon } from 'lucide-vue-next';
import type { DateValue } from 'reka-ui';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import {
    Popover,
    PopoverTrigger,
    PopoverContent,
} from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { HTMLAttributes } from 'vue';

const df = new DateFormatter('ru-RU', {
    dateStyle: 'short',
    timeStyle: undefined,
});

const props = defineProps<{
    modelValue?: Date,
    disabled?: HTMLAttributes['aria-disabled']
}>();
const emits = defineEmits<{ (e: 'update:modelValue', payload?: Date): void }>();

const vModel = useVModel(props, 'modelValue', emits);
</script>

<template>
    <Popover v-slot="{ close }">
        <PopoverTrigger as-child>
            <Button
                :disabled="props.disabled"
                variant="outline"
                :class="
                    cn(
                        'w-full justify-start text-left font-normal',
                        !vModel && 'text-muted-foreground',
                    )
                "
            >
                <CalendarIcon class="mr-2 h-4 w-4" />
                {{ !!vModel ? vModel.toLocaleDateString('ru-RU', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                }) : 'ДД.ММ.ГГГГ' }}
            </Button>
        </PopoverTrigger>

        <PopoverContent class="w-auto p-0">
            <Calendar
                :model-value="!!vModel ? parseAbsolute(vModel.toISOString(), getLocalTimeZone()) : undefined"
                :initial-focus="true"
                layout="month-and-year"
                locale="ru-RU"
                @update:model-value="(v: DateValue) => {
                    vModel = v.toDate(getLocalTimeZone());
                    close();
                }"
            />
        </PopoverContent>
    </Popover>
</template>

<style scoped></style>
