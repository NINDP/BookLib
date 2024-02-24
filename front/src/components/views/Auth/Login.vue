<script setup>
import axiosClient from "../../../axios-client.js";
import { useRouter } from 'vue-router';
import { ref } from "vue";

const router = useRouter();
const email = ref("");
const password = ref("");

const onClick = (e) => {
    e.preventDefault();

    const payload = {
        email: email.value,
        password: password.value,
    }

    axiosClient.post('/login', payload)
        .then(({ data }) => {
            router.push('/');
        })
        .catch(error => {
            console.error('Ошибка при входе:', error);
        });
}

</script>

<template>
    <section>
        <form method="post" class="flex flex-col gap-2">
            <input type="email" v-model="email" class="w-[350px] border border-gray-600">
            <input type="password" v-model="password" class="w-[350px] border border-gray-600">
            <button type="submit" @click="onClick">Login</button>
        </form>
    </section>
</template>

<style scoped>

</style>
