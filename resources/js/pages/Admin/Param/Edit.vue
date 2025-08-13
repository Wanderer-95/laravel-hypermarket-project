<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { httpRequest } from '@/helpers/http';
import { FilterType, Param } from '@/pages/Admin/Param/Types';
import { ref, watch } from 'vue';

const props = defineProps<{
    param: Param;
    filterTypes: FilterType[];
}>();

const isSuccess = ref(false);

const paramForm = useForm({
    title: props.param.title,
    filter_type: props.param.filter_type,
});

async function updateParam() {
    isSuccess.value = true;
    const res = await httpRequest(route('admin.params.update', props.param.id), 'PATCH', paramForm);
    paramForm.title = res.title;
    paramForm.filter_type = res.filter_type;
    paramForm.clearErrors();
}

watch(() => [paramForm.title, paramForm.filter_type], () => {
    isSuccess.value = false;
}, {deep: true});

</script>

<template>
    <AdminLayout>
        <div v-if="isSuccess" class="p-4 bg-green-100 mb-4">
            Успешно обновлено!
        </div>
        <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-lg space-y-4">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Обновить характеристику</h2>

            <div>
                <label class="block text-gray-600 mb-2" for="title">Название</label>
                <input
                    id="title"
                    type="text"
                    v-model="paramForm.title"
                    placeholder="Введите название"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                >
            </div>
            <div>
                <label class="block text-gray-600 mb-2" for="parent">Тип характеристики</label>
                <select
                    id="parent"
                    v-model="paramForm.filter_type"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                >
                    <option :value="null" disabled>Выберите характеристику</option>
                    <option :value="filter.value" :key="filter.value" v-for="filter in filterTypes">{{ filter.name }}</option>
                </select>
            </div>
            <div class="mt-4">
                <button
                    @click.prevent="updateParam"
                    class="cursor-pointer w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-300"
                >
                    Обновить
                </button>
            </div>
            <Link
                :href="route('admin.params.index')"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-300"
            >
                Назад
            </Link>
        </div>
    </AdminLayout>
</template>

<style scoped></style>
