<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { approve, deny } from '@/routes/passport/device/authorizations';

type Client = { id: string; name: string };

defineProps<{
    client: Client;
    authToken: string;
    request: any;
}>();
</script>

<template>
    <Head title="Авторизация устройства" />

    <div class="flex w-full flex-col items-center gap-2 p-4">
        <span class="text-sm leading-none font-semibold"
            >Клиент: "{{ client.name }}"</span
        >
        <span class="text-sm leading-none font-semibold"
            >запрашивает доступ к вашему аккаунту</span
        >

        <div class="flex w-full flex-col items-center gap-2 md:flex-row">
            <form :action="approve().url" method="post" class="w-full md:w-1/2">
                <input hidden name="_token" :value="usePage().props.csrf" />
                <input hidden name="client_id" :value="client.id" />
                <input hidden name="auth_token" :value="authToken" />
                <input hidden name="state" :value="request" />
                <Button type="submit" variant="default" class="w-full"
                    >Предоставить</Button
                >
            </form>

            <form :action="deny().url" method="post" class="w-full md:w-1/2">
                <input hidden name="_token" :value="usePage().props.csrf" />
                <input hidden name="_method" value="DELETE"/>
                <input hidden name="client_id" :value="client.id" />
                <input hidden name="auth_token" :value="authToken" />
                <input hidden name="state" :value="request" />
                <Button type="submit" variant="destructive" class="w-full"
                    >Отклонить</Button
                >
            </form>
        </div>
    </div>
</template>

<style scoped></style>
