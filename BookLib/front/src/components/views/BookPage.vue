<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import axiosClient from "../../axios-client";

const router = useRouter();
const route = useRoute();
const id = route.params.id;
const path = `/bookpage/${id}`
const book = ref({});
const fontSize = ref("36px");
const bookPages = ref([]);
const currentPageNum = ref(0);

onMounted(() => {
    axiosClient
        .get(`/book/${id}`)
        .then(({ data }) => {
            book.value = data['book'];
            if (book.value.lastPage) {
                currentPageNum.value = book.value.lastPage
            }
            splitTextIntoPages(data['book'].content);
        })
        .catch(error => {
            console.error(error);
        });
});

const splitTextIntoPages = (text) => {
    const pageSize = 930;
    const pages = [];

    for (let i = 0; i < text.length; i += pageSize) {
        const page = text.substring(i, i + pageSize);
        pages.push(page);
    }

    bookPages.value = pages;
};

const close = () => {
    if (currentPageNum.value != 0) {
        const payload = {
            last_page: currentPageNum.value
        }
        axiosClient.post(`/book/${id}`, payload).
            then(({ data }) => {
                router.push(path)
        })
            .catch(error => {
                console.error(error);
            });
    } else {
        router.push(path)
    }
}
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
                <p class="text-[24px] pr-[10px] text-green1 font-semibold">Шрифт</p>
                <select class="text-[20px]" v-model="fontSize">
                    <option value="30px">Маленький</option>
                    <option value="36px">Средний</option>
                    <option value="46px">Большой</option>
                </select>
                <LikeButton :key="book.id" :id="book.id" :isLike="book.isLike"></LikeButton>
            </div>
            <button @click="close" class="text-brown absolute top-1 right-5 text-[30px] font-semibold">X</button>
        </header>

        <section class="px-[200px]">
            <div class="flex justify-between min-h-[800px]">
                <button class="w-[400px]" v-if="currentPageNum > 0" @click="currentPageNum--"><img src="/ArrowBook.png"
                        alt="gdfgdfsg" /></button>
                <p class="flex-grow text-[20px] py-[40px] px-[20px] break-words" :style="{ fontSize }">{{
                    bookPages[currentPageNum] }}</p>
                <button class="w-[400px]" v-if="currentPageNum != bookPages.length - 1" @click="currentPageNum++">
                    <img src="/ArrowBookRight.png" alt="gdfgdfsg" />
                </button>
            </div>
            <p>Вы на {{ currentPageNum + 1 }} странице</p>
        </section>

    </div>
</template>

<style>

</style>
