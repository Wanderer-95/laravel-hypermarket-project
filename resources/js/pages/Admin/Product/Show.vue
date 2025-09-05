<script setup lang="ts">

import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Product } from '@/pages/Admin/Product/Types';

defineProps<{
    product: Product;
}>();


</script>

<template>
    <AdminLayout>
        <table class="mb-4 min-w-full divide-y divide-gray-200 border border-gray-300">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Заголовок</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 text-sm text-gray-900">{{ product.id }}</td>
                <td class="px-4 py-2 text-sm text-gray-900">{{ product.title }}</td>
            </tr>
            </tbody>
        </table>
        <div class="mb-4">
            <div class="flex items-center gap-4">
                <div v-for="image in product.images" :key="image.id">
                    <img :src="image.url" :alt="product.title">
                </div>
            </div>
        </div>

        <div>
            <Link
                :href="route('admin.products.index')"
                class="inline-block rounded bg-blue-600 px-4 py-2 font-semibold text-white shadow transition duration-300 hover:bg-blue-700"
            >
                Назад
            </Link>
        </div>
    </AdminLayout>
</template>

<style scoped>

</style>
