<script setup>
import LayoutAdmin from '../../Layouts/LayoutAdmin.vue';
import axiosClient from '../../../axios-client';
import { ref } from 'vue';

const appReviews = ref({})

axiosClient.get('/adminPanel/appReview').then(response => {
    appReviews.value = response.data;
})
    .catch(error => {
        console.error(error);
    });


const deleteAppReview = (appReviewId) => {
    axiosClient.delete(`/adminPanel/appReview/${appReviewId}`).then(response => {
        const index = appReviews.value.findIndex(appReview => appReview.id === appReviewId);
        if (index !== -1) {
            appReviews.value.splice(index, 1);
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
                        <th class="py-3 px-6 text-left">Удалить</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    <tr v-for="appReview in appReviews" :key="appReview.id">
                        <td class="py-4 px-6 border-2">{{ appReview.content }}</td>
                        <td class="py-4 px-6 border-2">{{ appReview.count_star }}</td>
                        <td class="py-4 px-6 border-2">{{ appReview.user_id }}</td>
                        <td class="py-4 px-6 border-2">
                            <button @click="deleteAppReview(appReview.id)"
                                class="bg-red-600 px-4 py-2 text-white font-semibold rounded-md">Х</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </LayoutAdmin>
</template>
