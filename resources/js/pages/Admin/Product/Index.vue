<script setup lang="ts">

import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Product } from '@/pages/Admin/Product/Types';
import ProductItem from '@/components/Admin/Product/ProductItem.vue';

const props = defineProps<{
    products: Product[];
}>();

const productsData = ref<Product[]>(props.products);

function updateProductsData(product: Product) {
    if (product.parent_id) {
        productsData.value.forEach((item) => {
            if (item.id === product.parent_id) {
                item.productsChildData = item.productsChildData?.filter(productChild => product.id !== productChild.id);
            }
        })

    }
    productsData.value = productsData.value.filter((productData) => productData.id !== product.id);
}

</script>

<template>

    <AdminLayout>
        <table class="mb-4 min-w-full divide-y divide-gray-200 border border-gray-300">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Заголовок</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Цена</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Склад</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Действия</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Продукт</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <template :key="product.id" v-for="product in productsData">
                    <ProductItem :product="product" @product-deleted="updateProductsData" />
                    <template v-if="product.productsChildData">
                        <template :key="productChild.id" v-for="productChild in product.productsChildData">
                            <ProductItem :product="productChild" @product-deleted="updateProductsData" />
                        </template>
                    </template>
                </template>
            </tbody>
        </table>

        <div>
            <Link
                :href="route('admin.products.create')"
                class="inline-block rounded bg-blue-600 px-4 py-2 font-semibold text-white shadow transition duration-300 hover:bg-blue-700"
            >
                Добавить
            </Link>
        </div>
    </AdminLayout>

</template>

<style scoped>

</style>
