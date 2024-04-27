<script setup>
import LayoutAdmin from '../../Layouts/LayoutAdmin.vue';
import axiosClient from '../../../axios-client';
import { ref } from 'vue';

const users = ref({})

axiosClient.get('/adminPanel/user').then(response => {
    users.value = response.data;
})
    .catch(error => {
        console.error(error);
    });


const deleteUser = (userId) => {
    axiosClient.delete(`/adminPanel/user/${userId}`).then(response => {
        const index = users.value.findIndex(user => user.id === userId);
        if (index !== -1) {
            users.value.splice(index, 1);
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
                        <th class="py-3 px-6 text-left">id</th>
                        <th class="py-3 px-6 text-left">nickname</th>
                        <th class="py-3 px-6 text-left">description</th>
                        <th class="py-3 px-6 text-left">path_to_photo</th>
                        <th class="py-3 px-6 text-left">email</th>
                        <th class="py-3 px-6 text-left">id_subscription</th>
                        <th class="py-3 px-6 text-left">Удалить</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    <tr v-for="user in users" :key="user.id">
                        <td class="py-4 px-6 border-2">{{ user.id }}</td>
                        <td class="py-4 px-6 border-2">{{ user.nickname }}</td>
                        <td class="py-4 px-6 border-2">{{ user.description }}</td>
                        <td class="py-4 px-6 border-2">{{ user.path_to_photo }}</td>
                        <td class="py-4 px-6 border-2">{{ user.email }}</td>
                        <td class="py-4 px-6 border-2">{{ user.id_subscription }}</td>
                        <td class="py-4 px-6 border-2">
                            <button v-if="!user.isAdmin" @click="deleteUser(user.id)"
                                class="bg-red-600 px-4 py-2 text-white font-semibold rounded-md">Х</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </LayoutAdmin>
</template>
