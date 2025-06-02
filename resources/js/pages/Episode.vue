<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import EpisodeCom from '@/components/episodeCom.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Episode Panel',
        href: '/episode',
    },
];
</script>

<template>
    <Head title="Episode Panel" />

    <AppLayout :breadcrumbs="breadcrumbs">
                <EpisodeCom />
    </AppLayout>
</template>
