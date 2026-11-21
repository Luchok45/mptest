<script setup lang="ts">
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useVModel } from '@vueuse/core';

const props = defineProps<{
    items: {value: null|number|string, title: string}[],
    modelValue?: null|number|string,
    placeholder?: string,
}>();
const emits = defineEmits<{ (e: 'update:modelValue', payload?: null|number|string): void }>();

const vModel = useVModel(props, 'modelValue', emits);
</script>

<template>
    <Select v-model="vModel">
        <SelectTrigger class="w-full truncate">
            <SelectValue :placeholder="placeholder ?? 'Выберите'"/>
        </SelectTrigger>

        <SelectContent>
            <SelectItem
                v-for="item in items"
                :key="item.value ?? 'null'"
                :value="item.value"
            >{{item.title}}</SelectItem>
        </SelectContent>
    </Select>
</template>

<style scoped></style>
