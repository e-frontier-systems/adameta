<script setup>
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import FormSection from "@/Components/FormSection.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    ticker: Object,
});

const form = useForm({
  _method: 'POST',
  ticker_id: null,
  json: null,
});

const selectedTicker = ref(null);
const jsonPreview = ref(null);
const jsonInput = ref(null);


const selectNewMetadata = () => {
    jsonInput.value.click();
};

const updateMetadataPreview = () => {
  const json = jsonInput.value.files[0];

  if (! json) return;

  const reader = new FileReader();

  reader.onload = (e) => {
    jsonPreview.value = e.target.result;
  }

  reader.readAsText(json);
};


const uploadMetadata = () => {
  form.ticker_id = props.ticker.id;
  if (jsonInput.value) {
    form.json = jsonPreview.value;
  }

  form.post(route('ticker-metadata.update'), {
    errorBag: 'uploadMetadata',
    preserveScroll: true,
    onSuccess: () => clearMetadataFileInput(),
  })
};

const clearMetadataFileInput = () => {
  if (jsonInput.value?.value) {
    jsonInput.value.value = null;
  }
};

</script>

<template>
  <div>
    <form @submit.prevent="uploadMetadata">
      <div class="col-span-6">
        <input id="metadata"
               ref="jsonInput"
               type="file"
               accept="application/json"
               class="hidden"
               @change="updateMetadataPreview"
        >

        <div>
          <SecondaryButton class="mt-4 me-2" type="button" @click.prevent="selectNewMetadata">
            新しいメタデータをアップロード
          </SecondaryButton>
        </div>
      </div>

      <div class="mt-4">
        <div v-show="jsonPreview" class="block p-4 bg-white border border-gray-300 rounded">
          <div class="mb-4 text-gray-600 text-xs">プレビュー</div>
          <pre class="block text-sm">{{ jsonPreview }}</pre>
        </div>
        <InputError :message="form.errors.json" class="mt-2" />
      </div>

      <div v-show="jsonPreview" class="flex flex-row">
        <ActionMessage :on="form.recentlySuccessful" class="me-3 flex-1">
          保存しました
        </ActionMessage>
        <primary-button :class="{ 'opacity-25': form.processing }" class="mt-4" :disabled="form.processing">
          保存
        </primary-button>
      </div>
    </form>
  </div>
</template>
