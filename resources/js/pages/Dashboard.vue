<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import userCount from '@/components/userCountCom.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Movie Panel',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
                <userCount />
    </AppLayout>
</template>
