<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import seasonId from '../components/seasonIdCom.vue';
import seasonMan from '@/components/seasonManCom.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Season ID Panel',
        href: '/movie',
    },
];
</script>

<template>
    <Head title="Season ID Panel" />

    <AppLayout :breadcrumbs="breadcrumbs">
                <seasonId />
                <seasonMan />
    </AppLayout>
</template>
