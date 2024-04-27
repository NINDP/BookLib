<script setup>

</script>

<template>
    <div class="flex items-start">
        <nav class="w-[500px] bg-gray-100 flex flex-col text-[24px] font-semibold min-h-[89vh] px-[40px] py-[20px]">
            <router-link class="pb-[15px] hover:text-green1" to="/adminPanel/book">Книги</router-link>
            <router-link class="pb-[15px] hover:text-green1" to="/adminPanel/appReview">Отзывы на
                приложение</router-link>
            <router-link class="pb-[15px] hover:text-green1" to="/adminPanel/bookReview">Отзывы на книги</router-link>
            <router-link class="pb-[15px] hover:text-green1" to="/adminPanel/bookSubscription">Подписки на книги</router-link>
            <router-link class="hover:text-green1" to="/adminPanel/user">Пользователи</router-link>
        </nav>
        <slot></slot>
    </div>
</template>