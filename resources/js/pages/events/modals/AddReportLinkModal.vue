<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import FormElement from '@/components/FormElement.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';

import { addReportLink } from '@/routes/events';

const open = ref<boolean>(false);
const props = defineProps<{
    event_id: number;
}>();

const form = useForm<{
    name: string;
    link: string;
}>({
    name: '',
    link: '',
});

function handleSubmit() {
    form.patch(addReportLink(props.event_id).url, {
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
                <DialogTitle>Укажите ссылку на отчёт</DialogTitle>
                <DialogDescription>
                    Подойдут ссылки на фото- и видеоматериалы из ВКонтакте и
                    облачного хранилища
                </DialogDescription>
            </DialogHeader>

            <div class="flex flex-col gap-4 px-6">
                <FormElement
                    id="name"
                    title="Назовите ссылку"
                    :error-message="form.errors.name"
                >
                    <Input
                        id="name"
                        type="text"
                        name="name"
                        v-model="form.name"
                        placeholder="Название"
                    />
                </FormElement>

                <FormElement
                    id="link"
                    title="Ссылка"
                    :error-message="form.errors.link"
                >
                    <Input
                        id="link"
                        type="text"
                        name="link"
                        v-model="form.link"
                        placeholder="Ссылка"
                    />
                </FormElement>
            </div>

            <DialogFooter>
                <Button
                    :disabled="form.processing"
                    variant="default"
                    class="w-full"
                    @click="handleSubmit"
                    >Добавить ссылку</Button
                >
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
