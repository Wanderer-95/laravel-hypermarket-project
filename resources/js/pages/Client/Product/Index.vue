<script setup lang="ts">
import { Product } from '@/pages/Admin/Product/Types';
import MainLayout from '@/layouts/MainLayout.vue';
import ProductItem from '@/components/Client/Product/ProductItem.vue';

defineProps<{
    products: Product[];
}>();

</script>

<template>
    <MainLayout>
        <aside class="w-1/4 bg-gray-800 min-h-screen">
            <nav class="bg-gray-800 rounded-lg overflow-hidden">
            </nav>
        </aside>

        <article class="p-6 w-3/4 bg-gray-100 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <ProductItem v-for="product in products" :product="product" :key="product.id"/>
        </article>
    </MainLayout>
</template>

<style scoped>

</style>
