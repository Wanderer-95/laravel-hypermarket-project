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
        <article class="p-6 w-full">

            <Breadcrumb :current="product.title" :breadcrumbs="breadcrumbs" />

            <!-- Карточка товара -->
            <div class="bg-gray-100 border flex border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">

                <!-- Картинка -->
                <div class="flex">
                    <div v-if="selectedImage" class="mr-4">
                        <img :src="selectedImage" :alt="product.title" class="mx-auto object-cover rounded-t-xl">
                    </div>
                    <div>
                        <div v-for="image in product.images" :key="image.id" class="w-24 mb-4">
                            <img @click="selectedImage = image.url" class="cursor-pointer" :src="image.url" :alt="product.title">
                        </div>
                    </div>
                </div>

                <!-- Контент -->
                <div class="p-4 flex flex-col justify-between h-full">

                    <!-- Заголовок -->
                    <h3 class="text-base font-medium text-gray-900 mb-1 line-clamp-2">
                        {{ product.title }}
                    </h3>

                    <!-- Описание -->
                    <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                        {{ product.description }}
                    </p>

                    <!-- Цена -->
                    <div class="flex items-center gap-2 mb-3">
                        <span :class="[product.old_price ? 'text-red-600' : '', 'text-lg font-semibold']">{{ product.price }}₽</span>
                        <span v-if="product.old_price" class="text-sm text-gray-400 line-through">{{ product.old_price }}₽</span>
                    </div>

                    <div>
                        <input type="number" class="bg-white p-3 mr-2" value="1">
                        <button type="button" class="bg-violet-600 text-white py-4 px-4 rounded-md hover:bg-violet-700 transition">
                            В корзину
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <div class="mb-4">
                    <h3>Описание</h3>
                    <p>{{ product.content }}</p>
                </div>
                <div>
                    <h3>Характеристики</h3>
                    <div>
                        <div class="flex items-center gap-2" v-for="param in product.params" :key="param.id">
                            {{ param.title }}:
                            <template v-for="value in param.values" :key="value">
                                <span class="border border-b-gray-400" v-if="param.label === 'color'" :style="`background: ${value}; width: 32px; height: 16px;`"></span>
                                <span v-if="param.label !== 'color'" >{{ value }}</span>
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
