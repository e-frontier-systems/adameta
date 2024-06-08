<script setup>
import {useForm} from "@inertiajs/vue3";
import MetaDataPreview from "@/Pages/Ticker/Partials/MetaDataPreview.vue";
import {ref, toRef} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import UpdateMetadataForm from "@/Pages/Ticker/Partials/UpdateMetadataForm.vue";

defineProps([
  'tickers'
])

const selectedTicker = ref(null);
const selectedMetadata = ref(null);

const changeTicker = (ticker) => {
  if (ticker) {
    selectedTicker.value = ticker;
    axios.get(route('get-by-ticker-id'), { params: { ticker_id: ticker.id } }).then(response => {
      selectedMetadata.value = response.data;
    });
  }
};

</script>

<template>
    <div>
      <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">

        <h1 class="text-2xl font-medium text-gray-900 dark:text-white">
          登録ティッカー名一覧
        </h1>

        <p class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
          複数のプールのメタデータを登録することができます。
        </p>
      </div>

      <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 flex gap-6 lg:gap-8 p-6 lg:p-8">

        <div class="mb-6 bg-white shadow-sm text-black block w-60 shrink">
          <select size="10" class="block w-full m-0 rounded-sm">
            <option v-for="ticker in tickers" data-id="{{ ticker.id }}" @click="changeTicker(ticker)" class="block h-full w-full py-2 px-2 antialiased hover:bg-gray-100/75 rounded-lg">
              {{ ticker.name }}
            </option>
          </select>
        </div>

        <div class="mx-auto flex-grow">
          <MetaDataPreview v-if="selectedMetadata" :metadata="selectedMetadata" />

          <div>
            <UpdateMetadataForm :ticker="selectedTicker" />
          </div>
        </div>
      </div>

    </div>
</template>
