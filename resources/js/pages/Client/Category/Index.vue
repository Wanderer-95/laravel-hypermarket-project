<script setup lang="ts">

import MainLayout from '@/layouts/MainLayout.vue';
import { Category } from '@/pages/Admin/Category/Types';
import { Link } from '@inertiajs/vue3';

defineProps<{
    categories: Category[];
}>();

</script>

<template>

    <MainLayout>

        <article class="w-full text-center bg-gray-100 p-4">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div v-for="category in categories" :key="category.id">
                    <Link :href="route('client.categories.products.index', category.id)">
                        {{ category.title }}
                    </Link>
                </div>
            </div>

        </article>

    </MainLayout>

</template>

<style scoped></style>
