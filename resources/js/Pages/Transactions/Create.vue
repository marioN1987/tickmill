<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

import SelectBox from '@/Components/SelectBox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    clientsList: Array
})

const form = useForm({
    clientId: '',
    amount: ''
});

const submit = () => {
    form.post(route('transactions.store'));
};

const changedValue = ($ev)=> {
    const clientId = $ev.target.value;
    if (clientId !== '' || clientId !== null) {
        form.clientId = clientId;
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Transaction Create
            </h2>
        </template>
        
        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <form
                    @submit.prevent="submit"
                    class="mt-6 space-y-6"
                >

                    <div>
                        <InputLabel for="client" value="Select client" />

                        <SelectBox
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 block w-full"
                            @change="changedValue($event)" 
                            :options="clientsList"
                        />

                        <InputError class="mt-2" :message="form.errors.clientId" />
                    </div>

                    <div>
                        <InputLabel for="amount" value="Amount" />

                        <TextInput
                            id="amount"
                            type="number"
                            step="any"
                            class="mt-1 block w-full"
                            v-model="form.amount"
                            required
                            autofocus
                        />

                        <InputError class="mt-2" :message="form.errors.amount" />
                    </div>

                    <div class="mt-4 flex">
                        <PrimaryButton
                            :disabled="false"
                        >
                            Create
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