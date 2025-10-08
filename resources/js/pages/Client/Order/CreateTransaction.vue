<script setup lang="ts">
import MainLayout from '@/layouts/MainLayout.vue';
import { usePage } from '@inertiajs/vue3';
import { Order } from '@/pages/Client/Order/types';

defineProps<{
    order: Order
}>();

const user = usePage().props.auth.user;
</script>

<template>
    <MainLayout>

        <article class="min-h-screen w-full bg-gray-50 p-4">
            <div class="mx-auto w-3/4">
                <div class="mb-16">
                    <div v-for="cart in order.carts" :key="cart.id">
                        <p>{{ cart.product_title }} x{{ cart.qty }} - {{ cart.total_sum }}</p>
                    </div>
                </div>
                <div>
                    <p class="mb-4">Итого: {{ user.carts_total_sum }}</p>
                    <button class="cursor-pointer rounded-2xl bg-indigo-500 p-4 text-white">Оплатить</button>
                </div>
            </div>
        </article>
    </MainLayout>
</template>

<style scoped></style>
