<script>
export default {
    name: "Book",
    props:{
        title: String,
        author: String,
        src_img: String,
    }
}
</script>

<template>
<main>
    <img :src="src_img" alt="book_photo" class="h-[300px]"/>
    <p>{{title}}</p>
    <p>{{author}}</p>
</main>
</template>

<style scoped>

</style>
