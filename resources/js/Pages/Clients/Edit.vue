<script setup>
import { computed, onMounted } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link, useForm, usePage } from '@inertiajs/vue3';

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    client: {
        type: Object
    },

    image: {
        type: String,
    },

    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const currentClient = props.client;

const form = useForm({
    firstname: currentClient.firstname,
    lastname: currentClient.lastname,
    email: currentClient.email,
    avatar: currentClient.avatar,
    fileSizeError: false
});

const hasAvatar = computed(() => {
    if (form.avatar instanceof String) {
        return form.avatar.includes('storage/path/public/') ? false : true;
    }
})

// check file size to not exceed 2mb
const checkSize = (currFile) => {
    const fileLimit = 2048; // limit the file size goes here
    const fileSize = currFile.size; 
    const fileSizeInKB = (fileSize/1024); // this would be converted byte into kilobyte

    if (fileSizeInKB < fileLimit){
        form.avatar = currFile;
        form.fileSizeError = false;
    } else {
        form.fileSizeError = true;
        document.getElementById('avatarUrl').value = null;
    }
}

const submit = () => {
    form.post(route('clients.update', {id: props.client.id}));
};
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Clients Edit
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
                        <template v-if="hasAvatar">
                            <InputLabel for="avatar" value="Avatar" />
    
                            <img :src="`storage/avatars/${form.avatar}`" width="100" height="100"/>
                        </template>

                        <InputLabel for="avatar" value="Choose new avatar" />

                        <input id="avatarUrl" type="file" class="form-control form-control-xl pt-1" accept="image/*" @change="checkSize($event.target.files[0])">

                        <InputError v-if="form.fileSizeError" class="mt-2" message="File is too big, select smaller one"/>

                        <InputError class="mt-2" :message="form.errors.avatar" />
                    </div>

                    <div class="mt-4 flex">
                        <PrimaryButton
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Update
                        </PrimaryButton>
                        
                        <Link
                            :href="route('clients.list')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            as="button"
                        >
                            Back
                        </Link>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p
                                v-if="form.recentlySuccessful"
                                class="text-sm text-gray-600"
                            >
                                Saved.
                            </p>
                        </Transition>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>