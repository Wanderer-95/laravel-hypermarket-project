<script setup lang="ts">

import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { httpRequest } from '@/helpers/http';
import { ProductGroup } from '@/pages/Admin/ProductGroup/Types';
import { Category } from '@/pages/Admin/Category/Types';

defineProps<{
    productGroups: ProductGroup[];
    categories: Category[];
}>()

const productForm = useForm({
    product: {
        product_group_id: null,
        category_id: null,
        title: '',
        description: '',
        content: '',
        price: 0,
        old_price: 0,
        qty: 0
    }
});

async function storeProduct() {
    await httpRequest(route('admin.products.store'), 'POST', productForm.data());
    productForm.clearErrors();
    productForm.reset();
}

</script>

<template>

    <AdminLayout>
        <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-lg space-y-4">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Добавить продукт</h2>
            <div>
                <label class="block text-gray-600 mb-2" for="title">Название</label>
                <input
                    id="title"
                    type="text"
                    v-model="productForm.product.title"
                    placeholder="Введите название"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                >
            </div>
            <div>
                <label class="block text-gray-600 mb-2" for="description">Описание</label>
                <textarea
                    id="description"
                    v-model="productForm.product.description"
                    placeholder="Введите краткое описание"
                    rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition shadow-sm"
                ></textarea>
            </div>
            <div>
                <label class="block text-gray-600 mb-2" for="content">Контент</label>
                <textarea
                    id="content"
                    v-model="productForm.product.content"
                    placeholder="Введите детальное описание или характеристики"
                    rows="6"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-y focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition shadow-sm"
                ></textarea>
            </div>
            <div>
                <label class="block text-gray-600 mb-2" for="categoryId">Выберите категорию</label>
                <select
                    id="categoryId"
                    v-model="productForm.product.category_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                >
                    <option :value="null" disabled>
                        {{ categories.length > 0 ? 'Выберите категорию' : 'Категорий еще нет' }}
                    </option>
                    <option :value="category.id" :key="category.id" v-for="category in categories">{{ category.title }}</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-600 mb-2" for="productGroupId">Выберите группу продуктов</label>
                <select
                    id="productGroupId"
                    v-model="productForm.product.product_group_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                >
                    <option :value="null" disabled>
                        {{ productGroups.length > 0 ? 'Выберите группу продуктов' : 'Группы продуктов еще нет' }}
                    </option>
                    <option :value="productGroup.id" :key="productGroup.id" v-for="productGroup in productGroups">{{ productGroup.title }}</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-600 mb-2" for="price">Цена</label>
                <input
                    id="price"
                    type="number"
                    v-model="productForm.product.price"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                >
            </div>
            <div>
                <label class="block text-gray-600 mb-2" for="oldPrice">Старая цена</label>
                <input
                    id="oldPrice"
                    type="number"
                    v-model="productForm.product.old_price"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                >
            </div>
            <div>
                <label class="block text-gray-600 mb-2" for="qty">Количество товара</label>
                <input
                    id="qty"
                    type="number"
                    v-model="productForm.product.qty"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                >
            </div>
            <div class="mt-4">
                <button
                    @click.prevent="storeProduct"
                    class="cursor-pointer w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-300"
                >
                    Добавить
                </button>
            </div>
            <Link
                :href="route('admin.products.index')"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-300"
            >
                Назад
            </Link>
        </div>

    </AdminLayout>

</template>

<style scoped>

</style>
