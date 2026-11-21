<script setup lang="ts">
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
import { useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Trash } from 'lucide-vue-next';
import UserSearchInput from '@/components/UserSearchInput.vue';

import { addCoauthor } from '@/routes/events';
import { ref } from 'vue';
import type { CoauthorResource } from '@/types/models/event/coauthor';

const open = ref<boolean>(false);
const props = defineProps<{
    event_id: number,
    coauthor?: CoauthorResource,
}>();

const form = useForm<{
    user_id: null|number;
    roles: string[];
}>({
    user_id: props.coauthor?.user_id ?? null,
    roles: props.coauthor?.roles ?? ['Соорганизатор']
});


function handleSubmit() {
    form.patch(addCoauthor(props.event_id).url, {
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
                <DialogTitle>Добавить организатора</DialogTitle>
                <DialogDescription>
                    Укажите роли, которые организатор выполняет в рамках
                    мероприятия
                </DialogDescription>
            </DialogHeader>

            <div class="px-6 flex flex-col gap-4">
                <UserSearchInput v-model="form.user_id"/>

                <div class="flex flex-col gap-2">
                    <div v-for="(_, i) in form.roles" :key="`role-${i}`" class="flex flex-row gap-1">
                        <Input
                            :disabled="form.processing"
                            :id="`role-${i}`"
                            type="text"
                            v-model="form.roles[i]"
                            class="w-full"
                            placeholder="Укажите роль"/>

                        <Button v-if="i !== 0" variant="outline" @click="form.roles.splice(i, 1)">
                            <Trash/>
                        </Button>
                    </div>

                    <Button :disabled="form.processing" class="w-full" variant="outline" @click="form.roles.push('')">
                        Добавить роль
                    </Button>
                </div>
            </div>

            <DialogFooter>
                <Button :disabled="form.processing" variant="default" class="w-full" @click="handleSubmit"
                    >Добавить организатора</Button
                >
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
