<script setup lang="ts">

import { Product } from '@/pages/Admin/Product/Types';
import MainLayout from '@/layouts/MainLayout.vue';
import ProductItem from '@/components/Client/Product/ProductItem.vue';
import { Category } from '@/pages/Admin/Category/Types';

defineProps<{
    products: Product[];
    breadcrumbs: Category[];
    category: Category;
}>();

</script>

<template>

    <MainLayout>
        <aside class="w-1/4 bg-gray-800 min-h-screen">
            <nav class="bg-gray-800 rounded-lg overflow-hidden">
            </nav>
        </aside>

        <article class="p-4 w-3/4 bg-gray-100 ">
            <div class="p-4 bg-gray-100 flex items-start space-x-2 text-sm text-gray-600">
                <template v-for="breadcrumb in breadcrumbs" :key="breadcrumb.id">
                    <div class="flex items-center">
                        <a
                            :href="route('client.categories.products.index', breadcrumb.id)"
                        class="hover:text-blue-500 transition duration-200"
                        >
                        {{ breadcrumb.title }}
                        </a>
                        <span class="mx-2 text-gray-400">/</span>
                    </div>
                </template>
                <span class="font-semibold text-gray-800">{{ category.title }}</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <ProductItem v-for="product in products" :product="product" :key="product.id"/>
            </div>
        </article>
    </MainLayout>

</template>

<style scoped>

</style>
