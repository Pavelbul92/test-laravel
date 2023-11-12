<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link,  useForm} from '@inertiajs/vue3';
import {ref} from "vue";

const params = new URLSearchParams(window.location.search);
const formData = ref({
    sortBy: params.get('sortBy'),
    orderBy: params.get('orderBy'),
    filter: {
        search: params.get('filter') ?? null
    }
})

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

const sortColumn = (column) => {
    formData.value.orderBy = column;
    formData.value.sortBy = formData.value.sortBy === 'ASC' ? 'DESC' : 'ASC';
    fetchOperations()
}

const fetchOperations = async () => {
    const form = useForm(formData.value)
    await form.get(route('wallet.index'))
}

</script>

<template>
    <Head title="Список операций" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Список операций</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2">
                    <form @submit.prevent="fetchOperations">
                        <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input v-model="formData.filter.search" type="search" id="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Поиск по описанию">
                            <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Поиск</button>
                        </div>
                    </form>
                    </div>

                    <div>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    id
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Значение
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Описание
                                </th>
                                <th @click="sortColumn('created_at')" scope="col" class="px-6 py-3">
                                    Дата <span v-if="formData.sortBy === 'ASC'">⬆️</span> <span v-else>⬇️</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="operation in operationsPaginated.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ operation.id }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ operation.value }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ operation.description }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ operation.createdAt }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </AuthenticatedLayout>
</template>
