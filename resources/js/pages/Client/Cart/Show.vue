<script setup lang="ts">

import { Product } from '@/pages/Admin/Product/Types';
import MainLayout from '@/layouts/MainLayout.vue';
import { Category } from '@/pages/Admin/Category/Types';
import Breadcrumb from '@/components/Client/Category/Breadcrumb.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ParamProduct } from '@/pages/Client/Product/types';

const props = defineProps<{
    product: Product;
    breadcrumbs: Category[];
    paramProducts: ParamProduct[];
}>();

const selectedImage = ref(props.product.preview_url);

</script>

<template>
    <MainLayout>
        <article class="p-6 max-w-7xl mx-auto">
            <!-- Хлебные крошки -->
            <Breadcrumb :current="product.title" :breadcrumbs="breadcrumbs" class="mb-6" />

            <!-- Карточка товара -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm transition-all p-6 flex flex-col md:flex-row gap-10">

                <!-- Галерея -->
                <div class="flex flex-col gap-4 md:w-1/2">
                    <div v-if="selectedImage" class="w-full aspect-square rounded-lg overflow-hidden">
                        <img :src="selectedImage" :alt="product.title" class="w-full h-full object-cover" />
                    </div>

                    <!-- Миниатюры -->
                    <div class="flex gap-3 overflow-x-auto">
                        <div
                            v-for="image in product.images"
                            :key="image.id"
                            class="w-20 h-20 border rounded overflow-hidden hover:border-violet-600 cursor-pointer transition"
                            @click="selectedImage = image.url"
                        >
                            <img :src="image.url" :alt="product.title" class="object-cover w-full h-full" />
                        </div>
                    </div>
                </div>

                <!-- Контент -->
                <div class="flex flex-col gap-6 md:w-1/2">
                    <!-- Название -->
                    <h1 class="text-3xl font-semibold text-gray-900">
                        {{ product.title }}
                    </h1>

                    <!-- Краткое описание -->
                    <p class="text-gray-600 text-base leading-relaxed">
                        {{ product.description }}
                    </p>

                    <!-- Цена -->
                    <div class="flex items-center gap-4">
            <span :class="[product.old_price ? 'text-red-600' : 'text-gray-900', 'text-2xl font-bold']">
              {{ product.price }}₽
            </span>
                        <span v-if="product.old_price" class="text-gray-400 line-through text-lg">
              {{ product.old_price }}₽
            </span>
                    </div>

                    <!-- Кнопка -->
                    <button
                        type="button"
                        class="bg-violet-600 hover:bg-violet-700 text-white font-medium py-2.5 px-8 rounded-md transition"
                    >
                        В корзину
                    </button>
                    <!-- Параметры (если есть) -->
                    <div v-if="paramProducts.length" class="space-y-4">
                        <div v-for="paramProduct in paramProducts" :key="paramProduct.title">
                            <h3 class="text-gray-800 font-medium">{{ paramProduct.title }}</h3>
                            <div class="flex gap-3 flex-wrap">
                                <Link
                                    v-for="data in paramProduct.data"
                                    :key="data.id"
                                    :href="route('client.products.show', data.product_id)"
                                    :class="[data.product_id === product.id ? 'text-white bg-sky-500 hover:bg-black transition': 'text-sky-500 hover:bg-indigo-300 transition', 'text-xl px-4 py-2 rounded border border-sky-500']"
                                >
                                    <span
                                        v-if="paramProduct.title === 'color'"
                                        class="inline-block border rounded w-6 h-4"
                                        :style="`background: ${data.value}`"
                                    ></span>
                                    <span v-else>{{ data.value }}</span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Описание и характеристики -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Описание -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Описание</h2>
                    <p class="text-gray-700 whitespace-pre-line leading-relaxed text-sm">
                        {{ product.content }}
                    </p>
                </div>

                <!-- Характеристики -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Характеристики</h2>
                    <div class="space-y-3">
                        <div
                            v-for="param in product.params"
                            :key="param.id"
                            class="text-sm text-gray-700 flex flex-wrap items-center gap-2"
                        >
                            <span class="font-medium">{{ param.title }}:</span>
                            <template v-for="value in param.values" :key="value">
                                <span
                                    v-if="param.label === 'color'"
                                    class="inline-block border rounded w-6 h-4"
                                    :style="`background: ${value}`"
                                ></span>
                                <span v-else>{{ value }}</span>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Другие варианты -->
            <div v-if="product.group_products.length" class="mt-16">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Другие варианты</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    <div
                        v-for="groupProduct in product.group_products"
                        :key="groupProduct.id"
                        class="bg-white border rounded-lg p-4 shadow-sm hover:shadow-md transition"
                    >
                        <Link :href="route('client.products.show', groupProduct.id)">
                            <img
                                :src="groupProduct.preview_url"
                                :alt="groupProduct.title"
                                class="w-full h-32 object-cover rounded mb-2"
                            />
                            <h4 class="text-sm font-semibold text-gray-800 truncate">
                                {{ groupProduct.title }}
                            </h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span :class="[groupProduct.old_price ? 'text-red-600' : 'text-gray-900', 'text-sm font-bold']">
                                  {{ groupProduct.price }}₽
                                </span>
                                                <span v-if="groupProduct.old_price" class="text-gray-400 line-through text-sm">
                                  {{ groupProduct.old_price }}₽
                                </span>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </article>
    </MainLayout>
</template>

<style scoped>

</style>
