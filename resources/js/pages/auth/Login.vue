<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
// import InputError from '@/components/InputError.vue';
// import PasswordInput from '@/components/PasswordInput.vue';
// import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
// import { Checkbox } from '@/components/ui/checkbox';
// import { Input } from '@/components/ui/input';
// import { Label } from '@/components/ui/label';
// import { Spinner } from '@/components/ui/spinner';
// import { register } from '@/routes';
// import { store } from '@/routes/login';
// import { request } from '@/routes/password';
import { redirect as prometheusRedirect } from '@/routes/oauth/prometheus';

defineOptions({
    layout: {
        title: 'Авторизация',
        description: 'Войдите через Личный Кабинет ННГАСУ',
    },
});

defineProps<{
    status?: string;
}>();
</script>

<template>
    <Head title="Авторизация" />

    <div
        v-if="status"
        class="mb-4 text-center text-sm font-medium text-green-600"
    >
        {{ status }}
    </div>

    <div class="w-full flex flex-col px-6">
<!--        <a :href="prometheusRedirect().url">-->
<!--<form :action="prometheusRedirect().url" method="GET">-->
<!--    <Button type="submit">Войти через ЛК ННГАСУ</Button>-->
<!--</form>-->
            <Button as="a" :href="prometheusRedirect().url">Войти через ЛК ННГАСУ</Button>
<!--        </a>-->
    </div>
</template>
