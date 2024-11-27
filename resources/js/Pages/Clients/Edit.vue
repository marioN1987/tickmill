<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
// import DeleteUserForm from './Partials/DeleteUserForm.vue';
// import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
// import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
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
    avatar: ''
});

const submit = () => {
    console.log(form);

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
                        <InputLabel for="avatar" value="Avatar" />

                        <img :src="image" width="100" height="100"/>

                        <InputLabel class="pt-4" for="avatar" value="Choose new avatar" />

                        <input id="avatarUrl" type="file" class="form-control form-control-xl pt-1" accept="image/*" @change="form.avatar = $event.target.files[0]">

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

<!-- <template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Profile Information
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        {{ client }}

        <form
            @submit.prevent="form.patch(route('profile.edit'))"
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
                    autofocus
                    autocomplete="name"
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
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
        </form>
    </section>
</template> -->