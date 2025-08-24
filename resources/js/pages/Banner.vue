<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import banner from '@/components/bannerCom.vue';
import pool from '@/components/poolCom.vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Banner Panel',
        href: '/banner',
    },
];
</script>

<template>
    <Head title="banner/pools" />

    <AppLayout :breadcrumbs="breadcrumbs">
                <banner />
                <pool />
    </AppLayout>
</template>
