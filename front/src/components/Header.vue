<script>
import Button from './Button.vue'
export default {
    name: "Header",
    components:{
        Button
    }
}
</script>

<template>
<header class= "flex justify-between items-center py-4 font-font-open-sans">
    <router-link to="/"><img src="/logo.png" alt="logo" class="w-40"/></router-link>
    <div>
        <input type="text" class=" w-[250px] h-[35px] border-2 rounded-[20px] hover:border-caramel focus:outline-0 focus:border-green1 relative"/>
        <Button><img src="/search.png" alt="search" class="absolute top-[30px] left-[650px]"/></Button>
    </div>
    <div class="text-2xl flex gap-[80px]">
        <router-link to="catalog/audiobooks" class="hover:text-green1">Аудиокниги</router-link>
        <router-link to="/catalog/books" class="hover:text-green1">Книги</router-link>
        <router-link to="about_us" class="hover:text-green1">О нас</router-link>
    </div>
    <div class="flex gap-[40px]">
        <router-link to='/signup' class="text-2xl border border-green1 bg-green1 text-bgcolor py-2 px-6 hover:bg-bgcolor hover:text-green1">Регистрация</router-link>
        <router-link to='/login' class="text-2xl border border-caramel bg-caramel text-bgcolor py-2 px-16 hover:bg-bgcolor hover:text-caramel">Вход</router-link>
    </div>
</header>
</template>

<style>

</style>
