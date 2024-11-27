<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
// import DeleteUserForm from './Partials/DeleteUserForm.vue';
// import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
// import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    allClients: {
        type: Array
    },
    status: {
        type: String,
    },
});

</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Clients list
            </h2>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-wrap gap-6">
                <div class="user" v-for="user in allClients">
                    <p>Name: {{ user.firstname + ' ' + user.lastname}}</p>
                    <p>Email: {{ user.email }}</p>
                    <div class="actions flex gap-12">
                        <Link
                            :href="route('clients.edit', {id: user.id})"
                            as="button"
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Edit
                        </Link>
    
                        <Link
                            :href="route('clients.delete', {id: user.id})"
                            method="DELETE"
                            as="button"
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Delete
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
