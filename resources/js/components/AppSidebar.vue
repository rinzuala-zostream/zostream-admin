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

            <!-- Inside SidebarContent -->
            <SidebarMenu class="mt-4">
                <Collapsible defaultOpen class="group/collapsible">
                    <SidebarMenuItem>
                        <CollapsibleTrigger asChild>
                            <SidebarMenuButton>
                                <Settings class="w-4 h-4 mr-2" />
                                Manage
                            </SidebarMenuButton>
                        </CollapsibleTrigger>
                        <CollapsibleContent>
                            <SidebarMenuSub>
                                <SidebarMenuSubItem v-for="item in components" :key="item.title">
                                    <Link
                                        class="block px-4 py-1 text-muted-foreground hover:text-foreground hover:underline"
                                        :href="item.href">
                                    {{ item.title }}
                                    </Link>
                                </SidebarMenuSubItem>
                            </SidebarMenuSub>
                        </CollapsibleContent>
                    </SidebarMenuItem>
                </Collapsible>
            </SidebarMenu>

        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
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
import { Settings, BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';

const mainNavItems: NavItem[] = [
    {
        title: 'Movie Panel',
        href: '/movie',
        icon: LayoutGrid,
    },
    {
        title: 'Episode Panel',
        href: '/episode',
        icon: LayoutGrid,
    },
];

const components: { title: string; href?: string }[] = [
    { title: 'User', href: '/user' },
    { title: 'Device', href: '/device' },
    { title: 'FAQ', href: '/faq' },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>