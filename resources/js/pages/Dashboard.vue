<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import movieCount from '@/components/dashboardCom.vue';

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
                <movieCount />
    </AppLayout>
</template>
