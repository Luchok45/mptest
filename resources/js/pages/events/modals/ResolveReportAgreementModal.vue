<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { toReportPublished } from '@/routes/events';
import type { EventFullResource } from '@/types/models/event';

const props = defineProps<{ event: EventFullResource }>();

const open = ref<boolean>(false);

const form = useForm({});

function handleSubmit() {
    form.patch(toReportPublished(props.event.id).url, {
        onSuccess: () => {
            form.reset();
            open.value = false;
        },
    });
}
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <slot name="trigger" />
        </DialogTrigger>

        <DialogContent>
            <DialogHeader>
                <DialogTitle>Принять отчёт?</DialogTitle>
                <DialogDescription>
                    После принятия отчёта мероприятие перейдёт в статус
                    "Отчёт принят" и будет считаться завершённым
                </DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <div class="flex w-full flex-row gap-2">
                    <DialogClose as-child>
                        <Button
                            :disabled="form.processing"
                            variant="secondary"
                            class="flex-1"
                            >Отмена</Button
                        >
                    </DialogClose>

                    <Button
                        :disabled="form.processing"
                        variant="default"
                        class="flex-1"
                        @click="handleSubmit"
                        >Принять отчёт</Button
                    >
                </div>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
