<script setup>
import { computed, onBeforeMount, ref } from 'vue'
import { useRouter } from 'vue-router';
import store from '../store/index'

onBeforeMount(() => {
    store.methods.setUser(sessionStorage.getItem('ACCESS_TOKEN'))
})

const user = computed(() => store.state.user);
const searchText = ref('')
const router = useRouter();

const logout = () => {
    sessionStorage.removeItem('ACCESS_TOKEN');
    store.methods.setUser(false);
    router.push('/login');
}

const search = () => {
    if (searchText.value) {
        router.push(`/search/${searchText.value}`)
    }
}
</script>

<template>
    <header class="flex justify-between items-center py-6 font-font-open-sans">
        <router-link v-if="!user.isAuthenticated" to="/"><img src="/logo.png" alt="logo" class="w-40" /></router-link>
        <router-link v-if="user.isAuthenticated" to="/profile"><img src="/logo.png" alt="logo"
                class="w-40" /></router-link>

        <div class="w-[270px] h-[40px] relative">
            <input v-model="searchText" type="text" class="w-[270px] h-[40px] border-2 rounded-[20px] hover:border-caramel focus:outline-0
                focus:border-green1 px-[10px]" />
            <button @click="search"><img src="/search.png" alt="search"
                    class="absolute top-2 right-0 w-[50px]" /></button>
        </div>

        <div class="text-[24px] flex gap-[80px] font-medium text-black-text">
            <router-link to="/catalog/audiobooks" class="hover:text-green1">Аудиокниги</router-link>
            <router-link to="/catalog/books" class="hover:text-green1">Книги</router-link>
            <router-link to="/about_us" class="hover:text-green1">О нас</router-link>
        </div>
        <div class="flex gap-[40px] font-semibold">
            <router-link v-if="!user.isAuthenticated" to='/signup'
                class="text-[20px] border-2 border-green1 bg-green1 text-bgcolor py-2 px-10 hover:bg-bgcolor hover:text-green1 rounded-[5px] ">Регистрация</router-link>
            <router-link v-if="!user.isAuthenticated" to='/login'
                class="text-[20px] border-2 border-caramel bg-caramel text-bgcolor py-2 px-20 hover:bg-bgcolor hover:text-caramel rounded-[5px]">Вход</router-link>
            <router-link v-if="user.isAuthenticated && user.profileImageURL" class="text-green1" to="/profile"><img
                    class="w-[80px] h-[80px] border-2 border-green1 px-[1px] py-[1px] rounded-full hover:border-brown"
                    :src="user.profileImageURL" alt="photo_avatarka" />
            </router-link>
            <router-link v-if="!user.profileImageURL && user.isAuthenticated" class="text-green1" to="/profile"><img
                    class="w-[80px] h-[80px] border-2 border-green1 px-[5px] py-[5px] rounded-full hover:border-brown"
                    src="/cat_avatarka.png" alt="photo_avatarka" />
            </router-link>
        </div>
        <button v-if="user.isAuthenticated"
            class="text-[20px] border-2 border-red-600 bg-red-600 text-bgcolor py-2 px-16 hover:bg-bgcolor hover:text-red-600 rounded-[5px]"
            @click="logout">Выход</button>
    </header>
</template>

<style></style>
