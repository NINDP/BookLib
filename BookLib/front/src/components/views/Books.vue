<script setup>
import LayoutMain from '../Layouts/LayoutMain.vue'
import axiosClient from "../../axios-client.js";
import Book from "../Book.vue";
import { ref } from 'vue'
const books = ref([])

axiosClient.get('/catalog/books')
    .then(response => {
        books.value = response.data;
    })
    .catch(error => {
        console.error(error);
    });


</script>

<template>
    <LayoutMain>
        <section class="flex justify-between max-w-[1680px] flex-wrap">
            <Book class="mt-[20px]" v-for="book in books" :key="book.id" :title="book.title"
                :src_img="book.path_to_image" :author="book.author" :id="book.id" :description="book.description"
                :isLike="book.isLike"></Book>
        </section>
    </LayoutMain>
</template>

<style></style>
