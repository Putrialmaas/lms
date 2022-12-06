<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const nameInput = ref(null);
const addressInput = ref(null);

const form = useForm({
    name: null,
    address: null,
});

const storeData = () => {
    form.post(route("libraries.store"), {
        errorBag: "storeData",
        preserveScroll: true,
        onError: () => {
            if (form.errors.name) {
                form.reset("name");
                nameInput.value.focus();
            }
            if (form.errors.address) {
                form.reset("address");
                addressInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <AppLayout title="Libraries">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Libraries Management
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="storeData()">
                <template #title>Add Library</template>

                <template #description>
                    Add a new library data to database.
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="Library Name" />
                        <TextInput
                            id="name"
                            ref="nameInput"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="address" value="Library Address" />
                        <TextInput id="address" ref="addressInput" v-model="form.address" type="text"
                            class="mt-1 block w-full" />
                        <InputError :message="form.errors.address" class="mt-2" />
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