<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import subsCom from '../components/subsCom.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Subscription Panel',
        href: '/subscribe',
    },
];
</script>

<template>
    <Head title="Subscription Panel" />

    <AppLayout :breadcrumbs="breadcrumbs">
                <subsCom />
    </AppLayout>
</template>
