<script setup>
import LayoutMain from '../Layouts/LayoutMain.vue'
</script>

<template>
    <LayoutMain>
        <section class="flex justify-between text-black_text">
            <div>
                <h1 class="text-[44px] font-bold pt-[100px] pb-[30px]">Узнайте больше о нашей платформе</h1>
                <p class="text-[24px] text-gray-600 w-[800px]">BookLib может предложить вам большой ассортимент книг и
                    аудиокниг, в которых вы сможете найти поддержку,
                    интересные истории, материалы для развития и многое другое. Мы гарантируем, что c BookLib вы приятно
                    проведёте вечер или небольшой перерыв. Присоединяйся к нам.</p>
            </div>
            <img class="w-[800px]" src="/BookLib.gif" />
        </section>
        <section class="flex justify-around text-black_text">
            <img class="w-[500px]" src="/Book_about_us.png" />
            <div class="w-[800px]">
                <h2 class="text-[36px] font-semibold pb-[20px]">Aссортимент <span
                        class="text-green1 font-bold">BookLib</span> насчитывает</h2>
                <ul class="pl-[30px] text-[24px] list-disc marker:text-green1">
                    <li>
                        Более 10 книг
                    </li>
                    <li>
                        Более 10 аудиокниг
                    </li>
                    <li>
                        Три вида подписки
                    </li>
                </ul>
            </div>
        </section>
        <section class="flex justify-around items-center pt-[200px] text-black_text">
            <div>
                <h2 class="text-[36px] font-semibold pb-[20px]">Подписки на платформе <span
                        class="text-caramel font-bold">BookLib</span>:
                </h2>
                <ul class="pl-[30px] text-[24px] list-disc marker:text-caramel">
                    <li>
                        Базовая
                    </li>
                    <li>
                        Расширенная
                    </li>
                    <li>
                        Семейная
                    </li>
                </ul>
            </div>
            <div>
                <p class="text-[24px] max-w-[600px] text-gray-700 pb-[40px]">Оформите одну из подписок, чтобы полноценно наслаждаться новыми книгами и аудиокнигами</p>
                <router-link to="/subscription"
                    class="text-[24px] font-semibold bg-green1 text-white py-[7px] px-[30px] rounded-md">Оформить</router-link>
            </div>
        </section>
    </LayoutMain>
</template>