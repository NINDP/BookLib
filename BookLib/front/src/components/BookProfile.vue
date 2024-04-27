<script setup>
defineProps({
    id: Number,
    path_to_image: String,
 })
</script>

<template>
    <router-link class="flex mb-[30px]" :to="{ path: `/bookpage/${id}` }">
        <img class="w-[250px] max-h-[250px] rounded-md mr-[20px]" :src="path_to_image" />
    </router-link>
</template>