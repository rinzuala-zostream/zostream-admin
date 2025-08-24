<template>
    <Sidebar collapsible="icon" variant="floating">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('movie')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <!-- Main navigation -->
            <NavMain :items="mainNavItems" />


        </SidebarContent>

        <SidebarFooter class="border-t pt-2">
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import AppLogo from './AppLogo.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {
    Settings,
    BookOpen,
    Github,
    LayoutGrid,
    Film,
    Tv,
    Users,
    Smartphone,
    ChevronDown,
    Crown,
    Command,
Edit,
IdCard,
LayoutDashboard,
TabletSmartphone,
Flag
} from 'lucide-vue-next';
import { identity } from '@vueuse/core';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutDashboard,
        active: route().current('dashboard*')
    },
    {
        title: 'Movies',
        href: '/movie',
        icon: Film,
        active: route().current('movie*')
    },
    {
        title: 'Episodes',
        href: '/episode',
        icon: Tv,
        active: route().current('episode*')
    },
    {
        title: 'Update',
        href: '/update',
        icon: Edit,
        active: route().current('update*')
    },
    {
        title: 'Users',
        href: '/user',
        icon: Users,
        active: route().current('user*')
    },
    {
        title: 'Devices',
        href: '/device',
        icon: Smartphone,
        active: route().current('device*')
    },
    {
        title: 'Subscription',
        href: '/subscribe',
        icon: Crown,
        active: route().current('subscribe*')
    },
    {
        title: 'Season ID',
        href: '/season',
        icon: IdCard,
        active: route().current('season*')
    },
    {
        title: 'Report',
        href: '/report',
        icon: Command,
        active: route().current('report*')
    },
    {
        title: 'Advertisement',
        href: '/ads',
        icon: TabletSmartphone,
        active: route().current('ads*')
    },
    {
        title: 'Banners/Pools',
        href: '/banner',
        icon: Flag,
        active: route().current('banner*')
    },
];

</script>

<style scoped>
[data-state="open"] .sidebar-submenu {
    animation: slideDown 200ms ease-out;
}

[data-state="closed"] .sidebar-submenu {
    animation: slideUp 200ms ease-out;
}

@keyframes slideDown {
    from {
        height: 0;
        opacity: 0;
    }
    to {
        height: var(--radix-collapsible-content-height);
        opacity: 1;
    }
}

@keyframes slideUp {
    from {
        height: var(--radix-collapsible-content-height);
        opacity: 1;
    }
    to {
        height: 0;
        opacity: 0;
    }
}
</style>
