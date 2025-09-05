<script setup lang="ts">

import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Param } from '@/pages/Admin/Param/Types';

defineProps<{
    param: Param;
}>();

</script>

<template>
    <AdminLayout>
        <table class="mb-4 min-w-full divide-y divide-gray-200 border border-gray-300">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Заголовок</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Тип фильтра</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Заголовок типа фильтра</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 text-sm text-gray-900">{{ param.id }}</td>
                <td class="px-4 py-2 text-sm text-gray-900">{{ param.title }}</td>
                <td class="px-4 py-2 text-sm text-gray-900">{{ param.filter_type }}</td>
                <td class="px-4 py-2 text-sm text-gray-900">{{ param.filter_type_title }}</td>
            </tr>
            </tbody>
        </table>

        <div>
            <Link
                :href="route('admin.params.index')"
                class="inline-block rounded bg-blue-600 px-4 py-2 font-semibold text-white shadow transition duration-300 hover:bg-blue-700"
            >
                Назад
            </Link>
        </div>
    </AdminLayout>
</template>

<style scoped>

</style>
