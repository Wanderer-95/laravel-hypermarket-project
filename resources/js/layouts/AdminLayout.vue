<script setup lang="ts">

import { Link } from '@inertiajs/vue3';
</script>

<template>

    <section class="w-full p-5 border-b border-gray-100">
        <header>
            Market Admin
        </header>
    </section>

    <section class="flex">
        <aside class="w-1/4 bg-gray-800 min-h-screen">
            <nav class="bg-gray-800 rounded-lg overflow-hidden">
                <Link
                    :href="route('dashboard')"
                    class="relative block p-4 text-gray-300 border-b border-gray-700 hover:text-white transition-colors duration-300 ease-in-out group"
                >
                    Дашборд
                    <span
                        class="absolute left-0 bottom-0 h-0.5 w-0 bg-blue-500 transition-all duration-300 ease-in-out group-hover:w-full"
                    ></span>
                </Link>

                <Link
                    :href="route('admin.product-groups.index')"
                    class="relative block p-4 text-gray-300 border-b border-gray-700 hover:text-white transition-colors duration-300 ease-in-out group"
                >
                    Группа продуктов
                    <span
                        class="absolute left-0 bottom-0 h-0.5 w-0 bg-blue-500 transition-all duration-300 ease-in-out group-hover:w-full"
                    ></span>
                </Link>

                <Link
                    :href="route('admin.categories.index')"
                    class="relative block p-4 text-gray-300 border-b border-gray-700 hover:text-white transition-colors duration-300 ease-in-out group"
                >
                    Категории
                    <span
                        class="absolute left-0 bottom-0 h-0.5 w-0 bg-blue-500 transition-all duration-300 ease-in-out group-hover:w-full"
                    ></span>
                </Link>

                <Link
                    :href="route('admin.products.index')"
                    class="relative block p-4 text-gray-300 border-b border-gray-700 hover:text-white transition-colors duration-300 ease-in-out group"
                >
                    Продукты
                    <span
                        class="absolute left-0 bottom-0 h-0.5 w-0 bg-blue-500 transition-all duration-300 ease-in-out group-hover:w-full"
                    ></span>
                </Link>

                <Link
                    :href="route('admin.params.index')"
                    class="relative block p-4 text-gray-300 border-b border-gray-700 hover:text-white transition-colors duration-300 ease-in-out group"
                >
                    Характеристики
                    <span
                        class="absolute left-0 bottom-0 h-0.5 w-0 bg-blue-500 transition-all duration-300 ease-in-out group-hover:w-full"
                    ></span>
                </Link>
            </nav>

        </aside>

        <article class="p-4 w-3/4 bg-gray-100">
            <slot/>
        </article>
    </section>

    <section>
        <footer></footer>
    </section>

</template>

<style scoped>

</style>
