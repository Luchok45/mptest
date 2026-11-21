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
import { destroyMember } from '@/routes/events';
import type { EventMemberResource } from '@/types/models/event/member';

const props = defineProps<{ member: EventMemberResource }>();

const open = ref<boolean>(false);

const form = useForm({});

function handleSubmit() {
    form.delete(
        destroyMember({
            event: props.member.event_id,
            user: props.member.user_id,
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
                <DialogTitle>Удаление участник</DialogTitle>
                <DialogDescription>
                    Вы действительно хотите удалить участника "{{
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
                    >Удалить участника</Button
                >
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
