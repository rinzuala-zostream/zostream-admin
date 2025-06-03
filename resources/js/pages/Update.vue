<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import searchMovie from '@/components/searchMovieCom.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Update Panel',
        href: '/update',
    },
];
</script>

<template>
    <Head title="Update Panel" />

    <AppLayout :breadcrumbs="breadcrumbs">
                <searchMovie />
    </AppLayout>
</template>
