<script setup>
    import { Link } from '@inertiajs/vue3';

    defineProps({
        links: Array
    })
</script>

<template>
    <div v-if="links.length > 0">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, index) in links" :key="index">
                <div 
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label"
                />
                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 inline-block focus:text-indigo-500"
                    :class="{'bg-blue-700 text-white hover:bg-blue-700': link.active}"
                    :href="link.url"
                >
                    <span v-html="link.label" />
                </Link>
            </template>
        </div>
    </div>
</template>