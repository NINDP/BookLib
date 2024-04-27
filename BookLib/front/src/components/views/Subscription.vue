<script setup>
import SubscriptionCard from '../SubscriptionCard.vue';
import LayoutMain from '../Layouts/LayoutMain.vue'
import { ref } from 'vue'
import axiosClient from '../../axios-client';

const subscriptions = ref({})
const paths = ['/Кот1.png', '/Кот2.png', '/Кот3.png']
const advantages1 = ['Доступны более 10 книг и аудиокниг', 'Доступны более 20 книг и аудиокниг', 'Доступны более 30 книг и аудиокниг']
const advantages2 = ['Низкая цена', 'Книжные обновления каждую неделю', 'Узнавайте о новинках самыми первыми']

axiosClient.get('/subscription').
    then(response => {
        subscriptions.value = response.data;
    })
    .catch(error => {
        console.error(error);
    });
</script>

<template>
    <LayoutMain>
        <section class="py-[40px] text-black_text">
            <h1 class="text-[44px] font-semibold pb-[20px]">Подписка <span class="text-green1">BookLib</span></h1>
            <p class="text-gray-600 text-[24px] w-[600px] pb-[60px]">Приобретите подписку на нашем сайте, чтобы читать
                самые
                свежие
                новинки в удобном формате</p>
            <div class="flex justify-between">
                <SubscriptionCard v-for="subscription in subscriptions" :key="subscription.id" :name="subscription.name"
                    :cost="subscription.cost" :path="paths[subscription.id - 1]"
                    :adv1="advantages1[subscription.id - 1]" :adv2="advantages2[subscription.id - 1]">
                </SubscriptionCard>
            </div>
        </section>
    </LayoutMain>
</template>

<style scoped></style>