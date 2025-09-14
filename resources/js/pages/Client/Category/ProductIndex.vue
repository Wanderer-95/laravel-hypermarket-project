<script setup lang="ts">

import { Product } from '@/pages/Admin/Product/Types';
import MainLayout from '@/layouts/MainLayout.vue';
import ProductItem from '@/components/Client/Product/ProductItem.vue';
import { Category } from '@/pages/Admin/Category/Types';
import { Param } from '@/pages/Admin/Param/Types';
import { ref } from 'vue';

defineProps<{
    products: Product[];
    breadcrumbs: Category[];
    category: Category;
    params: Param[];
}>();

const filters = ref<{
    checkbox: Record<number, string[]>;
    integer: {
        from: Record<number, number | null>;
        to: Record<number, number | null>;
    };
}>({
    checkbox: {},
    integer: {
        from: {},
        to: {}
    }
});

function toggleItem(arr: string[], value: string): void
{
    const index = arr.indexOf(value);
    if (index === -1)
    {
        arr.push(value);
    } else {
        arr.splice(index, 1);
    }
}

function setFilter(param: Param, value: string): void
{
    if (filters.value.checkbox.hasOwnProperty(param.id))
    {
        toggleItem(filters.value.checkbox[param.id], value);
        return;
    }

    filters.value.checkbox[param.id] = [];
    filters.value.checkbox[param.id].push(value);
}

</script>

<template>

    <MainLayout>
        {{ filters.integer }}
        {{ filters.checkbox }}
        <aside class="w-1/4 bg-gray-900 min-h-screen p-6">
            <nav class="bg-gray-800 rounded-xl p-4 space-y-6">
                <template v-for="param in params">
                    <!-- Чекбоксы -->
                    <div v-if="param.filter_type === 3" :key="param.id">
                        <h3 class="text-lg font-semibold text-white mb-3 border-b border-gray-700 pb-1">
                            {{ param.title }}
                        </h3>
                        <div class="space-y-2 pl-2">
                            <div v-for="value in param.param_values" :key="value" class="flex items-center space-x-2">
                                <input @change="setFilter(param, value)" type="checkbox" :value="value" :id="value" class="form-checkbox text-indigo-600 focus:ring-indigo-500">
                                <label :for="value" class="text-gray-300">{{ value }}</label>
                            </div>
                        </div>
                    </div>

                    <!-- Диапазон -->
                    <div v-if="param.filter_type === 1" :key="param.id">
                        <h3 class="text-lg font-semibold text-white mb-3 border-b border-gray-700 pb-1">
                            {{ param.title }}
                        </h3>
                        <div class="flex space-x-2">
                            <input v-model="filters.integer.from[param.id]" type="text" placeholder="От"
                                   class="w-full px-3 py-2 rounded-md bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <input v-model="filters.integer.to[param.id]" type="text" placeholder="До"
                                   class="w-full px-3 py-2 rounded-md bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                </template>

                <!-- Кнопка -->
                <div class="pt-4 border-t border-gray-700">
                    <button class="w-full cursor-pointer bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md transition">
                        Фильтр
                    </button>
                </div>
            </nav>
        </aside>

        <article class="p-4 w-3/4 bg-gray-100 ">
            <div class="p-4 bg-gray-100 flex items-start space-x-2 text-sm text-gray-600">
                <template v-for="breadcrumb in breadcrumbs" :key="breadcrumb.id">
                    <div class="flex items-center">
                        <a
                            :href="route('client.categories.products.index', breadcrumb.id)"
                        class="hover:text-blue-500 transition duration-200"
                        >
                        {{ breadcrumb.title }}
                        </a>
                        <span class="mx-2 text-gray-400">/</span>
                    </div>
                </template>
                <span class="font-semibold text-gray-800">{{ category.title }}</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <ProductItem v-for="product in products" :product="product" :key="product.id"/>
            </div>
        </article>
    </MainLayout>

</template>

<style scoped>

</style>
