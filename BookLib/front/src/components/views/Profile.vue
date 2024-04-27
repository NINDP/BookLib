<script setup>
import LayoutMain from '../Layouts/LayoutMain.vue'
import BookProfile from '../BookProfile.vue';
import BookReview from '../BookReview.vue';
import axiosClient from '../../axios-client';
import { ref } from 'vue'
import store from "../../store/index.js";

const dataProfile = ref({})
const countStar = ref(0)
const textReview = ref('')
const dataReview = ref({})
const continueBooks = ref({})
const continueAudiobooks = ref({})
const favoriteBooks = ref({})
const favoriteAudiobooks = ref({})
const userBookReview = ref({})
const showModal = ref(false)
const isChange = ref(false)

const openModal = () => {
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
}

axiosClient.get('/profile').then(({ data }) => {
    dataProfile.value = data['user']
    dataReview.value = data['review']
    userBookReview.value = data['userBookReview']
    continueBooks.value = data['continueBook']
    favoriteBooks.value = data['books']
    favoriteAudiobooks.value = data['audiobooks']
    continueAudiobooks.value = data['continueAudio']
    if (dataReview.value) {
        textReview.value = data['review'].content
        countStar.value = data['review'].count_star
    }
    store.methods.setProfileImageURL(dataProfile.value.path_to_photo);
    if (dataProfile.value.path_to_photo == null) {
        dataProfile.value.path_to_photo = '/cat_avatarka.png'
    }
}).catch(error => {
    console.error(error);
});

const onFileChange = (event) => {
    const file = event.target.files[0];
    const formData = new FormData();
    formData.append('path_to_photo', file);
    axiosClient.post('/profile', formData).then(({ data }) => {
        alert("Фото успешно загружено");
        dataProfile.value.path_to_photo = data
        store.methods.setProfileImageURL(dataProfile.value.path_to_photo);
    }).catch(error => {
        console.error('Ошибка при загрузке фото:', error);
    });
}

const setCountStar = (id) => {
    countStar.value = id
}

const sendAppReview = () => {
    const payload = {
        count_star: countStar.value,
        content: textReview.value
    }

    const response = axiosClient.post(`/profile/${dataProfile.id}`, payload).then(({ data }) => {
        alert("Ваш отзыв успешно отправлен");
        dataReview.value = data
        textReview.value = data.content
        countStar.value = data.count_star
    })
        .catch(error => {
            console.error('Ошибка при отправке отзыва:', error);
        });
}

