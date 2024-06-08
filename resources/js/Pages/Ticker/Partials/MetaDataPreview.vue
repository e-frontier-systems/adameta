<script setup>

defineProps({
  'metadata': Object
});

</script>

<template>
  <div class="w-full p-4 bg-white border border-gray-200 rounded">
      <div class="mb-4 text-gray-600 text-xs">更新日：{{ metadata.updated_at }}</div>
      <pre class="block text-sm">{{ metadata.json }}</pre>
  </div>
</template>
