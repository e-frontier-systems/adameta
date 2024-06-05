<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";

const form = useForm({
    name: '',
    description: '',
});
</script>

<template>
    <div>
      <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
        <ApplicationLogo class="block h-12 w-auto" />

        <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
          登録ティッカー名一覧
        </h1>

        <p class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
          Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application. Laravel is designed
          to help you build your application using a development environment that is simple, powerful, and enjoyable. We believe
          you should love expressing your creativity through programming, so we have spent time carefully crafting the Laravel
          ecosystem to be a breath of fresh air. We hope you love it.
        </p>
      </div>

      <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">

        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
          <form @submit.prevent="form.post(route('ticker.store'), { onSuccess: () => form.reset() })">
            <input v-model="form.name"
                   placeholder="ティカー名"
                   class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
            <textarea v-model="form.description"
                      placeholder="説明・メモ"
                      class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
            <InputError :message="form.errors.message" class="mt-2" />
            <PrimaryButton class="mt-4">登録</PrimaryButton>
          </form>
          {{ $page.props.auth.user.latestedTicker }}
        </div>
      </div>

    </div>
</template>
