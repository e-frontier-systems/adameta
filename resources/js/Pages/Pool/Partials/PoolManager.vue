<script setup>
import { ref } from "vue";
import { router, useForm} from "@inertiajs/vue3";
import SectionBorder from "@/Components/SectionBorder.vue";
import ActionSection from '@/Components/ActionSection.vue';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import FormSection from "@/Components/FormSection.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    pools: Array,
})

const createTickerForm = useForm({
    name: '',
    description: '',
});

const deleteTickerForm = useForm({});

const tickerBeginDeleted = ref(null);
const deleteTicker = () => {
    deleteTickerForm.delete(route('api.ticker.destroy', tickerBeginDeleted.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (tickerBeginDeleted.value = null),
    });
};

const gotoPoolMetadata = (pool) => {
    router.get(route('ticker'));
}

const confirmTickerDeletion = (pool) => {
    tickerBeginDeleted.value = pool;
};

const displayingToken = ref(false);

const createTicker = () => {
    createTickerForm.post(route('api.ticker.store'), {
        preserveScroll: true,
        onSuccess: () => {
            displayingToken.value = true;
            createTickerForm.reset();
        },
    });
};

</script>

<template>
    <div>
        <ActionSection>
            <template #title>
                プール一覧
            </template>

            <template #description>
                登録されているプール一覧
            </template>

            <template #content>
                <div class="space-y-6">
                    <div v-if="pools.length <= 0" class="dark:text-white">
                        プールは登録されていません。
                    </div>
                    <div v-for="pool in pools" :key="pool.id">
                        <div class="flex items-center justify-between">
                            <div class="break-all dark:text-white">
                                {{ pool.name }}
                            </div>

                            <div class="flex items-center ms-2">

                                <button class="cursor-pointer ms-6 text-sm text-gray-400" @click="gotoPoolMetadata(pool)">
                                    メタデータ
                                </button>

                                <button class="cursor-pointer ms-6 text-sm text-red-500" @click="confirmTickerDeletion(pool)">
                                    削除
                                </button>
                            </div>
                        </div>

                        <div class="break-all dark:text-white text-xs text-gray-500">
                            {{ pool.description }}
                        </div>
                    </div>
                </div>
            </template>

        </ActionSection>

        <ConfirmationModal :show="tickerBeginDeleted != null" @close="tickerBeginDeleted = null">
            <template #title>
                プール情報を削除
            </template>

            <template #content>
                本当にこのプール情報を削除してもよろしいですか？
            </template>

            <template #footer>
                <SecondaryButton @click="tickerBeginDeleted = null">
                    キャンセル
                </SecondaryButton>

                <DangerButton class="ms-3" :class="{ 'opacity-25': deleteTickerForm.processing }"
                              :disabled="deleteTickerForm.processing"
                              @click="deleteTicker"
                >
                    削除
                </DangerButton>
            </template>
        </ConfirmationModal>

    </div>

    <div class="mt-10 sm:mt-0">
        <SectionBorder />

        <FormSection @submitted="createTicker">

            <template #title>
                新しいプール
            </template>

            <template #description>
                複数のプール情報を登録することが出来ます
            </template>

            <template #form>

                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="ticker" value="ティッカー" />
                    <TextInput
                        id="ticker"
                        v-model="createTickerForm.name"
                        type="text"
                        class="mt-1 block w-full"
                        autofocus
                    />
                    <InputError :message="createTickerForm.errors.name" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="description" value="備考" />
                    <TextInput
                        id="description"
                        v-model="createTickerForm.description"
                        type="text"
                        class="mt-1 block w-full"
                    />
                </div>

            </template>

            <template #actions>
                <ActionMessage :on="createTickerForm.recentlySuccessful" class="mt-3">
                    登録しました
                </ActionMessage>

                <PrimaryButton :class="{ 'opacity-25': createTickerForm.processing }" :disabled="createTickerForm.processing">
                    登録
                </PrimaryButton>
            </template>
        </FormSection>

    </div>
</template>
