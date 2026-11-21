<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { authorize } from '@/routes/passport/device/authorizations';
</script>

<template>
    <Head title="Ввод кода автоизации"/>

    <form :action="authorize().url" class="w-full p-4 flex flex-col gap-2">
        <Input
            name="user_code"
            placeholder="Код авторизации устройства"
        />

        <Button type="submit">Подтвердить</Button>
    </form>
</template>

<style scoped></style>
