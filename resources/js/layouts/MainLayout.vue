<script setup lang="ts">

import { Link, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;
</script>

<template>

    <section class="w-full p-5 border-b border-gray-100">
        <header class="w-2/3 mx-auto">
            <div class="flex justify-between">
                <div>
                    <h1>Market Panel</h1>
                </div>
                <div class="flex items-center gap-2">
                    <div class="text-lg">{{ user ? user.carts_total_sum : '' }}</div>
                    <Link :href="route('client.carts.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hover:text-red-500 cursor-pointer size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </Link>
                </div>
            </div>
        </header>
    </section>

    <section class="flex">
        <slot/>
    </section>

    <section>
        <footer></footer>
    </section>

</template>

<style scoped>

</style>
