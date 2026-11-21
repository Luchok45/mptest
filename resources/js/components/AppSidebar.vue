<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    Ticket,
    Calendar,
    CalendarDays,
    Trophy,
    Star,
} from 'lucide-vue-next';
import AppSidebarProfile from '@/components/AppSidebarProfile.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarSeparator,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { hasAnyRolesF } from '@/plugins/privileges-plugin';
import { index as activityIndex } from '@/routes/activity';
import { index as announcementsIndex } from '@/routes/announcements';
import { index as eventsIndex, my as eventsMyIndex } from '@/routes/events';
import { index as ratingIndex } from '@/routes/rating';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    { title: 'Афиша мероприятий', icon: Ticket, href: announcementsIndex() },
    { title: 'Моя активность', icon: Star, href: activityIndex() },
];
const creatorNavItems: NavItem[] = [
    { title: 'Мои мероприятия', icon: Calendar, href: eventsMyIndex() },
    { title: 'Рейтинг студентов', icon: Trophy, href: ratingIndex() },
];
const moderatorNavItems: NavItem[] = [
    { title: 'Все мероприятия', icon: CalendarDays, href: eventsIndex() },
];
const { isCurrentUrl } = useCurrentUrl();
</script>

<template>
    <Sidebar collapsible="icon" variant="inset" class="font-raleway h-full">
        <SidebarHeader
            class="h-16 rounded-t-xl transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12"
        >
            <AppSidebarProfile />
        </SidebarHeader>

        <SidebarContent class="h-full p-2">
            <SidebarMenu class="gap-1">
                <SidebarMenuItem
                    v-for="menuItem in mainNavItems"
                    :key="menuItem.title"
                >
                    <SidebarMenuButton
                        as-child
                        :is-active="isCurrentUrl(menuItem.href)"
                    >
                        <Link
                            :href="menuItem.href"
                            prefetch
                            class="flex flex-row"
                        >
                            <component :is="menuItem.icon" />
                            <span>{{ menuItem.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>

                <template v-if="hasAnyRolesF(['creator', 'administrator'])">
                    <SidebarSeparator />

                    <SidebarMenuItem
                        v-for="menuItem in creatorNavItems"
                        :key="menuItem.title"
                    >
                        <SidebarMenuButton
                            as-child
                            :is-active="isCurrentUrl(menuItem.href)"
                        >
                            <Link
                                :href="menuItem.href"
                                prefetch
                                class="flex flex-row"
                            >
                                <component :is="menuItem.icon" />
                                <span>{{ menuItem.title }}</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </template>

                <template v-if="hasAnyRolesF(['moderator', 'administrator'])">
                    <SidebarSeparator />

                    <SidebarMenuItem
                        v-for="menuItem in moderatorNavItems"
                        :key="menuItem.title"
                    >
                        <SidebarMenuButton
                            as-child
                            :is-active="isCurrentUrl(menuItem.href)"
                        >
                            <Link
                                :href="menuItem.href"
                                prefetch
                                class="flex flex-row"
                            >
                                <component :is="menuItem.icon" />
                                <span>{{ menuItem.title }}</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </template>
            </SidebarMenu>
        </SidebarContent>
    </Sidebar>
    <slot />
</template>
