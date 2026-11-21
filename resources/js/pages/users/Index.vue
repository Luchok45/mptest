<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import PageHeader from '@/components/appLayoutV2/PageHeader.vue';
import PageHeaderTop from '@/components/appLayoutV2/PageHeaderTop.vue';
import PageSplitContent from '@/components/appLayoutV2/PageSplitContent.vue';
import FilterCard from '@/components/filter/FilterCard.vue';
import FilterGroup from '@/components/filter/FilterGroup.vue';
import FilterToggle from '@/components/filter/FilterToggle.vue';
import NoContent from '@/components/NoContent.vue';
import Pagination from '@/components/pagination/Pagination.vue';
import { Input } from '@/components/ui/input';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayoutV2 from '@/layouts/AppLayoutV2.vue';
import { index } from '@/routes/users';
import { toggleRole as toggleRoleRoute } from '@/routes/users';
import type { JsonResource } from '@/types';
import type { UserResource } from '@/types/models/user';
import type { RoleResource } from '@/types/privileges';

defineProps<{
    users: JsonResource<UserResource>;
    roles: RoleResource[];
}>();

const query = computed<{
    search?: string;
    filters?: {
        role?: string;
    };
}>(() => usePage().props.query);

const searchRef = ref<null | string>(query.value.search ?? null);
const roleFilter = ref<null | string>(query.value.filters?.role ?? null);

function onSearch(e) {
    searchRef.value = e.target.value ?? null;
    reloadData();
}

function toggleRoleFilter(role: string) {
    if (roleFilter.value === role) {
        roleFilter.value = null;
    } else {
        roleFilter.value = role;
    }

    reloadData();
}

function toggleRole(userId: number, roleId: number) {
    router.patch(toggleRoleRoute({ user: userId, role: roleId }));
}

function reloadData() {
    let reloadData = {};

    if (!!searchRef.value) {
        reloadData = Object.assign({}, reloadData, {
            search: searchRef.value,
        });
    }

    if (!!roleFilter.value) {
        reloadData = Object.assign({}, reloadData, {
            'filters[role]': roleFilter.value,
        });
    }

    router.visit(index().url + '?' + new URLSearchParams(reloadData));
}
</script>

<template>
    <AppLayoutV2>
        <template #header>
            <PageHeader>
                <template #top-header>
                    <PageHeaderTop title="Пользователи" />
                </template>
            </PageHeader>
        </template>

        <PageSplitContent>
            <template #left>
                <div class="flex flex-col gap-3">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-8">ID</TableHead>
                                <TableHead>Пользователь</TableHead>
                                <TableHead class="w-80">Роли</TableHead>
                            </TableRow>
                        </TableHeader>

                        <TableBody>
                            <template v-if="users.data.length > 0">
                                <TableRow
                                    v-for="user in users.data"
                                    :key="user.id"
                                >
                                    <TableCell class="w-8">
                                        <div class="flex flex-col gap-0.5">
                                            <span
                                                class="text-sm leading-none font-semibold text-foreground"
                                                >{{
                                                    String(user.id).padStart(
                                                        6,
                                                        '0',
                                                    )
                                                }}</span
                                            >
                                            <span
                                                v-if="!!user.prometheus_id"
                                                class="text-xs leading-none font-medium text-muted-foreground"
                                                >{{
                                                    String(
                                                        user.prometheus_id,
                                                    ).padStart(6, '0')
                                                }}</span
                                            >
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <div
                                            class="flex flex-row items-center gap-2.5"
                                        >
                                            <img
                                                :src="user.avatar"
                                                class="h-12 w-12 rounded-full mask-circle object-cover object-center"
                                                :alt="`Аватар пользователя - '${user.full_name}'`"
                                            />
                                            <div class="flex flex-col gap-1">
                                                <span
                                                    class="text-sm leading-none font-semibold text-foreground"
                                                    >{{ user.full_name }}</span
                                                >
                                                <span
                                                    class="text-xs leading-none font-medium text-muted-foreground"
                                                    >{{ user.email }}</span
                                                >
                                                <span
                                                    class="text-xs leading-none font-medium text-muted-foreground"
                                                    >{{ user.phone }}</span
                                                >
                                            </div>
                                        </div>
                                    </TableCell>
                                    <TableCell class="w-80">
                                        <div
                                            class="flex flex-row flex-wrap gap-1"
                                        >
                                            <FilterToggle
                                                v-for="role in roles"
                                                :key="`${user.id}-${role.id}`"
                                                :title="role.name"
                                                :active="
                                                    !!user.roles?.find(
                                                        (r) => r.id === role.id,
                                                    )
                                                "
                                                @click="
                                                    toggleRole(user.id, role.id)
                                                "
                                            />
                                        </div>
                                    </TableCell>
                                </TableRow>
                            </template>

                            <template v-else>
                                <TableRow>
                                    <TableCell colspan="3">
                                        <NoContent
                                            label="Пользователи не найдены"
                                            description="Попробуйте изменить параметры поиска или настройки фильтрации"
                                        />
                                    </TableCell>
                                </TableRow>
                            </template>
                        </TableBody>
                    </Table>

                    <Pagination :meta="users.meta!" />
                </div>
            </template>

            <template #right>
                <div class="flex flex-col gap-4">
                    <Input
                        id="search"
                        name="search"
                        type="text"
                        placeholder="Поиск"
                        class="w-full"
                        :model-value="searchRef"
                        @change="onSearch"
                    />

                    <FilterCard>
                        <FilterGroup title="Роль">
                            <FilterToggle
                                v-for="role in roles"
                                :key="`filter-by-role-${role.name}`"
                                :title="role.name"
                                @click="() => toggleRoleFilter(role.name)"
                                :active="roleFilter === role.name"
                            />
                        </FilterGroup>
                    </FilterCard>
                </div>
            </template>
        </PageSplitContent>
    </AppLayoutV2>
</template>

<style scoped>
@media (max-width: 1023px) {
    td {
        white-space: normal;
    }
}

@media (max-width: 767px) {
    [data-slot="table-container"] :deep(table) {
        display: block;
    }

    thead {
        display: none;
    }

    tbody {
        display: block;
    }

    tbody > tr {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 12px;
    }

    tbody > tr > td {
        width: auto;
        padding: 0;
    }

    tbody > tr > td:nth-child(2) {
        order: -1;
    }

    tbody > tr > td:first-child > div {
        flex-direction: row;
        align-items: center;
        gap: 8px;
    }

    tbody > tr > td:nth-child(2) img {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
    }

    tbody > tr > td:nth-child(2) .flex-col {
        min-width: 0;
        overflow-wrap: anywhere;
    }
}
</style>
