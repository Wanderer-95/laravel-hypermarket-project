<script setup lang="ts">

import { Product } from '@/pages/Admin/Product/Types';
import { Link } from '@inertiajs/vue3';
import StoreOrUpdateCart from '@/components/Client/Cart/StoreOrUpdateCart.vue';

defineProps<{
    product: Product;
}>();

</script>

<template>

    <div
        class="bg-white rounded-2xl shadow-md flex flex-col overflow-hidden hover:shadow-lg transition"
    >
        <!-- Картинка -->
        <img
            :src="product.preview_url"
            :alt="product.title"
            class="h-48 w-full object-cover"
        />

        <!-- Контент -->
        <div class="flex flex-col flex-grow p-4">
            <Link :href="route('client.products.show', product.id)">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">
                    {{ product.title }}
                </h2>
            </Link>
            <p class="text-sm text-gray-600 flex-grow">
                {{ product.description }}
            </p>

            <div class="flex justify-between">
                        <span class="text-xl font-bold text-green-600">
                            {{ product.price }} ₽
                        </span>
                <span class="text-xl font-bold text-green-600">
                            {{ product.old_price }} ₽
                        </span>
            </div>

            <div class="mt-4 flex items-center justify-between">
                <StoreOrUpdateCart :product="product" />
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
