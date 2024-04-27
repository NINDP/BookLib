<script setup>
import LikeButton from '../LikeButton.vue'
import BookSlider from '../BookSlider.vue'
import LayoutMain from '../Layouts/LayoutMain.vue'
import { ref, computed } from 'vue'
import { useRoute } from "vue-router";
import axiosClient from "../../axios-client.js";
import store from '../../store/index'

const user = computed(() => store.state.user.isAuthenticated);

const route = useRoute()
const id = route.params.id
const path_to_review = `/review/${id}`
const book = ref({})
const subscription = ref({})
const path = `/bookpage/${id}`
const isAudio = ref(false)
const user_sub = ref(0)
const minsub = ref(0)
const showAudioPlayer = ref(false);
const audioPlayer = ref(null);
const count = ref(0)
const books = ref([])
const currentIndex = ref(0);


defineProps({
    id: Number
})

axiosClient.get('/slider').then(({ data }) => {
    books.value = data['books']
})

axiosClient.get(path).then(({ data }) => {
    book.value = data['book']
    subscription.value = data['subscriptions']
    count.value = data['count_review']
    if (subscription.value != '') {
        minsub.value = subscription.value[0].id
    }
    if (book.value.lastTime && audioPlayer.value) {
        audioPlayer.value.currentTime = book.value.lastTime
    }
    if (data['user_sub']) {
        user_sub.value = data['user_sub']
    }
    if (book.value.type == 'audio') {
        isAudio.value = true
    }
}).catch(error => {
    console.error(error);
});

const toggleAudioPlayer = () => {
    showAudioPlayer.value = true;
}

const loadLastTime = (time) => {
    if (audioPlayer.value) {
        audioPlayer.value.currentTime = book.value.lastTime;
    }
}

const seekForward = () => {
    if (audioPlayer.value) {
        audioPlayer.value.currentTime += 15;
    }
}

const seekBackward = () => {
    if (audioPlayer.value) {
        audioPlayer.value.currentTime -= 15;
    }
}

const close = () => {
    axiosClient.post(path, { last_time: audioPlayer.value.currentTime }).then(({ data }) => {
        showAudioPlayer.value = false
        book.value.lastTime = data.last_time
        loadLastTime(book.value.last_time)
    }).catch((e) => {
        console.log("Ошибка загрузки последнего времени", e);
    })
}

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
        <router-link v-if="!isAudio"
            class="text-green1 font-semibold text-[24px] border-2 border-green1 rounded-md py-[10px] px-[30px]"
            to="/catalog/books"> Назад </router-link>
        <router-link v-else
            class="text-green1 font-semibold text-[24px] border-2 border-green1 rounded-md py-[10px] px-[30px]"
            to="/catalog/audiobooks"> Назад </router-link>

        <div class="flex justify-between">
            <section class="flex relative max-w-[1000px] py-[30px]">
                <img class="w-[150px] h-[150px] " alt="photo" :src="book.path_to_image" />
                <div class="pl-[20px]">
                    <h1 class="text-[30px] font-semibold pb-[10px] max-w-[300px]">{{ book.title }}</h1>
                    <p class="text-[20px] text-gray-600">{{ book.author }}</p>
                    <p class="text-[24px] min-w-[300px]">{{ book.description }}</p>
                </div>
                <LikeButton v-if="user" class="pt-[40px] absolute right-0 top-0" :key="book.id" :id="book.id"
                    :isLike="book.isLike">
                </LikeButton>
            </section>
            <section v-if="user">
                <p class="text-[30px] font-semibold">Отзывы</p>
                <p class="text-gray-700 pb-[20px]">Количество отзывов: <span class="underline ">{{ count }}</span></p>
                <router-link class="text-[24px] font-semibold bg-green1 text-white py-[7px] px-[30px] rounded-md"
                    :to=path_to_review>Читать отзывы</router-link>
            </section>
        </div>
        <button
            class="text-[20px] bg-green1 text-white py-[5px] px-[50px] cursor-pointer inline-block rounded-md font-semibold"
            @click="toggleAudioPlayer" v-if="isAudio && user && user_sub >= minsub">Слушать</button>
        <router-link
            class="text-[20px] bg-green1 text-white py-[5px] px-[50px] cursor-pointer inline-block rounded-md font-semibold"
            v-if="!user && isAudio" to="/login">Слушать в подписке</router-link>

        <div v-if="showAudioPlayer" class="fixed bottom-0 left-0 w-full bg-black p-4">
            <div class="flex justify-between items-center">
                <button @click="close" class="absolute top-1 right-1 text-[40px] text-red-600">&times</button>
                <button @click="seekBackward" class="text-[30px] text-caramel pr-[10px]">&minus;</button>
                <button @click="seekForward" class="text-[30px] text-caramel">&plus;</button>
                <audio autoplay ref="audioPlayer" controls class="w-full bg-black" @loadedmetadata="loadLastTime">
                    <source :src="book.path_to_audio" type="audio/mpeg">
                </audio>
            </div>
        </div>

        <router-link
            class="mr-[20px] text-[20px] bg-green1 text-white py-[5px] px-[50px] cursor-pointer inline-block rounded-md font-semibold"
            v-if="!isAudio && user && user_sub >= minsub" :to="{ path: `/book/${id}`, params: { id: id } }">Читать в
            подписке</router-link>

        <router-link
            class="mr-[20px] text-[20px] bg-green1 text-white py-[5px] px-[50px] cursor-pointer inline-block rounded-md font-semibold"
            v-if="!isAudio && !user" to="/login">Читать в подписке</router-link>

        <router-link
            class="text-[20px] bg-caramel text-white py-[5px] px-[50px] cursor-pointer inline-block rounded-md font-semibold"
            v-if="!isAudio" :to="{ path: `/book/${id}/excerpt`, params: { id: id } }">Читать отрывок</router-link>
        <p class="text-[20px] text-gray-800 py-[10px]" v-if="user && user_sub < minsub">У вас нет
            достаточного уровня подписки. Оформите одну из
            подписок из списка ниже</p>
        <p class="text-[24px] font-semibold text-brown pt-[5px]">Доступна в подписках: </p>
        <p class="text-[20px] pt-[5px]" v-for="sub in subscription">{{ sub.name }}</p>

        <h2 class="text-[35px] text-[#272727] font-semibold py-[50px]">Наши книжные новинки</h2>
        <div class="flex justify-between">
            <button class="prev" v-if="currentIndex !== 0" @click="prevSlide"><button><img
                        src="/ArrowBook.png" /></button></button>
            <BookSlider v-for="(book, index) in displayedBooks" :key="index" :id="book.id" :src_img="book.path_to_image"
                :title="book.title" :author="book.author"></BookSlider>
            <button v-if="currentIndex !== (books.length - 5)" class="next" @click="nextSlide"><button><img
                        src="/ArrowBookRight.png" /></button></button>
        </div>
    </LayoutMain>
</template>

<style scoped></style>
