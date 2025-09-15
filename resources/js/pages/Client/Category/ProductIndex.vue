<script setup lang="ts">
import { Product } from '@/pages/Admin/Product/Types';
import MainLayout from '@/layouts/MainLayout.vue';
import ProductItem from '@/components/Client/Product/ProductItem.vue';
import { Category } from '@/pages/Admin/Category/Types';
import { Param } from '@/pages/Admin/Param/Types';
import { ref } from 'vue';
import { httpRequest } from '@/helpers/http';

const props = defineProps<{
    products: Product[];
    breadcrumbs: Category[];
    category: Category;
    params: Param[];
}>();

const productsData = ref(props.products);

const filters = ref<{
    checkbox: Record<number, string[]>;
    integer: {
        from: Record<number, number | null>;
        to: Record<number, number | null>;
    };
    select: Record<number, string[]>;
}>({
    checkbox: {},
    integer: {
        from: {},
        to: {},
    },
    select: {},
});

function toggleItem(arr: string[], value: string): void {
    const index = arr.indexOf(value);
    if (index === -1) {
        arr.push(value);
    } else {
        arr.splice(index, 1);
    }
}

function setFilter(param: Param, value: string): void {
    if (filters.value.checkbox.hasOwnProperty(param.id)) {
        toggleItem(filters.value.checkbox[param.id], value);
        return;
    }

    filters.value.checkbox[param.id] = [];
    filters.value.checkbox[param.id].push(value);
}

function cleanInteger<T extends number | string | null>(obj: Record<number, T>): void {
    Object.keys(obj).forEach((key) => {
        const numKey = Number(key);
        const val = obj[numKey];
        if (val === null || val === undefined || val === '') {
            delete obj[numKey];
        }
    });
}

async function getPosts() {
    try {
        cleanInteger(filters.value.integer.from);
        cleanInteger(filters.value.integer.to);
        productsData.value = await httpRequest(route('client.categories.products.index', props.category.id), 'GET', { filters: filters.value });
    } catch (err) {
        console.log(err, 22);
    }
}
</script>

<template>
    <MainLayout>
        <aside class="min-h-screen w-1/4 bg-gray-900 p-6">
            <nav class="space-y-6 rounded-xl bg-gray-800 p-4">
                <template v-for="param in params">
                    <!-- Чекбоксы -->
                    <div v-if="param.filter_type === 3" :key="param.id">
                        <h3 class="mb-3 border-b border-gray-700 pb-1 text-lg font-semibold text-white">
                            {{ param.title }}
                        </h3>
                        <div class="space-y-2 pl-2">
                            <div v-for="value in param.param_values" :key="value" class="flex items-center space-x-2">
                                <input
                                    @change="setFilter(param, value)"
                                    type="checkbox"
                                    :value="value"
                                    :id="value"
                                    class="form-checkbox text-indigo-600 focus:ring-indigo-500"
                                />
                                <label :for="value" class="text-gray-300">{{ value }}</label>
                            </div>
                        </div>
                    </div>

                    <!-- Диапазон -->
                    <div v-if="param.filter_type === 1" :key="param.id">
                        <h3 class="mb-3 border-b border-gray-700 pb-1 text-lg font-semibold text-white">
                            {{ param.title }}
                        </h3>
                        <div class="flex space-x-2">
                            <input
                                v-model="filters.integer.from[param.id]"
                                type="text"
                                placeholder="От"
                                class="w-full rounded-md bg-gray-700 px-3 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            />
                            <input
                                v-model="filters.integer.to[param.id]"
                                type="text"
                                placeholder="До"
                                class="w-full rounded-md bg-gray-700 px-3 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            />
                        </div>
                    </div>
                </template>

                <!-- Кнопка -->
                <div class="border-t border-gray-700 pt-4">
                    <button
                        @click="getPosts"
                        class="w-full cursor-pointer rounded-md bg-indigo-600 px-4 py-2 font-semibold text-white transition hover:bg-indigo-700"
                    >
                        Фильтр
                    </button>
                </div>
            </nav>
        </aside>

        <article class="w-3/4 bg-gray-100 p-4">
            <div class="flex items-start space-x-2 bg-gray-100 p-4 text-sm text-gray-600">
                <template v-for="breadcrumb in breadcrumbs" :key="breadcrumb.id">
                    <div class="flex items-center">
                        <a :href="route('client.categories.products.index', breadcrumb.id)" class="transition duration-200 hover:text-blue-500">
                            {{ breadcrumb.title }}
                        </a>
                        <span class="mx-2 text-gray-400">/</span>
                    </div>
                </template>
                <span class="font-semibold text-gray-800">{{ category.title }}</span>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <ProductItem v-for="product in productsData" :product="product" :key="product.id" />
            </div>
        </article>
    </MainLayout>
</template>

<style scoped></style>
