<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm, } from '@inertiajs/vue3';
import OperationsTable from "@/components/wallet/OperationsTable.vue";
import { onBeforeUnmount } from "vue"

const form = useForm({})

const props = defineProps({
    wallet: {
        type: Object,
        default: () => ({}),
    },
    operationsPaginated: {
        type: Object,
        default: () => ({})
    }
})

const fetchOperations = async () => {
    await form.get(route('dashboard'))
}

const interval = setInterval(fetchOperations, 5000);

onBeforeUnmount(() => {
    clearInterval(interval)
})

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between">
                            <p>Текущий баланс: {{ wallet.currentBalance }}</p>
                            <p>
                                <Link
                                    :href="route('wallet.index')"
                                    class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                >Список операций</Link>
                            </p>
                        </div>
                    </div>

                    <div>
                        <OperationsTable :operations-paginated="operationsPaginated"></OperationsTable>
                    </div>
                </div>
            </div>
        </div>



    </AuthenticatedLayout>
</template>
