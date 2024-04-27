<script setup>
import LayoutMain from '../../Layouts/LayoutMain.vue'
import axiosClient from "../../../axios-client.js";
import { useRouter } from 'vue-router';
import { ref } from "vue";
import store from "../../../store";

const router = useRouter();
const email = ref("");
const password = ref("");
const errorMessage = ref("")

function setErrorMessage(error) {
    errorMessage.value = error
}

const onClick = (e) => {
    e.preventDefault();

    const payload = {
        email: email.value,
        password: password.value
    }

    axiosClient.post('/login', payload, { withCredentials: true })
        .then(({ data }) => {
            if (data.token != null || data.token != undefined) {
                sessionStorage.setItem("ACCESS_TOKEN", data.token.original.token)
                store.methods.setUser(sessionStorage.getItem('ACCESS_TOKEN'));
                store.methods.setIsAdmin(data.isAdmin);
                if (data.isAdmin) {
                    router.push('/adminPanel/user');
                } else {
                    router.push('/profile');
                }
            }
            else {
                setErrorMessage("Введите корректные данные")
            }
        })
        .catch(error => {
            console.error('Ошибка при входе:', error);
        });
}
</script>

<template>
    <LayoutMain>
        <section class="flex items-center justify-center h-[900px]">
            <article class="border border-[#BDB8B8] rounded align-middle">
                <h1 class="text-[50px] text-caramel text-center font-bold pt-[40px]">Вход</h1>
                <form method="post" class="flex flex-col gap-4 py-[40px] px-[120px]">
                    <input type="email" v-model="email" placeholder="Введите email"
                        class="w-[550px] border-2 border-[#BDB8B8] pl-[5px] rounded text-[24px]">
                    <input type="password" v-model="password" placeholder="Введите пароль"
                        class="w-[550px] border-2 border-[#BDB8B8] pl-[5px] rounded text-[24px]">
                    <a class="text-[#417DB4] underline text-[20px]" href="#">Забыли пароль?</a>
                    <p class="text-red-600 font-semibold text-xl">{{ errorMessage }}</p>
                    <button type="submit" @click="onClick"
                        class="w-[550px] bg-green1 py-[5px] text-bgcolor font-bold hover:text-green1 hover:bg-bgcolor hover:border-2 hover:border-green1 text-[24px]">Вход</button>
                    <div class="flex text-[20px]">
                        <p class="pr-[5px]">Ещё нет аккаунта?</p><router-link to="/signup"
                            class="text-[#417DB4] underline">Зарегистрируйтесь</router-link>
                    </div>
                </form>
            </article>
        </section>
    </LayoutMain>
</template>

<style scoped></style>
