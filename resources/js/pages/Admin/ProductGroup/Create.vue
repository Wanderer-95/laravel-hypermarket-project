<script setup lang="ts">

import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { httpRequest } from '@/helpers/http';

const productGroupForm = useForm({
    title: '',
});

async function storeProductGroup() {
    await httpRequest(route('admin.product-groups.store'), 'POST', productGroupForm);
    productGroupForm.clearErrors();
    productGroupForm.reset();
}

</script>

<template>

    <AdminLayout>
        <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-lg space-y-4">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Добавить группу продуктов</h2>

            <div>
                <label class="block text-gray-600 mb-2" for="title">Название</label>
                <input
                    id="title"
                    type="text"
                    v-model="productGroupForm.title"
                    placeholder="Введите название"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                >
            </div>
            <div class="mt-4">
                <button
                    @click.prevent="storeProductGroup"
                    class="cursor-pointer w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-300"
                >
                    Добавить
                </button>
            </div>
            <Link
                :href="route('admin.product-groups.index')"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-300"
            >
                Назад
            </Link>
        </div>

    </AdminLayout>

</template>

<style scoped>

</style>
