<script setup lang="ts">
import MainLayout from '@/layouts/MainLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Cart } from '@/pages/Client/Cart/types';
import { httpRequest } from '@/helpers/http';
import { router } from '@inertiajs/vue3'

const props = defineProps<{
    carts: Cart[]
}>();

const cartsData = ref(props.carts);
const user = usePage().props.auth.user;

async function updateCart(cart: Cart) {
    const res = await httpRequest(
        route('client.carts.update', cart.id),
        'PATCH',
        { qty: cart.qty }
    );
    cart.total_sum = await res.total_sum;
    user.carts_total_sum = res.carts_total_sum
}

async function destroyCart(cart: Cart) {
    const res = await httpRequest(
        route('client.carts.destroy', cart.id),
        'DELETE',
    );
    cartsData.value = cartsData.value.filter(cartData => cartData.id !== cart.id);
    user.carts_total_sum = user.carts_total_sum - cart.total_sum;
}

async function storeOrder() {
    router.post(route('client.orders.store'))
    // const res = await httpRequest(
    //     route('client.orders.store'),
    //     'POST',
    // );
}

</script>

<template>
    <MainLayout>
        <article class="w-full bg-gray-50 p-4 min-h-screen">
            <div class="w-3/4 mx-auto">
                <template v-if="user.carts_total_sum > 0">
                    <table class="mb-4 min-w-full divide-y divide-gray-200 border border-gray-300">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Наименования</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Фото</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Количество</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Сумма</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr class="hover:bg-gray-50" :key="cart.id" v-for="cart in cartsData">
                            <td class="px-4 py-2 text-sm text-gray-900">{{ cart.id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">
                                <Link :href="route('client.products.show', cart.product_id)">
                                    {{ cart.product_title }}
                                </Link>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900">
                                <Link :href="route('client.products.show', cart.product_id)">
                                    <img class="w-24" :src="cart.product_image_url" :alt="cart.product_title">
                                </Link>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900">
                                <div class="flex items-center gap-1">
                                    <button
                                        @click.prevent="cart.qty > 1 ? cart.qty-- : ''; updateCart(cart)"
                                        class="cursor-pointer rounded-md bg-violet-600 px-4 py-1 font-medium text-white transition hover:bg-violet-700">
                                        -
                                    </button>
                                    <input v-model="cart.qty" class="rounded-xl border border-b-gray-500 p-1 text-center" type="number" min="1" disabled />
                                    <button
                                        @click.prevent="cart.qty++; updateCart(cart)"
                                        class="cursor-pointer rounded-md bg-violet-600 px-4 py-1 font-medium text-white transition hover:bg-violet-700">
                                        +
                                    </button>
                                </div>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ cart.total_sum }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">
                                <svg @click="destroyCart(cart)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 hover:text-red-500 cursor-pointer">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                    />
                                </svg>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div>
                        <p class="mb-4">Итого: {{ user.carts_total_sum }}</p>
                        <button @click="storeOrder" class="p-4 bg-indigo-500 text-white rounded-2xl cursor-pointer">Оформить</button>
                    </div>
                </template>
                <template v-else>
                    <div class="mb-4 bg-white border border-gray-300 p-4">
                        <p>Добавьте товары в корзину, перейдите в <Link :href="route('client.categories.index')" class="text-indigo-500">каталог</Link></p>
                    </div>
                </template>
            </div>
        </article>
    </MainLayout>
</template>

<style scoped>

</style>
