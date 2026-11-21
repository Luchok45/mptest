<script setup lang="ts">
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import type { PreloadedFile } from '@/types/preloaded-file';

const props = defineProps<{
    preloadLink: string,
    modelValue?: PreloadedFile,
}>();

const emits = defineEmits<{
    (e: 'update:modelValue', payload?: PreloadedFile): void,
}>();

const input = ref();
const hiddenInput = ref();

const uploading = ref(false);
const errors = ref({});
const upload = (file: any) => {
    uploading.value = true;
    axios.post(props.preloadLink, { file: file }, {
        headers: { 'Content-Type': 'multipart/form-data' }
    })
        .then(response => { emits('update:modelValue', Object.assign({}, response.data)); })
        .catch(err => { errors.value = err.response.data; })
        .finally(() => { uploading.value = false; });
}
</script>

<template>
    <div class="flex flex-col w-full" :class="$attrs.class">
        <div class="flex flex-row w-full">
            <input
                type="file"
                hidden
                ref="hiddenInput"
                @change="upload($event?.target?.files[0])"
            />

            <Button :disabled="uploading" variant="secondary" class="b-text b-secondary whitespace-nowrap rounded-l-xl rounded-r-none" @click="hiddenInput.click()">
                <template v-if="!uploading">
                    Загрузить файл
                </template>

                <template v-else>
                    Загрузка...
                </template>
            </Button>

            <input
                :id="$attrs.id"
                type="text"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-none shadow-sm disabled w-full disabled"
                :class="{'rounded-r-xl': modelValue === null}"
                disabled
                :value="modelValue?.original?.filename ?? null"
                :placeholder="$attrs.placeholder"
                ref="input"
            />

            <Button v-if="modelValue !== null" variant="destructive" class="rounded-l-none" @click="$emit('update:modelValue', null)">
                Удалить
            </Button>
        </div>
    </div>
</template>
