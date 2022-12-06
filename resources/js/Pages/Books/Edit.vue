<script setup>
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const libraryInput = ref(null);
const publisherInput = ref(null);
const categoryInput = ref(null);
const titleInput = ref(null);
const yearInput = ref(null);
const library = ref(null);
const publisher = ref(null);
const category = ref(null);

const form = useForm({
    library: null,
    publisher: null,
    category: null,
    title: null,
    year: null,
});

const updateData = (book) => {
    form.library = library.value ? library.value.id : book.library_id;
    form.publisher = publisher.value ? publisher.value.id : book.publisher_id;
    form.category = category.value ? category.value.id : book.category_id;
    form.title = book.title;
    form.year = book.year;
    form.put(route("books.update", book.id), {
        errorBag: "updateData",
        preserveScroll: true,
        onError: () => {
            if (form.errors.library) {
                form.reset("library");
                libraryInput.value.focus();
            }
            if (form.errors.publisher) {
                form.reset("publisher");
                publisherInput.value.focus();
            }
            if (form.errors.category) {
                form.reset("category");
                categoryInput.value.focus();
            }
            if (form.errors.title) {
                form.reset("title");
                titleInput.value.focus();
            }
            if (form.errors.year) {
                form.reset("year");
                yearInput.value.focus();
            }

        },
    });
};

const chooseLibrary = (bookLibrary) => {
    library.value = bookLibrary;
};

const choosePublisher = (bookPublisher) => {
    publisher.value = bookPublisher;
};

const chooseCategory = (bookCategory) => {
    category.value = bookCategory;
};

defineProps({
    libraries: Object,
    publishers: Object,
    categories: Object,
    book: Object,
});

</script>

<template>
    <AppLayout title="Books">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                Books Management
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="updateData(book)">
                <template #title>Edit Book</template>

                <template #description> Edit a book category data. </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="library" value="Book Library" />
                        <div class="dropdown relative mt-2 w-full">
                            <button ref="libraryInput"
                                class="dropdown-toggle w-full px-6 py-3 bg-blue-400 text-gray-800 font-medium text-sm leading-tight capitalize rounded shadow-md hover:bg-blue-600 hover:shadow-lg focus:bg-blue-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-400 active:shadow-lg active:shadow-lg transition duration-150 ease-in-out flex items-center whitespace-nowrap"
                                type="button" 
                                id="library" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                                {{
                                    library ? library.name : book.library_name
                                }}                                
                                <div class="w-full flex justify-end">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down"
                                        class="w-2 ml-2" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 320 512">
                                        <path fill="currentColor"
                                            d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z">
                                        </path>
                                    </svg>
                                </div>
                            </button>
                            <ul class="dropdown-menu min-w-max absolute w-full bg-white text-base z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 hidden m-0 bg-clip-padding border-none"
                                aria-labelledby="dropdown_library">
                                <li class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                    v-for="library in libraries" 
                                    @click="chooseLibrary(library)">
                                    {{ library.name }}
                                </li>
                            </ul>
                        </div>
                        <InputError :message="form.errors.library" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="publisher" value="Book Publisher" />
                        <div class="dropdown relative mt-2 w-full">
                            <button ref="publisherInput"
                                class="dropdown-toggle w-full px-6 py-3 bg-blue-400 text-gray-800 font-medium text-sm leading-tight capitalize rounded shadow-md hover:bg-blue-600 hover:shadow-lg focus:bg-blue-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-400 active:shadow-lg active:shadow-lg transition duration-150 ease-in-out flex items-center whitespace-nowrap"
                                type="button" 
                                id="publisher" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                                {{
                                    publisher ? publisher.name : book.publisher_name
                                }}                                
                                <div class="w-full flex justify-end">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down"
                                        class="w-2 ml-2" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 320 512">
                                        <path fill="currentColor"
                                            d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z">
                                        </path>
                                    </svg>
                                </div>
                            </button>
                            <ul class="dropdown-menu min-w-max absolute w-full bg-white text-base z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 hidden m-0 bg-clip-padding border-none"
                                aria-labelledby="dropdown_publisher">
                                <li class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                    v-for="publisher in publishers" 
                                    @click="choosePublisher(publisher)">
                                    {{ publisher.name }}
                                </li>
                            </ul>
                        </div>
                        <InputError :message="form.errors.publisher" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="category" value="Book Category" />
                        <div class="dropdown relative mt-2 w-full">
                            <button ref="categoryInput"
                                class="dropdown-toggle w-full px-6 py-3 bg-blue-400 text-gray-800 font-medium text-sm leading-tight capitalize rounded shadow-md hover:bg-blue-600 hover:shadow-lg focus:bg-blue-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-400 active:shadow-lg active:shadow-lg transition duration-150 ease-in-out flex items-center whitespace-nowrap"
                                type="button" 
                                id="category" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                                {{
                                    category ? category.name : book.category_name
                                }}                                
                                <div class="w-full flex justify-end">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down"
                                        class="w-2 ml-2" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 320 512">
                                        <path fill="currentColor"
                                            d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z">
                                        </path>
                                    </svg>
                                </div>
                            </button>
                            <ul class="dropdown-menu min-w-max absolute w-full bg-white text-base z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 hidden m-0 bg-clip-padding border-none"
                                aria-labelledby="dropdown_category">
                                <li class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                    v-for="category in categories" 
                                    @click="chooseCategory(category)">
                                    {{ category.name }}
                                </li>
                            </ul>
                        </div>
                        <InputError :message="form.errors.category" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="title" value="Book Title" />
                        <TextInput id="title" ref="titleInput" v-model="book.title" type="text"
                            class="mt-1 block w-full" />
                        <InputError :message="form.errors.title" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="year" value="Book Year" />
                        <TextInput id="year" ref="yearInput" v-model="book.year" type="text"
                            class="mt-1 block w-full" />
                        <InputError :message="form.errors.year" class="mt-2" />
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                        Saved.
                    </ActionMessage>

                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Save
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>