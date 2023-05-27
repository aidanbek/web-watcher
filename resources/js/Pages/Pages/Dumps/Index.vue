<template>
  <Head>
    <title>Dumps of {{ page.title }} [{{ decodeURI(page.url) }}]</title>
  </Head>

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dumps</h2>
    </template>

    <div class="py-12">
      <div class="max-w-none mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <table class="table-auto border-collapse border w-full">
            <thead>
            <tr>
              <th class="border">Created at</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="dump in dumps.data">
              <td class="border text-center whitespace-nowrap	">
                {{ DateTime.fromISO(dump.created_at).toFormat('dd.MM.yyyy HH:mm:ss') }}
              </td>
            </tr>
            </tbody>
          </table>
          <Pagination class="mt-6" :links="dumps.links"/>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import {Head} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import {onMounted} from "vue";
import {DateTime} from "luxon";

const props = defineProps({
  page: {
    type: Object,
  },
  dumps: {
    type: Array,
  },
});

onMounted(() => console.log(props.dumps))
</script>

<style scoped>

</style>