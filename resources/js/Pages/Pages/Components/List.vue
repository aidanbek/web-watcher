<template>
  <table class="table-auto border-collapse border w-full">
    <thead>
    <tr>
      <th class="border">Title</th>
      <th class="border">URL</th>
      <th class="border">Count</th>
      <th class="border">Last dump</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="page in pages">
      <td class="border">
        <Link :href="route('pages.show', page.id)">{{ page.title }}</Link>
      </td>
      <td class="border">
        <Link :href="route('pages.show', page.id)"> {{ decodeURI(page.url) }}</Link>
      </td>
      <td class="border text-center">
        {{ page.children_count }}
      </td>
      <td class="border text-center whitespace-nowrap	">
        {{ page.last_dump ? DateTime.fromISO(page.last_dump.created_at).toFormat('dd.MM.yyyy HH:mm:ss') : '-' }}
      </td>
    </tr>
    </tbody>
  </table>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import  {DateTime } from 'luxon'

const props = defineProps({
  pages: {
    type: Array,
    required: true,
    default: []
  },
});

</script>

<style scoped>

</style>