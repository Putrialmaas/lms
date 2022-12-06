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

const form = useForm({
    name: null,
});

const updateData = (publisher) => {
    form.name = publisher.name;
    form.put(route("publishers.update", publisher.id), {
        errorBag: "updateData",
        preserveScroll: true,
        onError: () => {
            if (form.errors.name) {
                form.reset("name");
                nameInput.value.focus();
            }
        },
    });
};

defineProps({
    publisher: Object,
});
</script>

<template>
    <AppLayout title="Publishers">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Publishers Management
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="updateData(publisher)">
                <template #title>Edit Publisher</template>

                <template #description>
                    Edit a publisher data.
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="Book Publisher" />
                        <TextInput id="name" ref="nameInput" v-model="publisher.name" type="text"
                            class="mt-1 block w-full" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>                    
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                        Saved.
                    </ActionMessage>

                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>