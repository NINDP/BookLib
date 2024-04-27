<script setup>
import LayoutAdmin from '../../Layouts/LayoutAdmin.vue';
import axiosClient from '../../../axios-client';
import { ref } from 'vue';

const bookReviews = ref({})

axiosClient.get('/adminPanel/bookReview').then(response => {
    bookReviews.value = response.data;
})
    .catch(error => {
        console.error(error);
    });


const deleteBookReview = (bookReviewId) => {
    axiosClient.delete(`/adminPanel/bookReview/${bookReviewId}`).then(response => {
        const index = bookReviews.value.findIndex(bookReview => bookReview.id === bookReviewId);
        if (index !== -1) {
            bookReviews.value.splice(index, 1);
        }
    })
        .catch(error => {
            console.error(error);
        });
}

</script>

<template>
    <LayoutAdmin>
        <section class="overflow-x-auto">
            <table class="w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left">content</th>
                        <th class="py-3 px-6 text-left">count_star</th>
                        <th class="py-3 px-6 text-left">user_id</th>
                        <th class="py-3 px-6 text-left">book_id</th>
                        <th class="py-3 px-6 text-left">Удалить</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    <tr v-for="bookReview in bookReviews" :key="bookReview.id">
                        <td class="py-4 px-6 border-2">{{ bookReview.content }}</td>
                        <td class="py-4 px-6 border-2">{{ bookReview.count_star }}</td>
                        <td class="py-4 px-6 border-2">{{ bookReview.user_id }}</td>
                        <td class="py-4 px-6 border-2">{{ bookReview.book_id }}</td>
                        <td class="py-4 px-6 border-2">
                            <button @click="deleteBookReview(bookReview.id)"
                                class="bg-red-600 px-4 py-2 text-white font-semibold rounded-md">Х</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </LayoutAdmin>
</template>
