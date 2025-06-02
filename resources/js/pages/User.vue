<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import userCom from '@/components/userCom.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User Panel',
        href: '/user',
    },
];
</script>

<template>
    <Head title="User Panel" />

    <AppLayout :breadcrumbs="breadcrumbs">
                <userCom />
    </AppLayout>
</template>