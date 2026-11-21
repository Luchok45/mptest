<script setup lang="ts">
import type { UserResource } from '@/types/models/user';

defineProps<{
    user: UserResource,
    role: string,
}>();
</script>

<template>
    <div
        class="flex flex-row items-center gap-2 rounded-xl border bg-container p-2"
    >
        <img
            src="/assets/images/defaultAvatar.png"
            class="h-10 w-10 rounded-full"
            alt="Аватар пользователя"
        />

        <div class="flex flex-col justify-center">
            <span class="font-raleway font-xs font-semibold">{{ user.full_name }}</span>
            <span class="font-raleway font-2xs font-medium text-muted-foreground">
                {{ role }}
            </span>
        </div>
    </div>
</template>

<style scoped></style>
