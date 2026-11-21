<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import SelectInput from '@/components/SelectInput.vue';
import { Button } from '@/components/ui/button';
import type { JsonResourceMeta } from '@/types';

const perPageVariants: number[] = [5, 10, 15, 25, 50, 100, 200];

defineProps<{
    meta: JsonResourceMeta;
}>();

function updatePerPage(perPage: undefined|null|number|string) {
    router.reload({
        data: {
            page: 1,
            per_page: perPage ?? null,
        }
    });
}

function updateWithPage(page: undefined|null|number) {
    router.reload({
        data: {
            page: page,
        }
    });
}
</script>

<template>
    <div class="flex flex-row items-center justify-between">
        <div class="flex flex-row items-center gap-2">
            <span class="text-sm leading-6 font-semibold text-foreground"
                >Строк</span
            >
            <SelectInput
                :model-value="meta.per_page"
                :items="
                    perPageVariants.map((i) => {
                        return { value: i, title: String(i) };
                    })
                "
                @update:model-value="updatePerPage"
            />
        </div>

        <div class="flex flex-row items-center gap-8">
            <span class="text-sm leading-6 font-semibold text-foreground"
                >Страница {{ meta.current_page }} из {{ meta.last_page }}</span
            >

            <div class="flex flex-row items-center gap-2">
                <Button
                    variant="outline"
                    :disabled="meta.current_page === 1"
                    @click="updateWithPage(meta.current_page - 1)"
                    >Назад</Button
                >
                <Button
                    variant="outline"
                    :disabled="meta.current_page === meta.last_page"
                    @click="updateWithPage(meta.current_page + 1)"
                    >Вперед</Button
                >
            </div>
        </div>
    </div>
</template>

<style scoped>
@media (max-width: 767px) {
    .justify-between {
        flex-wrap: wrap;
        gap: 12px;
    }

    .gap-8 {
        flex-wrap: wrap;
        gap: 12px;
    }
}
</style>
