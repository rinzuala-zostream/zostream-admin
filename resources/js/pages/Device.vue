<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import deviceCom from '../components/deviceCom.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Device Panel',
        href: '/device',
    },
];
</script>

<template>
    <Head title="Device Panel" />

    <AppLayout :breadcrumbs="breadcrumbs">
                <deviceCom />
    </AppLayout>
</template>
