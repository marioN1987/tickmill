<script setup>
defineProps({
    options: Array
})
</script>

<template>
    <select>
        <option value="">Please select ...</option>
        <option v-for="option in options" :key="option.id" :value="option.id">
            {{ option.firstname + ' ' + option.lastname + ' | ' + option.email }}
        </option>
    </select>
</template>