<script setup lang="ts">
import {
    Ticket,
    Calendar,
    CalendarDays,
    Trophy,
    Star,
    Users,
} from 'lucide-vue-next';
import SidebarNavItem from '@/components/appLayoutV2/SidebarNavItem.vue';
import SidebarSection from '@/components/appLayoutV2/SidebarSection.vue';
import SidebarSeparator from '@/components/appLayoutV2/SidebarSeparator.vue';
import SidebarUserBlock from '@/components/appLayoutV2/SidebarUserBlock.vue';

import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { canAnyF, canF, hasRoleF } from '@/plugins/privileges-plugin';
import { index as activityIndex } from '@/routes/activity';
import { index as announcementsIndex } from '@/routes/announcements';
import { index as eventsIndex, my as eventsMyIndex } from '@/routes/events';
import { index as ratingIndex } from '@/routes/rating';
import { index as usersIndex } from '@/routes/users';

const { isCurrentUrl } = useCurrentUrl();
</script>

<template>
    <div
        class="flex min-h-[98svh] w-58 flex-col gap-4 rounded-l-3xl border-r border-border bg-sidebar p-3"
    >
        <SidebarUserBlock />
        <SidebarSection>
            <SidebarNavItem
                :icon="Ticket"
                title="Афиша мероприятий"
                :href="announcementsIndex()"
                :is-active="isCurrentUrl(announcementsIndex())"
            />
            <SidebarNavItem
                :icon="Star"
                title="Моя активность"
                :href="activityIndex()"
                :is-active="isCurrentUrl(activityIndex())"
            />
        </SidebarSection>
        <template v-if="canAnyF(['events.view.my', 'rating.view'])">
            <SidebarSeparator />
            <SidebarSection>
                <SidebarNavItem
                    v-if="canF('events.view.my')"
                    :icon="Calendar"
                    title="Мои мероприятия"
                    :href="eventsMyIndex()"
                    :is-active="isCurrentUrl(eventsMyIndex())"
                />
                <SidebarNavItem
                    v-if="canF('rating.view')"
                    :icon="Trophy"
                    title="Рейтинг студентов"
                    :href="ratingIndex()"
                    :is-active="isCurrentUrl(ratingIndex())"
                />
            </SidebarSection>
        </template>

        <template v-if="canAnyF(['events.view.all'])">
            <SidebarSeparator />
            <SidebarSection>
                <SidebarNavItem
                    v-if="canF('events.view.all')"
                    :icon="CalendarDays"
                    title="Все мероприятия"
                    :href="eventsIndex()"
                    :is-active="isCurrentUrl(eventsIndex())"
                />
            </SidebarSection>
        </template>

        <template v-if="hasRoleF('administrator')">
            <SidebarSeparator />
            <SidebarSection>
                <SidebarNavItem
                    v-if="canF('users.view')"
                    title="Пользователи"
                    :icon="Users"
                    :href="usersIndex()"
                    :is-active="isCurrentUrl(usersIndex())"
                />
            </SidebarSection>
        </template>
    </div>
</template>

<style scoped>
@media (max-width: 1023px) {
    .bg-sidebar {
        position: fixed;
        left: 50%;
        bottom: 12px;
        transform: translateX(-50%);
        z-index: 50;
        flex-direction: row;
        align-items: center;
        gap: 4px;
        width: max-content;
        max-width: calc(100% - 24px);
        min-height: 0;
        padding: 4px 12px;
        overflow-x: auto;
        scrollbar-width: none;
        background-color: var(--background);
        border: 1px solid var(--border);
        border-radius: 9999px;
        box-shadow: 0 4px 16px rgb(0 0 0 / 0.08);
    }

    .bg-sidebar > * {
        flex-shrink: 0;
    }

    .bg-sidebar > .flex-col {
        flex-direction: row;
        gap: 4px;
    }

    .bg-sidebar > .border {
        display: none;
    }

    .bg-sidebar .group,
    .bg-sidebar > a {
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 2px;
        width: 84px;
        min-height: 50px;
        padding: 4px;
        border-radius: 25px;
        text-align: center;
    }

    .bg-sidebar > a {
        order: 99;
    }

    .bg-sidebar .group :deep(svg) {
        width: 20px;
        height: 20px;
    }

    .bg-sidebar .group :deep(span) {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-size: 11px;
        line-height: 12px;
    }

    .bg-sidebar > a :deep(img) {
        width: 22px;
        height: 22px;
    }

    .bg-sidebar > a :deep(.flex-col) {
        display: none;
    }

    .bg-sidebar > a::after {
        content: 'Профиль';
        font-size: 11px;
        line-height: 12px;
        font-weight: 500;
        color: var(--sidebar-foreground);
    }
}

@media (max-width: 767px) {
    .bg-sidebar {
        gap: 2px;
        padding: 6px 8px;
    }

    .bg-sidebar > .flex-col {
        gap: 2px;
    }

    .bg-sidebar .group,
    .bg-sidebar > a {
        width: 44px;
        min-height: 44px;
        height: 44px;
        padding: 0;
        border-radius: 9999px;
    }

    .bg-sidebar .group :deep(span) {
        display: none;
    }

    .bg-sidebar > a::after {
        content: none;
    }

    .bg-sidebar > a :deep(img) {
        width: 26px;
        height: 26px;
    }
}
</style>
