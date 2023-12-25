<script setup>
import Button from '../Button.vue';
</script>

<template>
    <header class="head">
        <a href="#"><img class="logo-img" src="../../assets/Лого 2.png" alt="logo" /></a>
        <input type="text" class="border-2 border-brown rounded-3xl px-1.5" />
        <img src="../../assets/Search.png"/>
        <nav class="navigate">
            <a class="cursor-pointer" href="#">Книги</a>
            <a class="cursor-pointer" href="#">Аудиокниги</a>
            <a class="cursor-pointer" href="#">О нас</a>
        </nav>
        <div class="btns">
            <Button class="btn-signup">Регистрация</Button>
            <Button class="btn-login">Вход</Button>
        </div>
    </header>
    <main>
        <section class="main_section">
            <h1 class="header-text"><span class="logo-text">BookLib</span> - лучший сервис для чтения книг</h1>
            <p class="p-description">Мы поможем вам провести вечер с пользой с любимой книгой!</p>
            <img class="books-img_main" src="../../assets/Books.png" />
            <hr class="line_main"/>
        </section>
    </main>
</template>

<style scoped>
.head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
}

.logo-img {
    width: 70px;
    height: 100px;
}


.navigate {
    font-size: 20px;
}

.link_nav {
    padding: 0 30px;
    text-decoration: none;
    color: #161616;
    font-weight: 600;
}

.link_nav:hover {
    color: #1F7C65;
}

.btn-signup {
    color: #1F7C65;
    background-color: #fbfbfb;
    border: 3px solid #1F7C65;
}

.btn-signup:hover {
    color: #fbfbfb;
    background-color: #1F7C65;
}

.btn-login {
    color: #fbfbfb;
    background-color: #855B32;
    border: 3px solid #855B32;
}

.btn-login:hover {
    color: #855B32;
    background-color: #fbfbfb;
}

.btns {
    display: flex;
    gap: 20px;
}

.input-search {
    width: 250px;
    height: 15px;
    padding: 10px;
    border-radius: 30px;
}

.header-text {
    font-size: 40px;
}

.logo-text {
    color: #855B32;
}

.main_section {
    padding: 110px 0;
}

.p-description {
    font-size: 24px;
    padding: 30px 0 0;
}

.books-img_main{
    width: 1600px;
    padding: 80px 0 100px;
}

.line_main{
    border: 1px solid #855B32;
}

</style>
