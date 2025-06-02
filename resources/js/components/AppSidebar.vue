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

            <!-- Management section -->
            <SidebarMenu class="mt-4">
                <Collapsible defaultOpen class="group/collapsible">
                    <SidebarMenuItem>
                        <CollapsibleTrigger asChild>
                            <SidebarMenuButton>
                                <Settings class="w-4 h-4 mr-2" />
                                <span class="truncate">Management</span>
                                <ChevronDown class="w-4 h-4 ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-180" />
                            </SidebarMenuButton>
                        </CollapsibleTrigger>
                        <CollapsibleContent class="mt-1">
                            <SidebarMenuSub>
                                <SidebarMenuSubItem v-for="item in managementItems" :key="item.title">
                                    <Link
                                        class="flex items-center px-4 py-1.5 text-sm text-muted-foreground hover:text-foreground hover:bg-accent rounded-md transition-colors"
                                        :href="item.href"
                                    >
                                        <component :is="item.icon" class="w-4 h-4 mr-2" />
                                        {{ item.title }}
                                    </Link>
                                </SidebarMenuSubItem>
                            </SidebarMenuSub>
                        </CollapsibleContent>
                    </SidebarMenuItem>
                </Collapsible>
            </SidebarMenu>
        </SidebarContent>

        <SidebarFooter class="border-t pt-2">
            <NavUser />
            <NavFooter :items="footerNavItems" />
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
    HelpCircle,
    ChevronDown
} from 'lucide-vue-next';

const mainNavItems: NavItem[] = [
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
];

const managementItems: NavItem[] = [
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
        title: 'FAQs', 
        href: '/faq', 
        icon: HelpCircle,
        active: route().current('faq*')
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'GitHub',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Github,
        external: true
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
        external: true
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