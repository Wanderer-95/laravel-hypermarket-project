<script setup lang="ts">

import { Category } from '@/pages/Admin/Category/Types';
import { Link } from '@inertiajs/vue3';

defineProps<{
    current: string;
    breadcrumbs: Category[];
}>();

</script>

<template>
    <div class="flex items-start space-x-2 bg-gray-100 p-4 text-sm text-gray-600">
        <Link :href="route('client.categories.index')">
            Категории
        </Link>
        <span class="mx-2 text-gray-400">/</span>
        <template v-for="breadcrumb in breadcrumbs" :key="breadcrumb.id">
            <div class="flex itemsц-center">
                <Link :href="route('client.categories.products.index', breadcrumb.id)">
                    {{ breadcrumb.title }}
                </Link>
                <span class="mx-2 text-gray-400">/</span>
            </div>
        </template>
        <span class="font-semibold text-gray-800">{{ current }}</span>
    </div>
</template>

<style scoped>

</style>
