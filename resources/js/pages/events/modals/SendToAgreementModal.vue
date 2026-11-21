<script setup lang="ts">
import { CoauthorResource } from '@/types/models/event/coauthor';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { toAgreement } from '@/routes/events';
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
import { Button } from '@/components/ui/button';
import { EventFullResource } from '@/types/models/event';

const props = defineProps<{ event: EventFullResource }>();

const open = ref<boolean>(false);

const form = useForm({});

function handleSubmit() {
    form.patch(toAgreement(props.event.id).url, {
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
                <DialogTitle
                    >Отправить мероприятия на согласование?</DialogTitle
                >
                <DialogDescription>
                    Проверьте, что информация о мероприятии заполнена корректно
                    и все соорганизаторы добавлены
                </DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <div class="w-full flex flex-row gap-2">
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
                        >Отправить</Button
                    >
                </div>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
