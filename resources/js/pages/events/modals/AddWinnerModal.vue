<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import EventMemberSearchInput from '@/components/EventMemberSearchInput.vue';
import FormElement from '@/components/FormElement.vue';
import SelectInput from '@/components/SelectInput.vue';
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

import { addWinner } from '@/routes/events';
import type { EnumElement } from '@/types';

const open = ref<boolean>(false);
const props = defineProps<{ event_id: number }>();
const rewardTypes = computed<EnumElement<string>[]>(
    () => usePage().props.reward_types as EnumElement<string>[],
);

const form = useForm<{
    member_id: null | number;
    reward_type: null | string;
}>({
    member_id: null,
    reward_type: null,
});

function handleSubmit() {
    form.patch(addWinner(props.event_id).url, {
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
                <DialogTitle>Добавить призёра</DialogTitle>
                <DialogDescription>
                    Выберите призёра из списка учатников
                </DialogDescription>
            </DialogHeader>

            <div class="flex flex-col gap-4 px-6">
                <FormElement
                    id="member_id"
                    title="Призёр"
                    :error-message="form.errors.member_id"
                >
                    <EventMemberSearchInput
                        id="member_id"
                        name="member_id"
                        :event_id="event_id"
                        v-model="form.member_id"
                        :tabindex="1"
                    />
                </FormElement>

                <FormElement
                    id="reward_type"
                    title="Наименование награды"
                    :error-message="form.errors.reward_type"
                >
                    <SelectInput
                        id="reward_type"
                        name="reward_type"
                        v-model="form.reward_type"
                        :items="
                            rewardTypes.map((e) => {
                                return {
                                    value: e.value,
                                    title: e.display_name,
                                };
                            })
                        "
                        :tabindex="2"
                    />
                </FormElement>
            </div>

            <DialogFooter>
                <Button
                    :disabled="form.processing"
                    variant="default"
                    class="w-full"
                    @click="handleSubmit"
                    >Добавить участника</Button
                >
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
