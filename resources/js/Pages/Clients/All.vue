<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    allClients: {
        type: [Object, Array]
    },
    status: {
        type: String,
    },
});

const hasAvatar = (filename) => {
    if (typeof filename === 'string' || filename instanceof String) {
        return filename.includes('storage/path/public/') ? false : true;
    }
};

</script>

<style lang="scss" scoped>
    .table-container {
        overflow: auto;
    }

    table {
        width: 100%;
        border-collapse: separate; 
        border-spacing: 1em;

        @media (max-width: 992px) {
            width: 700px;
        }
    }

    table td {
        text-align: center;
    }

    .actions {
        display: flex;
        column-gap: 10px;
        justify-content: center;
    }

    tr + tr {
        border-top: 1px solid red;
    }
</style>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Clients list
            </h2>
            <Link
                :href="route('clients.createPage')"
                as="button"
                class="border-solid rounded-md bg-black text-white py-1 px-1 text-sm"
            >
                Create client
            </Link>
        </template>

        <div class="py-6">
            <div class="table-container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <table class="table-auto">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Firstname</th>
                            <th scope="col">Lastname</th>
                            <th scope="col">Email</th>
                            <th scope="col">Avatar</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(client, index) in allClients.data" :key="index">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ client.firstname }}</td>
                            <td>{{ client.lastname }}</td>
                            <td>{{ client.email }}</td>
                            <td>
                                <template v-if="hasAvatar(client.avatar)">
                                    <img class="block h-10 w-auto m-auto" :src="`storage/avatars/${client.avatar}`" alt="Logo" />
                                </template>
                                <template v-else>
                                    <p>No avatar</p>
                                </template>
                            </td>
                            <td class="actions">
                                <Link
                                    :href="route('clients.edit', {id: client.id})"
                                    as="button"
                                    class="border-solid rounded-md bg-black text-white py-1 px-1 text-sm"
                                >
                                    Edit
                                </Link>
            
                                <Link
                                    :href="route('clients.delete', {id: client.id})"
                                    method="DELETE"
                                    as="button"
                                    class="border-solid rounded-md bg-black text-white py-1 px-1 text-sm"
                                >
                                    Delete
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination class="mt-4" :links="allClients.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
