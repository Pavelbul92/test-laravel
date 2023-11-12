<script setup>
const props = defineProps({
    operationsPaginated: {
        type: Object,
        default: () => ({})
    }
})
</script>

<template>
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
            <th scope="col" class="px-6 py-3">
                Дата
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
</template>

<style scoped>

</style>
