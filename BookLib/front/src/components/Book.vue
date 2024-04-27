<script setup>
import { computed } from 'vue'
import LikeButton from './LikeButton.vue'
import store from '../store/index'

const user = computed(() => store.state.user);

defineProps({
    id: Number,
    title: String,
    author: String,
    description: String,
    src_img: String,
    isLike: Boolean,
})


</script>

<template>
    <section class="bg-white flex relative w-[800px] border-2 rounded-md py-[20px] px-[30px]">
        <router-link class="flex" :to="{ path: `/bookpage/${id}`, params: { id: id } }">
            <img :src="src_img" alt="book_photo" class="h-[130px] rounded-md" />
            <div class="pl-[20px]">
                <p class="text-[24px] font-semibold pb-[5px]">{{ title }}</p>
                <p class="text-[18px] text-gray-600">{{ author }}</p>
                <p class="text-[18px] max-h-[3em] overflow-hidden">{{
                    description }}</p>
            </div>
        </router-link>
        <LikeButton v-if="user.isAuthenticated" class="absolute top-2 right-2" :key="id" :id="id" :isLike="isLike">
        </LikeButton>
    </section>

</template>

<style scoped></style>
