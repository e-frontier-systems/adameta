<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PoolManager from "@/Pages/Pool/Partials/PoolManager.vue"

export default {
    name: "Index.vue",
    components: {PoolManager, AppLayout}
}
</script>

<template>
    <AppLayout title="プール一覧">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                プール一覧
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <PoolManager />
            </div>
        </div>

    </AppLayout>
</template>
