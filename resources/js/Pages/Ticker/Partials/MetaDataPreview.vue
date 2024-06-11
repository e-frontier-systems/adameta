<script setup>
import hljs from 'highlight.js/lib/core';
import json from 'highlight.js/lib/languages/json';
import 'highlight.js/styles/vs2015.css';

hljs.registerLanguage('json', json);

defineProps({
  'metadata': Object
});
</script>

<script>
import hljsVuePlugin from '@highlightjs/vue-plugin';
export default {
  components: {
    highlightjs: hljsVuePlugin.component
  }
}
</script>

<template>
  <div class="w-full p-4 bg-white border border-gray-300 rounded">
      <div class="mb-4 text-gray-600 text-xs">更新日：{{ metadata.updated_at }}</div>
      <pre class="block text-sm"><highlightjs language="json" :code="metadata.json"></highlightjs></pre>
  </div>
</template>
