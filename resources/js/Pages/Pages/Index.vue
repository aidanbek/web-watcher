<template>
    <Head>
        <title>Pages</title>
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pages</h2>
        </template>

        <div class="py-12">
            <div class="max-w-none mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <List :pages="pages" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import List from "@/Pages/Pages/Components/List.vue";

defineProps({
    pages: {
        type: Array,
    },
});
</script>

<style scoped>

</style>
