<script setup lang="ts">
import banner from '@/components/bannerCom.vue';
import pool from '@/components/poolCom.vue';
import textScroll from '@/components/textScrollCom.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

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
        <textScroll />
        <pool />
    </AppLayout>
</template>
