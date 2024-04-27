<script setup>
import DashBoard from '../DashBoard.vue';
import { useRouter } from 'vue-router';

const router = useRouter()
</script>

<template>
    <header class="flex px-[40px] py-[20px] justify-between items-center bg-gray-100">
        <p class="text-caramel font-semibold text-[24px]">Админ-панель</p>
        <h1 class="text-green1 text-[40px] font-semibold">Администрирование вашего сайта</h1>
        <router-link
            class="text-[20px] bg-caramel text-white py-[5px] px-[50px] cursor-pointer inline-block rounded-md font-semibold"
            to="/profile">На сайт</router-link>
    </header>
        <DashBoard>
        <slot></slot>
        </DashBoard>
</template>