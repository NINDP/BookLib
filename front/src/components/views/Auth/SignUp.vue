<script setup>
import axiosClient from "../../../axios-client.js";
import { ref } from "vue";
import { useRouter } from 'vue-router';

const router = useRouter();
const email = ref("");
const password = ref("");
const passwordConfirmation = ref("");
const nickname = ref("");

const onClick = (e) => {
    e.preventDefault();

    const payload = {
        nickname: nickname.value,
        email: email.value,
        password: password.value,
        password_confirmation: passwordConfirmation.value
    };

    const response = axiosClient.post('/signup', payload).then(({ data }) => {
        router.push('/login');
    })
    .catch(error => {
        console.error('Ошибка при входе:', error);
    });
};

console.log(email, password, nickname);
</script>

<template>
    <section>
        <form method="post" class="flex flex-col gap-2">
            <input type="text" v-model="nickname" class="w-[350px] border border-gray-600">
            <input type="email" v-model="email" class="w-[350px] border border-gray-600">
            <input type="password" v-model="password" class="w-[350px] border border-gray-600">
            <input type="password" v-model="passwordConfirmation" class="w-[350px] border border-gray-600">
            <button type="submit" @click="onClick">Login</button>
        </form>
    </section>
</template>

<style scoped>
</style>
