<script setup>
import axiosClient from "../../axios-client.js";
import { ref } from 'vue';
import LayoutMain from "../Layouts/LayoutMain.vue";
import Book from "../Book.vue";

const audiobooks = ref({})

axiosClient.get('/catalog/audiobooks').then(({ data }) => {
    audiobooks.value = data;
}).catch((e) => {
    console.log('Ошибка загрузки аудиокниг', e)
})
</script>

<template>
    <LayoutMain>
        <section class="flex justify-between max-w-[1680px] flex-wrap">
            <Book class="mt-[20px]" v-for="audiobook in audiobooks" :key="audiobook.id" :id="audiobook.id"
                :title="audiobook.title" :author="audiobook.author" :description="audiobook.description"
                :src_img="audiobook.path_to_image" :isLike="audiobook.isLike"></Book>
        </section>
    </LayoutMain>
</template>

<style scoped></style>
