<script setup>
import Button from '../Button.vue';
</script>

<template>
    <header class="flex items-center justify-between pt-2">
        <a href="#"><img class="logo-img" src="../../assets/Лого 2.png" alt="logo" /></a>
        <div class="relative">
            <input type="text" class="border-2 hover:border-brown rounded-3xl px-1.5 relative " />
            <Button class="absolute left-170px inset-y-1"><img src="../../assets/Search.png" /></Button>
        </div>
        <nav class="font-semibold">
            <a class="cursor-pointer pl-7 hover:text-green" href="#">Книги</a>
            <a class="cursor-pointer pl-7 hover:text-green" href="#">Аудиокниги</a>
            <a class="cursor-pointer pl-7 hover:text-green" href="#">О нас</a>
        </nav>
        <div class="">
            <Button class="w-40 py-2 border-2 border-green text-green  bg-bgcolor hover:bg-green hover:text-bgcolor">Регистрация</Button>
            <Button class="w-40 py-2 border-2 border-brown text-bgcolor bg-brown ml-2.5 hover:bg-bgcolor hover:text-brown">Вход</Button>
        </div>
    </header>
    <main>
        <section class="pt-16">
            <h1 class="text-4xl font-semibold pb-3"><span class="text-brown ">BookLib</span> - лучший сервис для чтения книг</h1>
            <p class="text-lg text-zinc-500 max-w-xl">Присоединяйтесь к нашей платформе и мы поможем вам провести вечер с пользой с любимой книгой!</p>
            <img class="pt-20 pb-16 w-full" src="../../assets/Books.png" />
            <hr class="border-1 border-brown" />
        </section>
    </main>
</template>

<style scoped>
</style>
