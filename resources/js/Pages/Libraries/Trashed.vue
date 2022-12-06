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
    trashed_libraries: Object
});
</script>

<template>
    <AppLayout title="libraries">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trashed Libraries
            </h2>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-blue-200 overflow-hidden shadow-xl sm:rounded-lg mt-8">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full text-center">
                                        <thead class="bg-blue-200 border-b">
                                            <tr>
                                                <th scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left">
                                                    ID
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left">
                                                    Library Name
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left">
                                                    Library Address
                                                </th>                                                
                                                <th scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-blue-100 border-b transition duration-300 ease-in-out hover:bg-blue-200"
                                                v-if="(trashed_libraries.length > 0)" v-for="trashed_library in trashed_libraries"
                                                :key="trashed_library.id">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ trashed_library.id }}
                                                </td>                                                
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ trashed_library.name }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ trashed_library.address }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    <Link :href="
                                                        route(
                                                            'libraries.restore',
                                                            trashed_library.id
                                                        )
                                                    ">
                                                    <PrimaryButton>
                                                        Restore
                                                    </PrimaryButton>
                                                    </Link>
                                                    <Link :href="route
                                                    (
                                                        'libraries.destroy_permanent',
                                                        trashed_library.id
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
                                                <td colspan="4"
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