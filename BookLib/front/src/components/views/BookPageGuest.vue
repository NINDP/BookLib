<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import axiosClient from "../../axios-client";

const route = useRoute();
const id = route.params.id;
const book = ref({});
const bookPages = ref([]);
const currentPageNum = ref(0);

onMounted(() => {
    axiosClient
        .get(`/book/${id}/excerpt`)
        .then(({ data }) => {
            book.value = data;
            splitTextIntoPages(data.content);
        })
        .catch(error => {
            console.error(error);
        });
});

const splitTextIntoPages = (text) => {
    const pageSize = 930;
    const maxPages = 3;

    const pages = [];

    for (let i = 0, pageCount = 0; i < text.length && pageCount < maxPages; i += pageSize) {
        const page = text.substring(i, i + pageSize);
        pages.push(page);
        pageCount++;
    }

    bookPages.value = pages;
};

</script>

<template>
    <div>
        <header class="bg-gray-200 px-[100px] py-[20px] flex justify-between">
            <article class="flex">
                <img class="w-[100px] h-[80px]" :src="book.path_to_image" />
                <div class="pl-[10px]">
                    <p class="text-[24px] font-semibold">{{ book.title }}</p>
                    <p class="text-[18px]">{{ book.author }}</p>
                </div>
            </article>
            <div class="flex items-center">
                <LikeButton :key="book.id" :id="book.id" :isLike="book.isLike"></LikeButton>
            </div>
            <router-link class="text-brown absolute top-1 right-5 text-[30px] font-semibold"
                to="/catalog/books">X</router-link>
        </header>

        <section class="px-[200px]">
            <div class="flex justify-between min-h-[800px]">
                <button class="w-[400px]" v-if="currentPageNum > 0" @click="currentPageNum--"><img src="/ArrowBook.png"
                        alt="gdfgdfsg" /></button>
                <p class="flex-grow text-[36px] py-[40px] px-[20px] break-words">{{
                    bookPages[currentPageNum] }}</p>
                <button class="w-[400px]" v-if="currentPageNum != bookPages.length - 1" @click="currentPageNum++">
                    <img src="/ArrowBookRight.png" alt="gdfgdfsg" />
                </button>
            </div>
            <p>Вы на {{ currentPageNum + 1 }} странице</p>
        </section>

    </div>
</template>

<style></style>
