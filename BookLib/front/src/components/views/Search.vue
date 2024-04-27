<script setup>
import LayoutMain from '../Layouts/LayoutMain.vue';
import axiosClient from '../../axios-client';
import Book from '../Book.vue';
import { useRouter } from 'vue-router';
import { ref, watch } from 'vue';

const router = useRouter();
const books = ref({})

const fetchData = () => {
    axiosClient.get(router.currentRoute.value.fullPath).then(({ data }) => {
        books.value = data;
        console.log(books.value);
    }).catch((e) => {
        console.log(e);
    });
};

watch(() => router.currentRoute.value.fullPath, () => {
    fetchData();
}, { immediate: true });

fetchData();

</script>

<template>
    <LayoutMain>
        <section v-if="books.length" class="pt-[30px] flex justify-between max-w-[1690px] flex-wrap">
            <Book class="mb-[20px]" v-for="book in books" :key="book.id" :id="book.id" :src_img="book.path_to_image" :title="book.title"
                :author="book.author" :isLike="book.isLike" :description="book.description"></Book>
        </section>
        <p class="text-[30px] pt-[40px] text-gray-600" v-else>К сожалению, у  нас нет книг, удовлетворяющих условию поиска. Попробуйте найти что-то другое</p>
    </LayoutMain>
</template>
