<script setup lang="ts">
import { httpRequest } from '@/helpers/http';
import { ref } from 'vue';
import { Product } from '@/pages/Admin/Product/Types';
import { usePage } from '@inertiajs/vue3';

const props = defineProps<{
    product: Product;
}>();

const qty = ref(props.product.cart?.qty ?? 1);
const cart = ref(props.product.cart);
const user = usePage().props.auth.user;

async function updateCart() {
    const res = await httpRequest(route('client.carts.update', cart.value.id), 'PATCH', { product_id: props.product.id, qty: qty.value });
    user.carts_total_sum = res.carts_total_sum;
}

async function storeCart() {
    const res = await httpRequest(route('client.carts.store'), 'POST', {
        product_id: props.product.id,
        qty: qty.value,
    });
    cart.value = res;
    user.carts_total_sum = res.carts_total_sum;
}

</script>

<template>
    <div v-if="cart" class="flex items-center gap-1">
        <button
            @click.prevent="
                qty > 1 ? qty-- : '';
                updateCart();
            "
            class="cursor-pointer rounded-md bg-violet-600 px-4 py-1 font-medium text-white transition hover:bg-violet-700"
        >
            -
        </button>
        <input v-model="qty" class="rounded-xl border border-b-gray-500 p-1 text-center" type="number" min="1" disabled />
        <button
            @click.prevent="
                qty++;
                updateCart();
            "
            class="cursor-pointer rounded-md bg-violet-600 px-4 py-1 font-medium text-white transition hover:bg-violet-700"
        >
            +
        </button>
    </div>

    <!-- Кнопка -->
    <button
        v-else
        @click.prevent="storeCart"
        type="button"
        class="cursor-pointer rounded-md bg-violet-600 px-8 py-2.5 font-medium text-white transition hover:bg-violet-700"
    >
        Купить
    </button>
</template>

<style scoped></style>
