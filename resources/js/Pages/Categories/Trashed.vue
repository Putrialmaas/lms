<script setup>
import { defineComponent } from 'vue';
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineComponent({
    AppLayout,
    PrimaryButton,
    DangerButton,
});

defineProps({
    trashed_categories: Object
});
</script>

<template>
    <AppLayout title="books">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trashed Categories
            </h2>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-blue-200 overflow-hidden shadow-xl sm:rounded-lg mt-8">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full">
                                        <thead class="bg-blue-200 border-b">
                                            <tr>
                                                <th scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left">
                                                    ID
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left">
                                                    Book Category
                                                </th>                                                                                               
                                                <th scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-blue-100 border-b transition duration-300 ease-in-out hover:bg-blue-200"
                                                v-if="(trashed_categories.length > 0)" v-for="trashed_category in trashed_categories"
                                                :key="trashed_category.id">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ trashed_category.id }}
                                                </td>                                                
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ trashed_category.name }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    <Link :href="
                                                        route(
                                                            'categories.restore',
                                                            trashed_category.id
                                                        )
                                                    ">
                                                    <PrimaryButton>
                                                        Restore
                                                    </PrimaryButton>
                                                    </Link>
                                                    <Link :href="route
                                                    (
                                                        'categories.destroy_permanent',
                                                        trashed_category.id
                                                    )
                                                    ">
                                                    <DangerButton class="ml-4">
                                                        Permanently Delete
                                                    </DangerButton>
                                                    </Link>
                                                </td>
                                            </tr>
                                            <tr class="bg-blue-100 border-b transition duration-300 ease-in-out hover:bg-blue-200"
                                                v-else>
                                                <td colspan="6"
                                                    class="text-sm text-center text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    There is no trashed data available
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>