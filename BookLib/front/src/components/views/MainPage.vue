<script setup>
import LayoutMain from '../Layouts/LayoutMain.vue'
import BookSlider from '../BookSlider.vue'
import axiosClient from '../../axios-client';
import { ref, computed } from 'vue';

const reviews = ref({})
const books = ref([]);
const currentIndex = ref(0);
const currentReview = ref(0)

axiosClient.get('/slider').then(({ data }) => {
    books.value = data['books']
    reviews.value = data['reviews']
    console.log(reviews.value);
}).catch(error => {
    console.error(error);
});

const displayedBooks = computed(() => {
    const endIndex = currentIndex.value + 5;
    return books.value.slice(currentIndex.value, endIndex);
});

const prevSlide = () => {
    currentIndex.value = (currentIndex.value - 1 + books.value.length) % books.value.length;
};

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % books.value.length;
};
</script>

<template>
    <LayoutMain>
        <section class="flex py-[100px] justify-between">
            <div>
                <h1 class="text-[54px] text-[#272727] font-semibold py-[40px] w-[700px]"><span
                        class="text-green1">BookLib</span> - лучший сервис
                    для чтения книг
                </h1>
                <p class="text-[31px] text-[#565656] w-[800px] pb-[60px]">Мы поможем вам провести вечер с пользой с
                    любимой
                    книгой!
                </p>
                <router-link to='/login'
                    class="text-[28px] font-bold border border-caramel bg-caramel text-bgcolor py-3 px-20 hover:bg-bgcolor hover:text-caramel rounded-[5px] ">Присоединиться</router-link>
            </div>
            <img class="w-[700px]" alt="cat" src="/Cat.jpg" />
        </section>

        <h2 class="text-[40px] text-[#272727] font-semibold pb-[50px]">Наши книжные новинки</h2>
        <div class="flex justify-between">
            <button class="prev" v-if="currentIndex !== 0" @click="prevSlide"><button><img
                        src="/ArrowBook.png" /></button></button>
            <BookSlider v-for="(book, index) in displayedBooks" :key="index" :id="book.id" :src_img="book.path_to_image"
                :title="book.title" :author="book.author"></BookSlider>
            <button v-if="currentIndex !== (books.length - 5)" class="next" @click="nextSlide"><button><img
                        src="/ArrowBookRight.png" /></button></button>
        </div>

        <section class="pt-[200px] flex justify-around items-start">
            <div class="flex">
                <button class="pr-[30px]" v-if="currentReview != 0" @click="currentReview -= 1"><img
                        src="/ArrowBook.png" /></button>
                <div class="border-4 border-caramel rounded-md w-[500px] py-[50px] pl-[100px]"
                    v-if="reviews[currentReview]">
                    <div class=" flex">
                        <img v-if="reviews[currentReview].user.path_to_photo"
                            class="w-[100px] h-[100px] rounded-full border-4 border-green1"
                            :src="reviews[currentReview].user.path_to_photo" />
                        <img v-else class="w-[100px] h-[100px] rounded-full border-4 border-green1"
                            src="/cat_avatarka.png" />
                        <div class="pl-[10px]">
                            <p class="text-[30px] font-semibold ">{{ reviews[currentReview].user.nickname }}</p>
                            <div class="flex">
                                <img v-for="star in 5"
                                    :src="star <= reviews[currentReview].count_star ? '/Star.png' : '/StarGray.png'" />
                            </div>
                        </div>
                    </div>
                    <p class="text-[30px] text-gray-700">{{ reviews[currentReview].content }}</p>
                </div>
                <button class="pl-[30px]" v-if="currentReview != reviews.length - 1" @click="currentReview += 1"><img
                        src="/ArrowBookRight.png" /></button>
            </div>
            <div>
                <h2 class="text-[40px] text-[#272727] font-semibold pb-[30px]">Взгляните на отзывы
                </h2>
                <p class="text-[24px] w-[700px] text-gray-700">Отзывы помогают нам становиться лучше, а вам убедиться в
                    надёжности и удобстве нашего приложения
                </p>
            </div>
        </section>
    </LayoutMain>
</template>

<style></style>
