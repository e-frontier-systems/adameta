<template>
  <div class="hidden sm:flex sm:items-center sm:ms-6">
  <div class="ms-3">
      <Dropdown width="38">
        <template #trigger>
          <span class="inline-flex rounded-md">
            <button type="button" class="inline-flex items-center px-3 py-2 border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover-gray-700 transition text-sm">
              テーマ
              <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
              </svg>
            </button>
          </span>
        </template>
        <template #content>
          <div class="block px-4 py-2 text-xs text-gray-500 dark:text-gray-400">
        <button @click="onchange('system')" class="block">
          システム
        </button>
          </div>
          <div class="block px-4 py-2 text-xs text-gray-500">
        <button @click="onchange('light')" class="block">
          ライト
        </button>
          </div>
          <div class="block px-4 py-2 text-xs text-gray-500">
        <button @click="onchange('dark')" class="block">
          ダーク
        </button>
          </div>
        </template>
      </Dropdown>
  </div>
  </div>

<!--  <select @value="{theme}" @change="onchange">-->
<!--    <option value="system">System</option>-->
<!--    <option value="light">Light</option>-->
<!--    <option value="dark">Dark</option>-->
<!--  </select>-->
</template>

<script>
import { useState } from 'use-state-vue';
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

// OS の設定が変更された際に実行されるコールバック関数
const mediaQueryListener = (e) => {
  if (localStorage.theme === 'system') {
    if (e.matches) {
      document.documentElement.classList.add('dark')
    } else {
      document.documentElement.classList.remove('dark')
    }
  }
}
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', mediaQueryListener)


const [theme, setTheme] = useState(localStorage.theme || 'system');

export default {
  name: 'DarkModeSwitch',
  components: {DropdownLink, Dropdown},
  methods: {
    theme() {
      return theme
    },
    onchange(e) {
      const theme = e; //.target.value;
      setTheme(theme);
      localStorage.setItem('theme', theme);
      if (theme === 'dark') {
        document.documentElement.classList.add('dark');
      } else if (theme === 'light') {
        document.documentElement.classList.remove('dark');
      } else {
        document.documentElement.classList.toggle('dark', window.matchMedia('(prefers-color-scheme: dark)').matches)
      }
    },
  },
};

</script>

