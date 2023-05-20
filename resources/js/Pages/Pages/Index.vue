<template>
    <Head>
        <title>Pages</title>
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pages</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <table class="table-auto border-collapse border">
                        <thead>
                        <tr>
                            <th class="border">URL</th>
                            <th class="border">Title</th>
                            <th class="border">Count</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="page in pages">
                            <td class="border">
                                <Link :href="route('pages.show', page.id)"> {{ decodeURI(page.url) }}</Link>
                            </td>
                            <td class="border">
                                {{ page.title }}
                            </td>
                            <td class="border text-center">
                                {{ page.children_count }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    pages: {
        type: Array,
    },
});
</script>

<style scoped>

</style>
