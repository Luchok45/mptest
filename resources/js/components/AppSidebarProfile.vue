<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { edit } from '@/routes/profile';
import type { UserResource } from '@/types/models/user';

const user = computed<null | UserResource>(() => usePage().props.auth?.user);
</script>

<template>
    <Link
        v-if="!!user"
        as="div"
        :href="edit()"
        prefetch
        class="flex flex-row items-center justify-start gap-3 p-1"
    >
        <img
            src="/assets/images/defaultAvatar.png"
            class="h-10 w-10 rounded-md group-has-data-[collapsible=icon]/sidebar-wrapper:h-7 group-has-data-[collapsible=icon]/sidebar-wrapper:w-7"
            alt="Аватар пользователя"
        />

        <div
            class="gap-0,5 flex flex-col group-has-data-[collapsible=icon]/sidebar-wrapper:hidden"
        >
            <span class="font-raleway font-sm font-semibold">
                {{ user.name }}
            </span>
            <span
                class="font-raleway font-xs font-medium text-muted-foreground"
            >
                id: {{ String(user.id).padStart(6, '0') }}
            </span>
        </div>
    </Link>
</template>

<style scoped></style>
