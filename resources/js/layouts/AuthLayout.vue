<script setup lang="ts">
import RMLogo from '@/components/RMLogo.vue';
import { Button } from '@/components/ui/button';
import { nl2br } from '@/lib/nlUtils';

const { title = '', description = '' } = defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="flex min-h-svh flex-col items-center justify-center gap-6 bg-muted p-6 md:p-10"
    >
        <div
            class="w-full max-w-4xl min-h-142.5 flex flex-row rounded-2xl"
            style="
                background-image: url('/assets/images/backgroundImage.jpg');
                background-size: 150%;
                background-position-x: 100%;
                background-repeat: no-repeat;
            "
        >
            <div class="w-1/2 p-6 flex flex-row items-end justify-center">
                <RMLogo/>
            </div>

            <div class="w-1/2 rounded-2xl bg-white flex flex-col justify-center items-center py-24">
                <div class="w-full flex flex-col items-center justify-center py-6 gap-1,5">
                    <span class="font-raleway font-bold text-2xl text-center text-foreground">{{ title }}</span>
                    <span class="font-raleway font-medium text-sm text-center text-muted-foreground" v-html="nl2br(description)"/>
                </div>
                <slot/>
                <div class="w-full flex flex-col items-center justify-center py-6 gap-1,5">
                    <span class="font-raleway font-medium text-xs text-center text-muted-foreground">
                        Возникли вопросы? Обратитесь в <Button variant="link" size="sm" class="px-0 py-0 m-0 h-min font-raleway font-medium text-xs">поддержку</Button><br/>
                        или напишите на <Button as="a" variant="link" size="sm" href="mailto:molodezh@nngasu.ru" class="px-0 py-0 m-0 h-min font-raleway font-medium text-xs">molodezh@nngasu.ru</Button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@media (max-width: 767px) {
    .max-w-4xl {
        flex-direction: column-reverse;
        min-height: 0;
    }

    .max-w-4xl > div {
        width: 100%;
    }

    .max-w-4xl > div:last-child {
        padding-top: 32px;
        padding-bottom: 32px;
    }
}
</style>
