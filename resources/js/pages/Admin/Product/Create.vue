<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { httpRequest } from '@/helpers/http';
import { ProductGroup } from '@/pages/Admin/ProductGroup/Types';
import { Category } from '@/pages/Admin/Category/Types';
import { ref } from 'vue';
import { Param } from '@/pages/Admin/Param/Types';

defineProps<{
    productGroups: ProductGroup[];
    categories: Category[];
    params: Param[];
}>();

interface ParamObj {
    id: number;
    title: string;
}

interface ParamOption {
    paramObj: ParamObj | null;
    value: string;
}

const paramOption = ref<ParamOption>({
    paramObj: null,
    value: '',
});

const productForm = useForm({
    product: {
        product_group_id: null as number | null,
        category_id: null as number | null,
        title: '',
        description: '',
        content: '',
        price: 0,
        old_price: 0,
        qty: 0,
        article: 0,
    },
});

interface ProductParam {
    param_id: number;
    title: string;
    value: string;
}

const paramsData = ref<ProductParam[]>([]);

const images = ref<FileList | null>(null);
const fileInput = ref<HTMLInputElement | null>(null);

function setImages(e: Event) {
    const target = e.target as HTMLInputElement;
    if (target.files) {
        images.value = target.files;
        target.files = null;
    }
}

function removeParam(entriParam: ProductParam) {
    paramsData.value = paramsData.value?.filter((param) => param.param_id !== entriParam.param_id);
}

function setParam() {
    if (!paramOption.value.paramObj) return;

    if (!paramsData.value) {
        paramsData.value = [];
    }

    paramsData.value.push({
        param_id: paramOption.value.paramObj.id,
        title: paramOption.value.paramObj.title,
        value: paramOption.value.value,
    });

    // очищаем поле ввода
    paramOption.value.value = '';
    paramOption.value.paramObj = null;
}


async function storeProduct() {
    const formData = new FormData();

    // product fields
    Object.entries(productForm.product).forEach(([key, value]) => {
        formData.append(`product[${key}]`, String(value ?? ''));
    });

    // images
    if (images.value) {
        for (let i = 0; i < images.value.length; i++) {
            formData.append('images[]', images.value[i]);
        }
    }

    // params (сериализация объектов)
    if (paramsData.value) {
        paramsData.value.forEach((p, index) => {
            formData.append(`params[${index}][param_id]`, String(p.param_id));
            formData.append(`params[${index}][value]`, p.value);
        });
    }

    try {
        await httpRequest(route('admin.products.store'), 'POST', formData);

        productForm.clearErrors();
        images.value = null;

        // Сброс input
        if (fileInput.value) {
            fileInput.value.value = '';
        }
        productForm.reset();
        paramsData.value = [];
    } catch (err) {
        console.error(err);
    }
}

</script>

