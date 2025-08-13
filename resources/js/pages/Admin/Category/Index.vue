<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Category } from '@/pages/Admin/Category/Types';
import { httpRequest } from '@/helpers/http';
import { ref } from 'vue';

const props = defineProps<{
    categories: Category[];
}>();

const categoriesData = ref<Category[]>(props.categories);

async function deleteCategory(category: Category) {
    await httpRequest(route('admin.categories.destroy', category.id), 'DELETE');
    categoriesData.value = categoriesData.value.filter((categoryData) => categoryData.id !== category.id);
}

</script>

<template>
    <AdminLayout>
        <table class="mb-4 min-w-full divide-y divide-gray-200 border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Заголовок</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <tr class="hover:bg-gray-50" :key="category.id" v-for="category in categoriesData">
                    <td class="px-4 py-2 text-sm text-gray-900">{{ category.id }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">
                        <Link :href="route('admin.categories.show', category.id)">
                            {{ category.title }}
                        </Link>
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-900 flex items-center gap-3">
                        <Link :href="route('admin.categories.edit', category.id)">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"
                                />
                            </svg>
                        </Link>
                        <button @click.prevent="deleteCategory(category)" class="text-red-600 hover:text-red-800 cursor-pointer">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                />
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div>
            <Link
                :href="route('admin.categories.create')"
                class="inline-block rounded bg-blue-600 px-4 py-2 font-semibold text-white shadow transition duration-300 hover:bg-blue-700"
            >
                Добавить
            </Link>
        </div>
    </AdminLayout>
</template>

<style scoped></style>
