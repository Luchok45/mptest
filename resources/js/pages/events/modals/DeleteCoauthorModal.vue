<script setup lang="ts">
import { CoauthorResource } from '@/types/models/event/coauthor';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { destroyCoauthor } from '@/routes/events';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';

const props = defineProps<{ coauthor: CoauthorResource }>();

const open = ref<boolean>(false);

const form = useForm({});

function handleSubmit() {
    form.delete(
        destroyCoauthor({
            event: props.coauthor.event_id,
            user: props.coauthor.user_id,
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
                <DialogTitle>Удаление организатора</DialogTitle>
                <DialogDescription>
                    Вы действительно хотите удалить пользователя "{{
                        coauthor.user?.full_name
                    }}" из списка организаторов?
                </DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <Button
                    :disabled="form.processing"
                    variant="destructive"
                    class="w-full"
                    @click="handleSubmit"
                    >Удалить организатора</Button
                >
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