<template>
    <AdminLayout>
        <div class="mx-auto max-w-md space-y-4 rounded-lg bg-white p-6 shadow-lg">
            <h2 class="mb-4 text-2xl font-semibold text-gray-700">Добавить продукт</h2>
            <div>
                <label class="mb-2 block text-gray-600" for="title">Название</label>
                <input
                    id="title"
                    type="text"
                    v-model="productForm.product.title"
                    placeholder="Введите название"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:border-transparent focus:ring-2 focus:ring-blue-400 focus:outline-none"
                />
            </div>
            <div>
                <label class="mb-2 block text-gray-600" for="article">Артикль</label>
                <input
                    id="article"
                    type="text"
                    v-model="productForm.product.article"
                    placeholder="Введите артикль"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:border-transparent focus:ring-2 focus:ring-blue-400 focus:outline-none"
                />
            </div>
            <div>
                <label class="mb-2 block text-gray-600" for="description">Описание</label>
                <textarea
                    id="description"
                    v-model="productForm.product.description"
                    placeholder="Введите краткое описание"
                    rows="3"
                    class="w-full resize-none rounded-lg border border-gray-300 px-4 py-3 shadow-sm transition focus:border-transparent focus:ring-2 focus:ring-blue-400 focus:outline-none"
                ></textarea>
            </div>
            <div>
                <label class="mb-2 block text-gray-600" for="content">Контент</label>
                <textarea
                    id="content"
                    v-model="productForm.product.content"
                    placeholder="Введите детальное описание или характеристики"
                    rows="6"
                    class="w-full resize-y rounded-lg border border-gray-300 px-4 py-3 shadow-sm transition focus:border-transparent focus:ring-2 focus:ring-blue-400 focus:outline-none"
                ></textarea>
            </div>
            <div>
                <label class="mb-2 block text-gray-600" for="categoryId">Выберите категорию</label>
                <select
                    id="categoryId"
                    v-model="productForm.product.category_id"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:border-transparent focus:ring-2 focus:ring-blue-400 focus:outline-none"
                >
                    <option :value="null" disabled>
                        {{ categories.length > 0 ? 'Выберите категорию' : 'Категорий еще нет' }}
                    </option>
                    <option :value="category.id" :key="category.id" v-for="category in categories">{{ category.title }}</option>
                </select>
            </div>
            <div>
                <label class="mb-2 block text-gray-600" for="productGroupId">Выберите группу продуктов</label>
                <select
                    id="productGroupId"
                    v-model="productForm.product.product_group_id"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:border-transparent focus:ring-2 focus:ring-blue-400 focus:outline-none"
                >
                    <option :value="null" disabled>
                        {{ productGroups.length > 0 ? 'Выберите группу продуктов' : 'Группы продуктов еще нет' }}
                    </option>
                    <option :value="productGroup.id" :key="productGroup.id" v-for="productGroup in productGroups">{{ productGroup.title }}</option>
                </select>
            </div>
            <div>
                <label class="mb-2 block text-gray-600" for="file">Выберите изображения</label>
                <input
                    ref="fileInput"
                    @change="setImages"
                    id="file"
                    type="file"
                    multiple
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:border-transparent focus:ring-2 focus:ring-blue-400 focus:outline-none"
                />
            </div>
            <div>
                <label class="mb-2 block text-gray-600" for="price">Цена</label>
                <input
                    id="price"
                    type="number"
                    v-model="productForm.product.price"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:border-transparent focus:ring-2 focus:ring-blue-400 focus:outline-none"
                />
            </div>
            <div>
                <label class="mb-2 block text-gray-600" for="oldPrice">Старая цена</label>
                <input
                    id="oldPrice"
                    type="number"
                    v-model="productForm.product.old_price"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:border-transparent focus:ring-2 focus:ring-blue-400 focus:outline-none"
                />
            </div>
            <div>
                <label class="mb-2 block text-gray-600" for="qty">Количество товара</label>
                <input
                    id="qty"
                    type="number"
                    v-model="productForm.product.qty"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:border-transparent focus:ring-2 focus:ring-blue-400 focus:outline-none"
                />
            </div>
            <div class="space-y-4 rounded-2xl bg-white p-4 shadow-md">
                <!-- Select -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700" for="param"> Выберите характеристику </label>
                    <select
                        id="param"
                        v-model="paramOption.paramObj"
                        class="focus:ring-opacity-50 w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300"
                    >
                        <option :value="null" disabled>
                            {{ params.length > 0 ? 'Выберите характеристику' : 'Характеристик еще нет' }}
                        </option>
                        <option :value="param" :key="param.id" v-for="param in params">
                            {{ param.title }}
                        </option>
                    </select>
                </div>

                <!-- Input -->
                <div class="flex gap-2">
                    <input
                        id="paramValue"
                        type="text"
                        v-model="paramOption.value"
                        placeholder="Введите значение"
                        class="focus:ring-opacity-50 w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300"
                    />
                    <button
                        type="button"
                        @click="setParam"
                        class="cursor-pointer rounded-lg bg-blue-500 px-4 py-2 font-medium text-white shadow transition hover:bg-blue-600"
                    >
                        +
                    </button>
                </div>
            </div>
            <div>
                <div class="flex items-center gap-2" :key="entriParam.param_id" v-for="entriParam in paramsData">
                    {{ entriParam.title }} - {{ entriParam.value }}
                    <div @click="removeParam(entriParam)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="cursor-pointer size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button
                    @click.prevent="storeProduct"
                    class="w-full cursor-pointer rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white shadow transition duration-300 hover:bg-blue-700"
                >
                    Добавить
                </button>
            </div>
            <Link
                :href="route('admin.products.index')"
                class="inline-block rounded bg-blue-600 px-4 py-2 font-semibold text-white shadow transition duration-300 hover:bg-blue-700"
            >
                Назад
            </Link>
        </div>
    </AdminLayout>
</template>

<style scoped></style>
