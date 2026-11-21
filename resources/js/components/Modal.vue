<script setup lang="ts">
import { useVModel } from '@vueuse/core';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

const props = defineProps<{
    open?: boolean;
    defaultOpen?: boolean;
    title?: string;
    description?: string;
}>();
const emits = defineEmits<{ (e: 'update:open', payload?: boolean): void }>();

const open = useVModel(props, 'open', emits);
</script>

<template>
    <Dialog v-model:open="open" :default-open="!!defaultOpen">
        <DialogContent>
            <DialogHeader v-if="!!title || !!description">
                <DialogTitle v-if="!!title">{{ title }}</DialogTitle>
                <DialogDescription v-if="!!description">{{ description }}</DialogDescription>
            </DialogHeader>

            <slot name="content" />

            <DialogFooter>
                <slot name="footer">
                    <DialogClose as-child>
                        <Button variant="secondary"> Отмена </Button>
                    </DialogClose>
                </slot>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
