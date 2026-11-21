<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
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
import { destroyReportLink } from '@/routes/events';
import type { EventReportLinkResource } from '@/types/models/event/report-link';

const props = defineProps<{ reportLink: EventReportLinkResource }>();

const open = ref<boolean>(false);

const form = useForm({});

function handleSubmit() {
    form.delete(
        destroyReportLink({
            event: props.reportLink.event_id,
            reportLink: props.reportLink.id,
        }).url,
        {
            onSuccess: () => {
                form.reset();
                open.value = false;
            },
        },
    );
}
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <slot name="trigger" />
        </DialogTrigger>

        <DialogContent>
            <DialogHeader>
                <DialogTitle>Удаление ссылки</DialogTitle>
                <DialogDescription>
                    Вы действительно хотите удалить ссылку "{{
                        reportLink.name
                    }}"?
                </DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <Button
                    :disabled="form.processing"
                    variant="destructive"
                    class="w-full"
                    @click="handleSubmit"
                    >Удалить ссылку</Button
                >
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
