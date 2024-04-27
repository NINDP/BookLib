<script setup>
defineProps({
    name: String,
    cost: Number,
    adv1: String,
    adv2: String,
    path: String,
})
</script>

<template>
    <article class="text-black_text border-2 border-gray-400 rounded-md w-[500px] py-[40px] px-[30px]">
        <h2 class="text-center text-[32px] font-semibold">
            {{name}}
        </h2>
        <img class="h-[300px] py-[10px]" :src="path" />
        <h3 class="text-[30px] font-semibold pt-[20px]">Преимущества</h3>
        <ul class="pl-[30px] pt-[20px] text-[24px] list-disc marker:text-brown h-[150px]">
            <li>
                {{ adv1 }}
            </li>
            <li>
                {{ adv2 }}
            </li>
        </ul>
        <div class="text-center">
            <p class="text-[24px] text-center font-semibold py-[30px]">{{ cost }} руб./месяц</p>
            <router-link to="/profile/edit"
                class="text-[20px] border-2 border-caramel bg-caramel text-bgcolor py-2 px-20 hover:bg-bgcolor hover:text-caramel rounded-[5px] float-center">Оформить</router-link>
        </div>
    </article>
</template>

<style scoped>

</style>
