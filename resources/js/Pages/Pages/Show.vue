<template>
  <Head>
    <title>Pages</title>
  </Head>

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ page.title }} [{{ decodeURI(page.url) }}]
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-none mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <div class="mb-2">
            <Link :href="route('pages.id.dumps.index', page.id)">
              <PrimaryButton>Dumps</PrimaryButton>
            </link>
          </div>

          <List :pages="page.children"/>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import {Head, Link} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import List from "@/Pages/Pages/Components/List.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
  page: {
    type: Object,
    required: true,
    default: {
      title: null,
      url: null,
      children: []
    }
  },
});
</script>

<style scoped>

</style>
