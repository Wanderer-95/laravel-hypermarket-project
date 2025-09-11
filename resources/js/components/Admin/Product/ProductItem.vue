<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Product } from '@/pages/Admin/Product/Types';
import { httpRequest } from '@/helpers/http';
import { ref } from 'vue';

defineProps<{
    product: Product;
}>();

const isClosed = ref<boolean>(true);

const emit = defineEmits<{
    (e: 'product-deleted', product: Product): void;
}>();

async function deleteProduct(product: Product) {
    await httpRequest(route('admin.products.destroy', product.id), 'DELETE');
    emit('product-deleted', product);
}

async function getParentChildData(product: Product) {
    if (! isClosed.value) {
        isClosed.value = true;
        product.productsChildData = null;
        return;
    }

    isClosed.value = false;
    product.productsChildData = await httpRequest(route('admin.products.child.index', {product: product.id}), 'GET');
}

</script>

<template>
    <tr class="hover:bg-gray-50">
        <td class="px-4 py-2 text-sm text-gray-900">{{ product.id }}</td>
        <td class="px-4 py-2 text-sm text-gray-900">
            <Link :href="route('admin.products.show', product.id)">
                {{ product.title }}
            </Link>
        </td>
        <td class="px-4 py-2 text-sm text-gray-900">{{ product.price }}</td>
        <td class="px-4 py-2 text-sm text-gray-900">{{ product.qty }}</td>
        <td class="flex items-center gap-3 px-4 py-2 text-sm text-gray-900">
            <Link :href="route('admin.products.child.createChild', product.id)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </Link>
            <Link :href="route('admin.products.edit', product.id)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"
                    />
                </svg>
            </Link>
            <button @click.prevent="deleteProduct(product)" class="cursor-pointer text-red-600 hover:text-red-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                    />
                </svg>
            </button>
        </td>
        <td @click.prevent="getParentChildData(product)" class="cursor-pointer px-4 py-2 text-sm text-gray-900">
            <svg v-if="! product.parent_id" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" :d="isClosed ? 'm19.5 8.25-7.5 7.5-7.5-7.5' : 'm4.5 15.75 7.5-7.5 7.5 7.5'" />
            </svg>
        </td>
    </tr>
</template>

<style scoped></style>
