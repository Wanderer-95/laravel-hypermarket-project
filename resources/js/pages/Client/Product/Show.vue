<script setup lang="ts">

import { Product } from '@/pages/Admin/Product/Types';
import MainLayout from '@/layouts/MainLayout.vue';
import { Category } from '@/pages/Admin/Category/Types';
import Breadcrumb from '@/components/Client/Category/Breadcrumb.vue';
import { ref } from 'vue';

const props = defineProps<{
    product: Product;
    breadcrumbs: Category[];
}>();

const selectedImage = ref(props.product.preview_url);

</script>

<template>

    <MainLayout>
        <article class="p-6 w-full max-w-6xl mx-auto">

            <!-- Хлебные крошки -->
            <Breadcrumb :current="product.title" :breadcrumbs="breadcrumbs" class="mb-6" />

            <!-- Карточка товара -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col md:flex-row gap-6 p-6">

                <!-- Галерея -->
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Большое изображение -->
                    <div v-if="selectedImage" class="md:w-96 w-full">
                        <img :src="selectedImage" :alt="product.title" class="w-full h-auto object-cover rounded-lg shadow" />
                    </div>

                    <!-- Миниатюры -->
                    <div class="flex md:flex-col gap-3 overflow-x-auto md:overflow-visible md:w-24">
                        <div
                            v-for="image in product.images"
                            :key="image.id"
                            class="w-20 h-20 rounded-md overflow-hidden border hover:border-violet-600 transition"
                        >
                            <img
                                @click="selectedImage = image.url"
                                class="cursor-pointer object-cover w-full h-full"
                                :src="image.url"
                                :alt="product.title"
                            />
                        </div>
                    </div>
                </div>

                <!-- Контент -->
                <div class="flex-1 flex flex-col justify-between">
                    <!-- Название -->
                    <h1 class="text-2xl font-semibold text-gray-800 mb-2">
                        {{ product.title }}
                    </h1>

                    <!-- Краткое описание -->
                    <p class="text-gray-600 text-sm mb-4">
                        {{ product.description }}
                    </p>

                    <!-- Цена -->
                    <div class="flex items-center gap-3 mb-4">
                    <span :class="[product.old_price ? 'text-red-600' : 'text-gray-900', 'text-2xl font-bold']">
                        {{ product.price }}₽
                    </span>
                        <span v-if="product.old_price" class="text-gray-400 line-through text-lg">
                        {{ product.old_price }}₽
                    </span>
                    </div>

                    <!-- Кол-во и кнопка -->
                    <div class="flex items-center gap-4 mb-6">
                        <button
                            type="button"
                            class="cursor-pointer bg-violet-600 hover:bg-violet-700 text-white font-medium py-2 px-6 rounded-md transition"
                        >
                            В корзину
                        </button>
                    </div>
                </div>
            </div>

            <!-- Описание и характеристики -->
            <div class="mt-10 space-y-8">

                <!-- Описание -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Описание</h2>
                    <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">
                        {{ product.content }}
                    </p>
                </div>

                <!-- Характеристики -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Характеристики</h2>
                    <div class="space-y-3">
                        <div
                            class="flex items-center gap-2 text-sm text-gray-700"
                            v-for="param in product.params"
                            :key="param.id"
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

        </article>
    </MainLayout>


</template>

<style scoped>

</style>
