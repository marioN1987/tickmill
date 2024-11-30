<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    transaction: {
        type: Object
    }
});

const selTransaction = props.transaction;

const form = useForm({
    firstname: selTransaction.client.firstname,
    lastname: selTransaction.client.lastname,
    email: selTransaction.client.email,
    amount: selTransaction.amount
});

const submit = () => {
    form.post(route('transactions.update', {id: props.transaction.id}));
};

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Transaction Edit
            </h2>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <form
                    @submit.prevent="submit"
                    class="mt-6 space-y-6"
                >
                    <div>
                        <InputLabel for="fullname" value="Fullname (readonly)" />

                        <TextInput
                            id="firstname"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.firstname"
                            readonly
                        />
                    </div>

                    <div>
                        <InputLabel for="lastname" value="Lastname (readonly)" />

                        <TextInput
                            id="lastname"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.lastname"
                            readonly
                        />
                    </div>

                    <div>
                        <InputLabel for="email" value="Email (readonly)" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            readonly
                        />
                    </div>

                    <div>
                        <InputLabel for="amount" value="Amount" />

                        <input 
                            type="number" 
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 block w-full" 
                            step="any" 
                            v-model="form.amount" 
                        />

                        <InputError class="mt-2" :message="form.errors.amount" />
                    </div>

                    <div class="mt-4 flex">
                        <PrimaryButton
                            :disabled="false"
                        >
                            Update
                        </PrimaryButton>
                        
                        <Link
                            :href="route('transactions.list')"
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