<script setup lang="ts">

import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Category } from '@/pages/Admin/Category/Types';
import { httpRequest } from '@/helpers/http';
import { ref } from 'vue';

const props = defineProps<{
    categories: Category[]
}>();

const categoriesData = ref<Category[]>(props.categories);

const categoryForm = useForm({
    title: '',
    parent_id: null
});

async function storeCategory() {
    const res = await httpRequest(route('admin.categories.store'), 'POST', categoryForm);
    categoriesData.value.push(res);
    categoryForm.clearErrors();
    categoryForm.reset();
}

</script>

<template>

    <AdminLayout>

        <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-lg space-y-4">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Добавить категорию</h2>

            <div>
                <label class="block text-gray-600 mb-2" for="title">Название</label>
                <input
                    id="title"
                    type="text"
                    v-model="categoryForm.title"
                    placeholder="Введите название"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                >
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="parent">Родительская категория</label>
                <select
                    id="parent"
                    v-model="categoryForm.parent_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                >
                    <option :value="null" disabled>
                        {{ categories.length > 0 ? 'Выберите категорию' : 'Категорий нет' }}
                    </option>
                    <option :value="category.id" :key="category.id" v-for="category in categoriesData">{{ category.title }}</option>
                </select>
            </div>
            <div class="mt-4">
                <button
                    @click.prevent="storeCategory"
                    class="cursor-pointer w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-300"
                >
                    Добавить
                </button>
            </div>
            <Link
                :href="route('admin.categories.index')"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-300"
            >
                Назад
            </Link>
        </div>

    </AdminLayout>

</template>

<style scoped>

</style>
