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
import { rejectAgreement } from '@/routes/events';
import type { EventFullResource } from '@/types/models/event';
import { Input, Textarea } from '@/components/ui/input';
import FormElement from '@/components/FormElement.vue';

const props = defineProps<{ event: EventFullResource }>();

const open = ref<boolean>(false);

const form = useForm<{ reject_comment: string }>({
    reject_comment: '',
});

function handleSubmit() {
    form.patch(rejectAgreement(props.event.id).url, {
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
                <DialogTitle>Отправить на доработку</DialogTitle>
                <DialogDescription>
                    Мероприятие вернётся руководителю на доработку
                </DialogDescription>
            </DialogHeader>

            <div class="flex flex-col gap-2 px-6">
                <FormElement
                    id="reject_comment"
                    title="Комментарий"
                    :error-message="form.errors.reject_comment"
                >
                    <Textarea
                        id="reject_comment"
                        type="text"
                        name="reject_comment"
                        placeholder="Опишите причину отказа в согласовании"
                        v-model="form.reject_comment"
                        class="h-30"
                        rows="5"
                    />
                </FormElement>
            </div>

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
                        >Отправить</Button
                    >
                </div>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
