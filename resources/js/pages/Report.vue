<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import reportCom from '../components/reportCom.vue';
import poolComVue from '@/components/poolCom.vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Report Panel',
        href: '/report',
    },
];
</script>

<template>
    <Head title="Report" />

    <AppLayout :breadcrumbs="breadcrumbs">
                <reportCom />
                <poolComVue />
    </AppLayout>
</template>
