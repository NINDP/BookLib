<script setup>
import { useRouter } from 'vue-router';
const router = useRouter()
</script>

<template>
    <section class="flex items-center bg-bgcolor">
        <img class="pl-[200px] h-[100vh]" src="/NotFound.png" />
        <div class="pl-[300px]">
            <h1 class="text-[50px] font-semibold text-green1">Страница в разработке</h1>
            <p class="text-[30px] text-gray-700 pb-[40px]">Пока вы можете насладиться своими любимыми книгами!</p>
            <div>
                <router-link
                    class="bg-caramel text-white text-[24px] font-semibold py-[10px] px-[20px] rounded-md border-4 border-caramel pointer hover:text-caramel hover:bg-white mr-[20px]"
                    to="/catalog/books">К книгам!</router-link>
                <router-link
                    class="text-green1 font-semibold text-[24px] border-4 border-green1 rounded-md py-[10px] px-[30px] hover:border-brown hover:text-brown"
                    to="/adminPanel/user">Назад</router-link>
            </div>
        </div>
    </section>
</template>