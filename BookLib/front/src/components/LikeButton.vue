<script setup>
import { ref } from 'vue';
import axiosClient from '../axios-client.js'

const { id, isLike } = defineProps({
    id: Number,
    isLike: Boolean
});

const isLikeValue = ref(isLike);

function toggleLike() {
    isLikeValue.value = !isLikeValue.value;
    if (!isLikeValue.value) {
        axiosClient.delete(`/catalog/books/${id}`).then(response => {
            console.log('Лайк удален успешно');
        }).catch(error => {
            console.error('Ошибка при удалении лайка:', error);
        });
    } else {
        const payload = {
            id_book: id
        }
        axiosClient.post(`/catalog/books`, payload).then(response => {
            console.log('Лайк добавлен успешно');
        }).catch(error => {
            console.error('Ошибка при добавлении лайка:', error);
        });
    }
}
</script>

<template>
    <button @click="toggleLike">
        <img v-if="isLikeValue" src="/Heart.png" />
        <img v-else src="/Favorite.png" />
    </button>
</template>
