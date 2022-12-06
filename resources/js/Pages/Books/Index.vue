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
    books: Object
});

const onSearch = (search) => {
    location.href = `/books?search=${search}`;
}
onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    const searchQuery = params.get('search');
    search.value = searchQuery;
});
</script>

<template>
    <AppLayout title="Books">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Book Management
            </h2>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex">
                    <div class="w-1/2">
                        <Link :href="route('books.create')">
                        <PrimaryButton>
                            Add New Book
                        </PrimaryButton>
                        </Link>
                        <Link :href="route('books.trashed')">
                        <PrimaryButton class="ml-4">
                            Trashed Book
                        </PrimaryButton>
                        </Link>
                    </div>
                    <div class="w-1/2">
                        <TextInput id="search" type="text" class="block w-full" placeholder="Search Books..."
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
                                                    Book Title
                                                </th>
                                                <th scope="col" class="text-sm font-bold text-gray-900 px-6 py-4">
                                                    Book Library
                                                </th>
                                                <th scope="col" class="text-sm font-bold text-gray-900 px-6 py-4">
                                                    Book Publisher
                                                </th>
                                                <th scope="col" class="text-sm font-bold text-gray-900 px-6 py-4">
                                                    Book Category
                                                </th>
                                                <th scope="col" class="text-sm font-bold text-gray-900 px-6 py-4">
                                                    Year
                                                </th>
                                                <th scope="col" class="text-sm font-bold text-gray-900 px-6 py-4">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-blue-100 border-b transition duration-300 ease-in-out hover:bg-blue-200"
                                                v-if="(books.length > 0)" v-for="book in books" :key="book.id">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ book.id }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ book.title }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ book.library_name }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ book.publisher_name }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ book.category_name }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ book.year }}
                                                </td>
                                                <td
                                                class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                <Link :href="
                                                        route(
                                                            'books.edit',
                                                            book.id
                                                        )
                                                    ">
                                                    <PrimaryButton>
                                                        Edit
                                                    </PrimaryButton>
                                                    </Link>
                                                    <Link :href="
                                                        route(
                                                            'books.destroy',
                                                            book.id
                                                        )
                                                    ">
                                                    <DangerButton class="ml-4">
                                                        Remove
                                                    </DangerButton>
                                                    </Link>
                                                </td>
                                            </tr>
                                            <tr class="bg-blue-100 border-b transition duration-300 ease-in-out hover:bg-blue-200"
                                                v-else>
                                                <td colspan="7"
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
