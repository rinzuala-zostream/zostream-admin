<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import adsLIst from '@/components/adsLIstCom.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Advertisement Panel',
        href: '/ads',
    },
];
</script>

<template>
    <Head title="Advertisment" />

    <AppLayout :breadcrumbs="breadcrumbs">
                <adsLIst />
    </AppLayout>
</template>
