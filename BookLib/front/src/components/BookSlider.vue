<script setup>
import { computed } from 'vue'
import store from '../store/index'

const user = computed(() => store.state.user);

defineProps({
    id: Number,
    title: String,
    author: String,
    src_img: String,
})


</script>

<template>
    <router-link class="" :to="{ path: `/bookpage/${id}`, params: { id: id } }">
        <img :src="src_img" alt="book_photo" class="w-[250px] h-[300px] rounded-md" />
        <div>
            <p class="text-[24px] font-semibold pb-[5px] w-[250px]">{{ title }}</p>
            <p class="text-[18px] text-gray-600 w-[250px]">{{ author }}</p>
        </div>
    </router-link>
</template>

<style scoped></style>
