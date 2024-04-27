<script setup>
import BookReview from "../BookReview.vue";
import LayoutMain from "../Layouts/LayoutMain.vue";
import { ref } from 'vue'
import axiosClient from "../../axios-client";
import { useRoute } from "vue-router";

const route = useRoute()
const id = route.params.id
const reviews = ref({})
const book = ref({})
const userReview = ref({})
const countStar = ref(0)
const isUpdate = ref(false)
const textReview = ref('')

const setCountStar = (id) => {
    countStar.value = id
}

axiosClient.get(`/review/${id}`).then(({ data }) => {
    reviews.value = data['reviews'];
    book.value = data['book'];
    userReview.value = data['userReview'];

    if (userReview.value) {
        textReview.value = userReview.value.content
        countStar.value = userReview.value.count_star
    }
        })
        .catch((error) => {
            console.error("Ошибка при загрузке отзывов...", error);
        });

    
const sendReview = () => {
    const payload = {
        book_id: id,
        count_star: countStar.value,
        content: textReview.value
    }

    const response = axiosClient.post(`/review/${id}`, payload).then(({ data }) => {
        alert("Ваш отзыв успешно отправлен");
        userReview.value = data
        textReview.value = data.content
        countStar.value = data.count_star
    })
        .catch(error => {
            console.error('Ошибка при отправке отзыва:', error);
        });
}

const deleteReview = () => {
    axiosClient.delete(`/review/${id}`).then(({ data }) => {
        alert("Ваш отзыв успешно удалён");
        countStar.value = 0
        textReview.value = ''
        userReview.value = data
    })
        .catch(error => {
            console.error('Ошибка при удалении отзыва:', error);
        });
}

const updateReview = () => {
    const payload = {
        content: textReview.value,
        count_star: countStar.value,
    }

    axiosClient.patch(`/review/${id}`, payload).then(({ data }) => {
        alert("Ваш отзыв успешно изменён");
        isUpdate.value = false;
        userReview.value.count_star = data.count_star
        userReview.value.content = data.content
    })
        .catch(error => {
            console.error('Ошибка при изменении отзыва:', error);
        });
}
</script>

<template>
    <LayoutMain>
        <section class="flex justify-between items-center pt-[40px]">
            <div v-if="!isUpdate && userReview">
                <h3 class="text-[30px] font-semibold">Ваш отзыв</h3>
                <p class="text-[20px] py-[10px] max-w-[700px] break-words">{{ userReview.content }}</p>
                <div class="flex pb-[20px]">
                    <img v-for="star in 5" :src="star <= userReview.count_star ? '/Star.png' : '/StarGray.png'" />
                </div>
                <button
                    class="text-[20px] border-2 border-red-600 bg-red-600 text-bgcolor py-[4px] px-[40px] hover:bg-bgcolor hover:text-red-600 rounded-[5px] mr-[10px]"
                    @click="deleteReview">Удалить
                    отзыв</button>
                <button @click="isUpdate = true"
                    class="text-[20px] border-2 border-caramel bg-caramel text-bgcolor py-[4px] px-[40px] hover:bg-bgcolor hover:text-caramel rounded-[5px]">Изменить
                    отзыв</button>
            </div>

            <div v-if="isUpdate">
                <p class="text-[20px] font-bold w-[400px] pb-[10px]">Редактирование отзыва</p>
                <textarea v-model="textReview" rows=10 cols="60"
                    class="resize-none border-2 border-brown rounded-md p-[5px] mb-[10px]"
                    placeholder="Выскажите своё мнение об этой книге..."></textarea>
                <div class="flex pb-[20px]">
                    <img v-for="star in 5" :src="star <= countStar ? '/Star.png' : '/StarGray.png'"
                        @click="setCountStar(star)" />
                </div>
                <button
                    class="text-[20px] bg-caramel text-white py-[5px] px-[30px] cursor-pointer inline-block rounded-md font-semibold"
                    @click="updateReview">Отредактировать
                    отзыв</button>
                <button
                    class="text-[20px] border-2 border-red-600 bg-red-600 text-bgcolor py-[4px] px-[40px] hover:bg-bgcolor hover:text-red-600 rounded-[5px] ml-[10px]"
                    @click="isUpdate = false">Отмена</button>
            </div>

            <section v-if="!userReview">
                <h1 class="text-[40px] font-semibold">Отзывы</h1>
                <h2 class="pb-[5px]">Оставить свой отзыв</h2>
                <div class="flex pb-[20px]">
                    <img v-for="star in 5" :src="star <= countStar ? '/Star.png' : '/StarGray.png'"
                        @click="setCountStar(star)" />
                </div>
                <textarea v-model="textReview" rows=10 cols="60"
                    class="resize-none border-2 border-brown rounded-md p-[5px] mb-[10px]"
                    placeholder="Выскажите своё мнение об этой книге..."></textarea>
                <button
                    class="text-[20px] bg-green1 text-white py-[5px] px-[50px] block cursor-pointer rounded-md font-semibold"
                    @click="sendReview">Оставить
                    отзыв</button>
            </section>
            <section class="flex">
                <img class="w-[200px] rounded-md" :src="book.path_to_image" />
                <div class="pl-[20px]">
                    <p class="font-semibold text-[28px] pb-[5px]">{{book.title}}</p>
                    <p class="text-gray-600">{{book.author}}</p>
                </div>
            </section>
        </section>
        <section v-if="reviews.length" class="pt-[60px] flex max-w-[1680px] flex-wrap justify-start items-start">
            <BookReview v-for="review in reviews" :key="review.id" :nickname="review.user.nickname"
                :src_img="review.user.path_to_photo" :content="review.content" :count_star="review.count_star">
            </BookReview>
        </section>
        <p v-else class="text-gray-700 text-[32px] pt-[30px]">Пока нет отзывов на эту книгу...</p>
    </LayoutMain>
</template>