const deleteReview = () => {
    axiosClient.delete(`/profile/${dataReview.id}`).then(({ data }) => {
        closeModal()
        alert("Ваш отзыв успешно удалён");
        countStar.value = 0
        textReview.value = ''
        dataReview.value = data
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

    axiosClient.patch(`/profile/${dataReview.value.id}`, payload).then(({ data }) => {
        alert("Ваш отзыв успешно изменён");
        isChange.value = false;
        dataReview.value.count_star = data.count_star
        dataReview.value.content = data.content
    })
        .catch(error => {
            console.error('Ошибка при изменении отзыва:', error);
        });
}

</script>

<template>
    <LayoutMain>
        <h1 class="font-semibold text-[44px] text-black-text pb-[30px] py-[50px]">Профиль</h1>
        <section class="text-black-text border-2 rounded-md py-[80px] px-[100px]">
            <section class="flex justify-between">
                <div>
                    <article class="flex pb-[20px]">
                        <img v-if="dataProfile.path_to_photo" :src="dataProfile.path_to_photo"
                            class="w-[150px] h-[150px] border-2 border-green1 rounded-full" />
                        <div class="pl-[40px]">
                            <p class="text-[31px] font-semibold">{{ dataProfile.nickname }}</p>
                            <p class="text-[20px] text-gray-700">{{ dataProfile.description }}</p>
                        </div>
                    </article>
                    <input type="file" class="sr-only" id="profile-image-upload" @change="onFileChange">
                    <label for="profile-image-upload"
                        class="text-[20px] bg-green1 text-white py-[5px] px-[50px] cursor-pointer inline-block rounded-md font-semibold">Изменить
                        фото</label>
                </div>
                <section>
                    <div v-if="!dataReview && !isChange" class="grid w-[400px]">
                        <p class="text-[20px] font-bold w-[400px] pb-[10px]">Оцените наше приложение, чтобы мы могли
                            становиться
                            лучше</p>
                        <textarea v-model="textReview" placeholder="Ваш отзыв"
                            class="border-2 border-gray-600 px-[10px] py-[5px] mb-[20px] rounded-md"
                            rows="4"></textarea>
                        <div class="flex pb-[20px]">
                            <img v-for="star in 5" :src="star <= countStar ? '/Star.png' : '/StarGray.png'"
                                @click="setCountStar(star)" />
                        </div>
                        <button
                            class="text-[20px] bg-caramel text-white py-[5px] px-[50px] cursor-pointer inline-block rounded-md font-semibold"
                            @click="sendAppReview">Оставить
                            отзыв</button>
                    </div>
                    <div v-if="dataReview && !isChange">
                        <h3 class="text-[30px] font-semibold">Ваш отзыв</h3>
                        <p class="text-[24px] py-[10px] break-words max-w-[600px]">{{ dataReview.content }}</p>
                        <div class="flex pb-[20px]">
                            <img v-for="star in 5"
                                :src="star <= dataReview.count_star ? '/Star.png' : '/StarGray.png'" />
                        </div>
                        <button
                            class="text-[20px] border-2 border-red-600 bg-red-600 text-bgcolor py-[4px] px-[40px] hover:bg-bgcolor hover:text-red-600 rounded-[5px] mr-[10px]"
                            @click="openModal">Удалить
                            отзыв</button>
                        <button @click="isChange = true"
                            class="text-[20px] border-2 border-caramel bg-caramel text-bgcolor py-[4px] px-[40px] hover:bg-bgcolor hover:text-caramel rounded-[5px]">Изменить
                            отзыв</button>
                    </div>
                    <div v-if="isChange">
                        <p class="text-[20px] font-bold w-[400px] pb-[10px]">Редактирование отзыва</p>
                        <textarea v-model="textReview" placeholder="Ваш отзыв"
                            class="border-2 border-gray-600 px-[10px] py-[5px] mb-[20px] rounded-md" rows="5"
                            cols="40"></textarea>
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
                            @click="isChange = false">Отмена</button>
                    </div>
                </section>
            </section>
            <div v-if="showModal"
                class="fixed top-0 left-0 w-full h-full flex justify-center items-center bg-gray-900 bg-opacity-50 z-10">
                <div class="relative bg-white p-8 rounded-md max-w-lg z-50">
                    <h2 class="text-xl font-semibold pt-4 pb-8">Вы уверены, что хотите удалить отзыв?</h2>
                    <div class="flex justify-end">
                        <button class="rounded-md text-bgcolor bg-green1 px-[20px] py-[10px] mr-4"
                            @click="deleteReview">Да</button>
                        <button class="rounded-md px-[20px] py-[10px] text-bgcolor bg-red-600"
                            @click="closeModal">Нет</button>
                        <button @click="closeModal"
                            class="absolute top-0 right-0 bg-gray-100 px-2 rounded-full text-red-500 mt-2 mr-2 text-lg">X</button>
                    </div>
                </div>
            </div>

            <h2 class="text-[28px] font-semibold pt-[30px] pb-[15px]">Избранные книги</h2>
            <section v-if="favoriteBooks.length" class="flex justify-start max-w-[1690px] flex-wrap items-center">
                <BookProfile v-for="book in favoriteBooks" :key="book.id" :id="book.id"
                    :path_to_image="book.path_to_image"></BookProfile>
            </section>
            <p class="text-gray-600 text-[20px]" v-else>Пока пусто...</p>

            <h2 class="text-[28px] font-semibold pt-[30px] pb-[15px]">Избранные аудиокниги</h2>
            <section v-if="favoriteAudiobooks.length" class="flex max-w-[1690px] flex-wrap justify-start items-center">
                <BookProfile v-for="book in favoriteAudiobooks" :key="book.id" :id="book.id"
                    :path_to_image="book.path_to_image"></BookProfile>
            </section>
            <p class="text-gray-600 text-[20px]" v-else>Пока пусто...</p>

            <h2 class="text-[28px] font-semibold pt-[30px] pb-[15px]">Продолжить читать</h2>
            <section v-if="continueBooks.length" class="flex max-w-[1690px] flex-wrap justify-start items-center">
                <BookProfile v-for="book in continueBooks" :key="book.id" :id="book.id"
                    :path_to_image="book.path_to_image"></BookProfile>
            </section>
            <p class="text-gray-600 text-[20px]" v-else>Пока пусто...</p>

            <h2 class="text-[28px] font-semibold pt-[30px] pb-[15px]">Продолжить слушать</h2>
            <section v-if="continueAudiobooks.length" class="flex max-w-[1690px] flex-wrap justify-start items-center">
                <BookProfile v-for=" book in continueAudiobooks" :key="book.id" :id="book.id"
                    :path_to_image="book.path_to_image">
                </BookProfile>
            </section>
            <p class="text-gray-600 text-[20px]" v-else>Пока пусто...</p>

            <h2 class="text-[28px] font-semibold pt-[30px] pb-[15px]">Мои отзывы на книги</h2>
            <section class="flex max-w-[1690px] flex-wrap justify-start items-start">
                <BookReview v-if="userBookReview.length" class="pb-[20px] border-2 border-caramel bg-bgcolor"
                    v-for="review in userBookReview" :key="review.id" :nickname="dataProfile.nickname"
                    :src_img="dataProfile.path_to_photo" :count_star="review.count_star" :content="review.content">
                </BookReview>
                <p class="text-gray-600 text-[20px]" v-else>Пока пусто...</p>
            </section>
            <router-link
                class="ml-[20px] float-right bg-caramel text-white font-semibold rounded-md py-[10px] px-[20px] text-[20px]"
                to="/adminPanel/user" v-if="dataProfile.isAdmin">
                Админ-панель</router-link>
            <router-link :to="{ name: 'EditProfile' }"
                class="text-[24px] font-semibold bg-green1 text-white py-[7px] px-[30px] float-end rounded-md">Редактировать
                профиль</router-link>
        </section>
    </LayoutMain>
</template>

<style></style>
