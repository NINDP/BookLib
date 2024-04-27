<script setup>
import { ref } from 'vue'
defineProps({
    nickname: String,
    count_star: Number,
    src_img: String,
    content: String,
})
const max_h = ref("4em")
const isShowMore = ref(false)

const showMore = () => {
    isShowMore.value = true
    max_h.value = '100%'
}

const hideText = () => {
    isShowMore.value = false
    max_h.value = '4em'
}

</script>

<template>
    <section class="bg-[#F5F2F2] w-[500px] min-h-[250px] px-[60px] py-[15px] rounded-md mb-[20px] mr-[60px]">
        <div class="flex">
            <img v-if="src_img" class="w-[80px] h-[80px] rounded-full border-2 border-green1" :src="src_img" />
            <img class="w-[80px] h-[80px] rounded-full border-2 border-green1" v-else src="/cat_avatarka.png" />
            <div class="pl-[10px]">
                <p class="text-[24px] pb-[5px]">{{ nickname }}</p>
                <div class="flex">
                    <img class="w-[24px]" v-for="star in 5" :src="star <= count_star ? '/Star.png' : '/StarGray.png'" />
                </div>
            </div>
        </div>
        <p class="text-[20px] pt-[20px] break-words max-w-[300px]"
            :style="{ 'max-height': max_h, 'overflow': 'hidden' }">{{ content }}</p>
        <button v-if="!isShowMore && content.length > 70" @click="showMore" class="text-green1 text-[20px] pt-[10px]">Показать больше</button>
        <button v-if="isShowMore" @click="hideText" class="text-green1 text-[20px] pt-[10px]">Скрыть</button>
    </section>
</template>

<style scoped></style>
