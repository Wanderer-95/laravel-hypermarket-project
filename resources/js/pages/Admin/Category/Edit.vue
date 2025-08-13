<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Category } from '@/pages/Admin/Category/Types';
import { httpRequest } from '@/helpers/http';

const props = defineProps<{
    category: Category;
    categories: Category[];
}>();

const categoryForm = useForm({
    title: props.category.title,
    parent_id: props.category.parent_id,
});

async function updateCategory() {
    const res = await httpRequest(route('admin.categories.update', props.category.id), 'PATCH', categoryForm);
    categoryForm.title = res.title;
    categoryForm.parent_id = res.parent_id;
    categoryForm.clearErrors();
}
</script>

<template>
    <AdminLayout>
        <div class="mx-auto max-w-md space-y-4 rounded-lg bg-white p-6 shadow-lg">
            <h2 class="mb-4 text-2xl font-semibold text-gray-700">Обновить категорию</h2>

            <div>
                <label class="mb-2 block text-gray-600" for="title">Название</label>
                <input
                    id="title"
                    type="text"
                    v-model="categoryForm.title"
                    placeholder="Введите название"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:border-transparent focus:ring-2 focus:ring-blue-400 focus:outline-none"
                />
            </div>

            <div>
                <label class="mb-2 block text-gray-600" for="parent">Родительская категория</label>
                <select
                    id="parent"
                    v-model="categoryForm.parent_id"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:border-transparent focus:ring-2 focus:ring-blue-400 focus:outline-none"
                >
                    <option :value="null" disabled>
                        {{ categories.length > 0 ? 'Выберите категорию' : 'Категорий нет' }}
                    </option>
                    <option :value="category.id" :key="category.id" v-for="category in categories">{{ category.title }}</option>
                </select>
            </div>
            <div class="mt-4">
                <button
                    @click.prevent="updateCategory"
                    class="w-full cursor-pointer rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white shadow transition duration-300 hover:bg-blue-700"
                >
                    Обновить
                </button>
            </div>
            <Link
                :href="route('admin.categories.index')"
                class="inline-block rounded bg-blue-600 px-4 py-2 font-semibold text-white shadow transition duration-300 hover:bg-blue-700"
            >
                Назад
            </Link>
        </div>
    </AdminLayout>
</template>

<style scoped></style>
