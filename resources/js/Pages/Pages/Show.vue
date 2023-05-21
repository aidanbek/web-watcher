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
                  <div>
                    <iframe ref="preview" class="w-full" :srcdoc="page.last_dump?.raw_html" />
                  </div>
                  <List :pages="page.children" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import List from "@/Pages/Pages/Components/List.vue";
import {onMounted, ref} from "vue";

const props = defineProps({
    page: {
        type: Object,
    },
});

const preview = ref();

onMounted(() => {
  const iframeDocument = preview.value.contentDocument || preview.value.contentWindow.document;
  const url = (new URL( props.page.url)).origin;

  const base = iframeDocument.createElement('base');
  base.setAttribute('href', url);

  console.log({
    base,
    url,
  });

  iframeDocument.head.appendChild(base);
})
</script>

<style scoped>

</style>
