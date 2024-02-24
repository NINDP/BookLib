<script>
import axiosClient from "../../axios-client.js";
import Book from "../Book.vue";

export default {
    name: 'Books',
    components:{
        Book
    },
    data() {
        return {
            books: []
        };
},
    mounted() {
        axiosClient.get('/catalog/books')
            .then(response => {
                this.books = response.data;
                console.log(response.data)
            })
            .catch(error => {
                console.error('Error fetching books:', error);
            });
    }
};
</script>

<template>
    <Book v-for="book in books" :key="book.id" :title="book.title" :src_img="book.path_to_image" :author="book.author"></Book>
</template>

<style>

</style>
