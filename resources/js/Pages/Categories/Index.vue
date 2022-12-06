<script setup>
import { ref, defineComponent, onMounted } from 'vue';
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from "@/Components/TextInput.vue";

const search = ref(null);
defineComponent({
    AppLayout,
    PrimaryButton,
    DangerButton,
});
defineProps({
    categories: Object
});

const onSearch = (search) => {
    location.href = `/categories?search=${search}`;
}
onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    const searchQuery = params.get('search');
    search.value = searchQuery;
});
</script>

<template>
    <AppLayout title="Category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Category
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex">
                    <div class="w-1/2">
                        <Link :href="route('categories.create')">
                        <PrimaryButton>
                            Add New Category
                        </PrimaryButton>
                        </Link>
                        <Link :href="route('categories.trashed')">
                        <PrimaryButton class="ml-4">
                            Trashed Category
                        </PrimaryButton>
                        </Link>
                    </div>
                    <div class="w-1/2">
                        <TextInput id="search" type="text" class="block w-full" placeholder="Search Categories..."
                            v-model="search" @keyup.enter="onSearch(search)" />
                    </div>
                </div>
                <div class="bg-blue-200 overflow-hidden shadow-xl sm:rounded-lg mt-8">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full text-center">
                                        <thead class="border-b bg-blue-200">
                                            <tr>
                                                <th scope="col" class="text-sm font-bold text-gray-900 px-6 py-4">
                                                    ID
                                                </th>
                                                <th scope="col" class="text-sm font-bold text-gray-900 px-6 py-4">
                                                    Book Category
                                                </th>
                                                <th scope="col" class="text-sm font-bold text-gray-900 px-6 py-4">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-blue-100 border-b transition duration-300 ease-in-out hover:bg-blue-200"
                                                v-if="(categories.length > 0)" v-for="category in categories" :key="category.id">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ category.id }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ category.name }}
                                                </td>                                                
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    <Link :href="
                                                        route(
                                                            'categories.edit',
                                                            category.id
                                                        )
                                                    ">
                                                    <PrimaryButton>
                                                        Edit
                                                    </PrimaryButton>
                                                    </Link>
                                                    <Link :href="
                                                        route(
                                                            'categories.destroy',
                                                            category.id
                                                        )
                                                    ">
                                                    <DangerButton class="ml-4">
                                                        Delete
                                                    </DangerButton>
                                                    </Link>
                                                </td>
                                            </tr>
                                            <tr class="bg-blue-100 border-b transition duration-300 ease-in-out hover:bg-blue-200"
                                                v-else>
                                                <td colspan="4"
                                                    class="text-sm text-center text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    There is no data available
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
