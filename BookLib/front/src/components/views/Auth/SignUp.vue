<script setup>
import LayoutMain from '../../Layouts/LayoutMain.vue'
import axiosClient from "../../../axios-client.js";
import { ref } from "vue";
import { useRouter } from 'vue-router';

const router = useRouter();
const email = ref("");
const password = ref("");
const passwordConfirmation = ref("");
const nickname = ref("");
const path_to_photo = ref("");
const description = ref("");
const id_subscription = ref()
const error = ref("")
const errorEmail = ref("")

const passwordValidation = (value) => {
    const minLength = 8;
    const hasNumber = /\d/.test(value);
    const hasUppercase = /[A-Z]/.test(value);
    const hasLowercase = /[a-z]/.test(value);

    if (value.length < minLength) {
        return 'Пароль должен содержать минимум 8 символов.';
    } else if (!hasNumber) {
        return 'Пароль должен содержать хотя бы одну цифру.';
    } else if (!hasUppercase) {
        return 'Пароль должен содержать хотя бы одну заглавную букву.';
    } else if (!hasLowercase) {
        return 'Пароль должен содержать хотя бы одну строчную букву.';
    }

    return null;
};

const onBlurPassword = (e) => {
    const passwordValue = e.target.value;
    error.value = passwordValidation(passwordValue);
};

const emailValidation = (value) => {
    const isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);

    if (!isValidEmail) {
        return 'Пожалуйста, введите корректный адрес электронной почты.';
    }

    return null;
};

const onBlurEmail = (e) => {
    const emailValue = e.target.value;
    errorEmail.value = emailValidation(emailValue);
};

const onClick = (e) => {
    e.preventDefault();

    if (!nickname.value || !email.value || !password.value || !passwordConfirmation.value) {
        alert('Пожалуйста, заполните все обязательные поля.');
        return;
    }

    if (password.value !== passwordConfirmation.value) {
        alert('Пароль и его подтверждение должны совпадать.');
        return;
    }

    const payload = {
        nickname: nickname.value,
        email: email.value,
        password: password.value,
        password_confirmation: passwordConfirmation.value,
        path_to_photo: path_to_photo.value,
        description: description.value,
        id_subscription: id_subscription.value
    };

    const response = axiosClient.post('/signup', payload).then(({ data }) => {
        router.push('/login');
    })
        .catch(error => {
            console.error('Ошибка при регистрации:', error);
        });
};
</script>

<template>
    <LayoutMain>
        <section class="flex items-center justify-center h-[900px]">
            <article class="border border-[#BDB8B8] rounded align-middle">
                <h1 class="text-[50px] text-caramel text-center font-bold pt-[40px]">Регистрация</h1>
                <form method="post" class="flex flex-col gap-4 py-[40px] px-[120px]">

                    <input type="text" v-model="nickname" placeholder="Введите nickname"
                        class="w-[550px] border-2 border-[#BDB8B8] pl-[5px] rounded text-[24px]">

                    <input type="email" v-model="email" placeholder="Введите email"
                        class="w-[550px] border-2 border-[#BDB8B8] pl-[5px] rounded text-[24px]" @blur="onBlurEmail">
                    <p class="text-red-600" v-if="errorEmail">{{ errorEmail }}</p>

                    <input type="password" v-model="password" placeholder="Введите пароль"
                        class="w-[550px] border-2 border-[#BDB8B8] pl-[5px] rounded text-[24px]" @blur="onBlurPassword">
                    <p class="text-red-600" v-if="error">{{ error }}</p>

                    <input type="password" v-model="passwordConfirmation" placeholder="Подтвердите пароль"
                        class="w-[550px] border-2 border-[#BDB8B8] pl-[5px] rounded text-[24px]">

                    <button
                        class="w-[550px] bg-green1 py-[5px] text-bgcolor font-bold hover:text-green1 hover:bg-bgcolor hover:border-2 hover:border-green1 text-[24px]"
                        type="submit" @click="onClick">Регистрация</button>
                    <div class="flex text-[20px]">
                        <p class="pr-[5px]">Есть аккаунт?</p><router-link to="/signup"
                            class="text-[#417DB4] underline">Войдите</router-link>
                    </div>
                </form>
            </article>
        </section>
    </LayoutMain>
</template>

<style scoped></style>
