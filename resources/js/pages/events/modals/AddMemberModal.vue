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
import UserSearchInput from '@/components/UserSearchInput.vue';

import { addMember } from '@/routes/events';

const open = ref<boolean>(false);
const props = defineProps<{
    event_id: number,
}>();

const form = useForm<{
    user_id: null|number;
}>({
    user_id: null,
});


function handleSubmit() {
    form.patch(addMember(props.event_id).url, {
        onSuccess: () => {
            form.reset();
            open.value = false;
        }
    })
}
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <slot name="trigger" />
        </DialogTrigger>

        <DialogContent>
            <DialogHeader>
                <DialogTitle>Добавить участника</DialogTitle>
                <DialogDescription>
                    Добавить нового участника мероприятия
                </DialogDescription>
            </DialogHeader>

            <div class="px-6 flex flex-col gap-4">
                <UserSearchInput v-model="form.user_id"/>
            </div>

            <DialogFooter>
                <Button :disabled="form.processing" variant="default" class="w-full" @click="handleSubmit"
                    >Добавить участника</Button
                >
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
