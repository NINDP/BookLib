<script setup>
import Header from '../Header.vue'
import Footer from '../Footer.vue'
</script>

<template>
    <section class="body">
        <Header></Header>
        <main class="min-h-[60vh]">
            <slot></slot>
        </main>
        <Footer></Footer>
    </section>
</template>