<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import movieComVue from '@/components/movieCom.vue';
import bannerComVue from '@/components/bannerCom.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Movie Panel',
        href: '/movie',
    },
];
</script>

<template>
    <Head title="Movie Panel" />

    <AppLayout :breadcrumbs="breadcrumbs">
                <movieComVue />
                <bannerComVue />
    </AppLayout>
</template>
