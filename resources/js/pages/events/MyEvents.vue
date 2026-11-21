<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Plus, Archive } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import PageContent from '@/components/appLayoutV2/PageContent.vue';
import PageHeader from '@/components/appLayoutV2/PageHeader.vue';
import PageHeaderTop from '@/components/appLayoutV2/PageHeaderTop.vue';
import FilterGroup from '@/components/filter/FilterGroup.vue';
import FilterToggle from '@/components/filter/FilterToggle.vue';
import NoContent from '@/components/NoContent.vue';
import EventCard from '@/components/pages/events/EventCard.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayoutV2 from '@/layouts/AppLayoutV2.vue';
import { create, my } from '@/routes/events';
import type { JsonResource } from '@/types/json';
import type { EventFullResource } from '@/types/models/event';

defineProps<{ events: JsonResource<EventFullResource>; search?: string }>();

const query = computed<{
    search?: string;
    filters?: {
        status?: string;
        role?: string;
        period?: string;
    };
}>(() => usePage().props.query);

const searchRef = ref<null | string>(query.value.search ?? null);
const statusFilter = ref<null | string>(query.value.filters?.status ?? null);
const roleFilter = ref<null | string>(query.value.filters?.role ?? null);
const periodFilter = ref<null | string>(query.value.filters?.period ?? null);

function onSearch(e) {
    searchRef.value = e.target.value ?? null;
    reloadData();
}

function toggleStatusFilter(status: string) {
    if (statusFilter.value === status) {
        statusFilter.value = null;
    } else {
        statusFilter.value = status;
    }

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

function togglePeriodFilter(period: string) {
    if (periodFilter.value === period) {
        periodFilter.value = null;
    } else {
        periodFilter.value = period;
    }

    reloadData();
}

function reloadData() {
    let reloadData = {};

    if (!!searchRef.value) {
        reloadData = Object.assign({}, reloadData, {
            'search': searchRef.value,
        });
    }

    if (!!statusFilter.value) {
        reloadData = Object.assign({}, reloadData, {
            'filters[status]': statusFilter.value,
        });
    }

    if (!!roleFilter.value) {
        reloadData = Object.assign({}, reloadData, {
            'filters[role]': roleFilter.value,
        });
    }

    if (!!periodFilter.value) {
        reloadData = Object.assign({}, reloadData, {
            'filters[period]': periodFilter.value,
        });
    }

    router.visit(my().url + '?' + new URLSearchParams(reloadData));
}
</script>

<template>
    <Head title="Мои мероприятия" />
    <AppLayoutV2>
        <template #header>
            <PageHeader>
                <template #top-header>
                    <PageHeaderTop
                        title="Мои мероприятия"
                        description="Управление мероприятиями, где вы являетесь создателем или соорганизатором"
                    >
                        <template #actions>
                            <Button
                                :as="Link"
                                :href="create()"
                                variant="default"
                            >
                                <Plus /> Создать мероприятие
                            </Button>
                        </template>
                    </PageHeaderTop>
                </template>
            </PageHeader>
        </template>

        <PageContent>
            <div class="flex flex-row gap-6">
                <div class="flex flex-1 flex-col gap-4">
                    <template v-if="events.data.length > 0">
                        <EventCard
                            v-for="event in events.data"
                            :key="event.id"
                            :item="event"
                        />
                    </template>

                    <template v-else>
                        <NoContent
                            label="Мероприятия не найдены"
                            description="Попробуйте изменить параметры поиска или настройки фильтрации"
                        />
                    </template>
                </div>

                <div class="flex w-66.5 flex-col gap-4">
                    <Input
                        id="search"
                        name="search"
                        type="text"
                        placeholder="Поиск"
                        class="w-full"
                        :model-value="search"
                        @change="onSearch"
                    />

                    <div
                        class="flex flex-col gap-4 rounded-xl border border-border p-4"
                    >
                        <FilterGroup title="Статус">
                            <FilterToggle
                                title="Требуют действий"
                                @click="() => toggleStatusFilter('need-action')"
                                :active="statusFilter === 'need-action'"
                            />
                            <FilterToggle
                                title="Опубликовано"
                                @click="() => toggleStatusFilter('published')"
                                :active="statusFilter === 'published'"
                            />
                            <FilterToggle
                                title="Черновики"
                                @click="() => toggleStatusFilter('drafts')"
                                :active="statusFilter === 'drafts'"
                            />
                            <FilterToggle
                                title="У администрации"
                                @click="
                                    () => toggleStatusFilter('on-moderation')
                                "
                                :active="statusFilter === 'on-moderation'"
                            />
                        </FilterGroup>

                        <FilterGroup title="Моя роль">
                            <FilterToggle
                                title="Создатель"
                                @click="() => toggleRoleFilter('creator')"
                                :active="roleFilter === 'creator'"
                            />
                            <FilterToggle
                                title="Соорганизатор"
                                @click="() => toggleRoleFilter('coauthor')"
                                :active="roleFilter === 'coauthor'"
                            />
                        </FilterGroup>

<!--                        <FilterGroup title="Период проведения">-->
<!--                            <FilterToggle-->
<!--                                title="Эта неделя"-->
<!--                                @click="-->
<!--                                    () => togglePeriodFilter('current-weak')-->
<!--                                "-->
<!--                                :active="periodFilter === 'current-weak'"-->
<!--                            />-->
<!--                            <FilterToggle-->
<!--                                title="Этот месяц"-->
<!--                                @click="-->
<!--                                    () => togglePeriodFilter('current-month')-->
<!--                                "-->
<!--                                :active="periodFilter === 'current-month'"-->
<!--                            />-->
<!--                            <FilterToggle-->
<!--                                title="Следующий месяц"-->
<!--                                @click="() => togglePeriodFilter('next-month')"-->
<!--                                :active="periodFilter === 'next-month'"-->
<!--                            />-->
<!--                        </FilterGroup>-->
                    </div>

                    <Button variant="outline">
                        <Archive /> Архив мероприятий
                    </Button>
                </div>
            </div>
        </PageContent>
    </AppLayoutV2>
</template>

<style scoped>
@media (max-width: 1023px) {
    .flex-row.gap-6 {
        flex-direction: column;
        gap: 16px;
    }

    .flex-row.gap-6 > div:first-child {
        min-width: 0;
        gap: 8px;
    }

    .flex-row.gap-6 > div:last-child {
        order: -1;
        width: 100%;
        gap: 12px;
    }

    .rounded-xl.border {
        padding: 12px;
    }
}
</style>
