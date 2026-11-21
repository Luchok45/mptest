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
import { destroyWinner } from '@/routes/events';
import type { EventMemberResource } from '@/types/models/event/member';

const props = defineProps<{ member: EventMemberResource }>();

const open = ref<boolean>(false);

const form = useForm({});

function handleSubmit() {
    form.delete(
        destroyWinner({
            event: props.member.event_id,
            member: props.member.id,
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
                <DialogTitle>Удаление призёра</DialogTitle>
                <DialogDescription>
                    Вы действительно хотите удалить призёра "{{
                        member.user?.full_name
                    }}"?
                </DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <Button
                    :disabled="form.processing"
                    variant="destructive"
                    class="w-full"
                    @click="handleSubmit"
                    >Удалить призёра</Button
                >
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
