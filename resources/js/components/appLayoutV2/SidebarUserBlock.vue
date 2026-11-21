<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { edit } from '@/routes/profile';
import type { UserResource } from '@/types/models/user';

const user = computed<null | UserResource>(() => usePage().props.auth?.user);
</script>

<template>
    <Link :href="edit()" prefetch class="flex flex-row items-center gap-2 p-2">
        <img
            :src="user?.avatar ?? '/assets/images/defaultAvatar.png'"
            class="h-8 w-8 rounded-full mask-circle object-cover object-center"
            alt="Аватар пользователя"
        />

        <div class="flex flex-col gap-1">
            <span class="text-sm leading-none font-semibold text-foreground">{{
                user?.name
            }}</span>
            <span class="text-xs leading-none font-medium text-muted-foreground"
                >id:
                {{
                    !!user ? String(user.id).padStart(6, '0') : 'undefined'
                }}</span
            >
        </div>
    </Link>
</template>

<style scoped></style>
