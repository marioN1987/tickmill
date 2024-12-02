<script setup>
import { computed } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    firstname: '',
    lastname: '',
    email: '',
    avatar: '',
    password: '',
    previewImg: null,
    fileSizeError: false,
    password_confirmation: '',
});

// replace existing avatar and preview uploaded one
const previewUploadedImg = (uploadedFile) => {
    const reader = new FileReader();
    reader.onload = () => {
        form.previewImg = reader.result;
    };

    reader.readAsDataURL(uploadedFile);
};

// check file size to not exceed 2mb
const checkSize = (currFile) => {
    const fileLimit = 2048;
    const fileSize = currFile.size; 
    const fileSizeInKB = (fileSize/1024); // convert byte into kilobyte

    if (fileSizeInKB < fileLimit){
        form.avatar = currFile;
        form.fileSizeError = false;
        previewUploadedImg(currFile);
    } else {
        form.fileSizeError = true;
        form.previewImg = null;
        document.getElementById('avatarUrl').value = null;
    }
}

const isFormValid = computed(() => !form.fileSizeError || !Object.keys(form.errors).length > 0);

const submit = () => {
    form.post(route('clients.store'));
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Clients Create
            </h2>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <form
                    @submit.prevent="submit"
                    class="mt-6 space-y-6"
                >
                    <div>
                        <InputLabel for="firstname" value="Firstname" />

                        <TextInput
                            id="firstname"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.firstname"
                            required
                            autofocus
                            autocomplete="name"
                        />

                        <InputError class="mt-2" :message="form.errors.firstname" />
                    </div>

                    <div>
                        <InputLabel for="lastname" value="Lastname" />

                        <TextInput
                            id="lastname"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.lastname"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.lastname" />
                    </div>

                    <div>
                        <InputLabel for="email" value="Email" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>

                        <template v-if="form.previewImg">
                            <InputLabel for="avatar" value="Avatar" />
    
                            <img :src="form.previewImg" width="100" height="100"/>
                        </template>

                        <InputLabel class="pt-2" for="avatar" value="Upload new avatar" />

                        <input id="avatarUrl" type="file" class="form-control form-control-xl pt-1" accept="image/*" @change="checkSize($event.target.files[0])">

                        <InputError v-if="form.fileSizeError" class="mt-2" message="File is too big, select smaller one"/>

                        <InputError v-else-if="!form.avatar" class="mt-2" :message="form.errors.avatar" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Password" />

                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                        />

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mt-4">
                        <InputLabel
                            for="password_confirmation"
                            value="Confirm Password"
                        />

                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.password_confirmation"
                        />
                    </div>

                    <div class="mt-4 flex">
                        <PrimaryButton
                            :disabled="!isFormValid"
                        >
                            Create
                        </PrimaryButton>
                        
                        <Link
                            :href="route('clients.list')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            as="button"
                        >
                            Back
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>