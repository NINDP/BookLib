<script setup>
import LayoutAdmin from '../../Layouts/LayoutAdmin.vue';
import axiosClient from '../../../axios-client';
import { ref } from 'vue';

const books = ref({})
const isCreate = ref(false)
const isError = ref(false)
const author = ref('')
const title = ref('')
const content = ref('')
const description = ref('')
const type = ref('book')
const imageFile = ref(null);
const audioFile = ref(null);

axiosClient.get('/adminPanel/book').then(response => {
    books.value = response.data;
}).catch(error => {
    console.error(error);
});

const createBook = () => {
    const formData = new FormData();
    formData.append('author', author.value);
    formData.append('title', title.value);
    formData.append('content', content.value);
    formData.append('description', description.value);
    formData.append('type', type.value);

    if (imageFile.value) {
        formData.append('path_to_image', imageFile.value);
    }

    if (audioFile.value) {
        formData.append('path_to_audio', audioFile.value);
    }
    axiosClient.post('/adminPanel/book/create', formData , {
        headers: {
            'Content-Type':'multipart/form-data',
            Authorization: `Bearer ${sessionStorage.getItem('ACCESS_TOKEN')}`,
        }
    }).then(response => {
        books.value = response.data;
        author.value = '';
        title.value = '';
        content.value = '';
        description.value = '';
        imageFile.value = null;
        audioFile.value = null;
        type.value = 'book';
        isCreate.value = false;
    }).catch(error => {
        console.error(error);
    });
}

const handleImageUpload = (event) => {
    imageFile.value = event.target.files[0];
}

const handleAudioUpload = (event) => {
    audioFile.value = event.target.files[0];
}

const deleteBook = (bookId) => {
    axiosClient.delete(`/adminPanel/book/${bookId}`).then(response => {
        const index = books.value.findIndex(book => book.id === bookId);
        if (index !== -1) {
            books.value.splice(index, 1);
        }
    }).catch(error => {
        console.error(error);
    });
}

const cancel = () => {
    isCreate.value = false
    isError.value = false
    author.value = ''
    title.value = ''
    content.value = ''
    description.value = ''
    imageFile.value = null
    audioFile.value = null
    type.value = 'book'
}
</script>


<template>
    <LayoutAdmin>
        <section class="overflow-x-auto">
            <table class="w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left">author</th>
                        <th class="py-3 px-6 text-left">title</th>
                        <th class="py-3 px-6 text-left">content</th>
                        <th class="py-3 px-6 text-left">description</th>
                        <th class="py-3 px-6 text-left">path_to_image</th>
                        <th class="py-3 px-6 text-left">path_to_audio</th>
                        <th class="py-3 px-6 text-left">type</th>
                        <th class="py-3 px-6 text-left">Удалить</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    <tr v-for="book in books" :key="book.id">
                        <td class="py-4 px-6 border-2">{{ book.author }}</td>
                        <td class="py-4 px-6 border-2">{{ book.title }}</td>
                        <td class="py-4 px-6 border-2">
                            <p class="max-h-[20em] overflow-hidden">{{ book.content }}</p>
                        </td>
                        <td class="py-4 px-6 border-2">
                            <p class="max-h-[20em] overflow-hidden">{{ book.description }}</p>
                        </td>
                        <td class="py-4 px-6 border-2">{{ book.path_to_image }}</td>
                        <td class="py-4 px-6 border-2">{{ book.path_to_audio }}</td>
                        <td class="py-4 px-6 border-2">{{ book.type }}</td>
                        <td class="py-4 px-6 border-2">
                            <button @click="deleteBook(book.id)"
                                class="bg-red-600 px-4 py-2 text-white font-semibold rounded-md">Х</button>
                        </td>
                    </tr>
                    <tr v-if="isCreate">
                        <td class="py-4 px-6 border-2"><input v-model="author" class="border-2 border-gray-500 p-2" />
                        </td>
                        <td class="py-4 px-6 border-2"><input v-model="title" class="border-2 border-gray-500 p-2" />
                        </td>
                        <td class="py-4 px-6 border-2"><input v-model="content" class="border-2 border-gray-500 p-2" />
                        </td>
                        <td class="py-4 px-6 border-2"><input v-model="description"
                                class="border-2 border-gray-500 p-2" /></td>
                        <td class="py-4 px-6 border-2"><input type="file" @change="handleImageUpload" /></td>
                        <td class="py-4 px-6 border-2"><input type="file" @change="handleAudioUpload" /></td>
                        <td class="py-4 px-6 border-2">
                            <select v-model="type" class="border-2 border-gray-500 p-2">
                                <option value="book" selected>book</option>
                                <option value="audio">audio</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="text-[24px] text-red-600" v-if="isError">Введите все данные в верном формате</p>
            <div class="mt-4">
                <button v-if="!isCreate" @click="isCreate = true"
                    class="bg-caramel px-4 py-2 text-white font-semibold rounded-md">+</button>
                <button v-if="isCreate" @click="cancel"
                    class="bg-red-600 px-4 py-2 text-white font-semibold rounded-md mx-[10px]">Отмена</button>
                <button v-if="isCreate" @click="createBook"
                    class="bg-caramel px-4 py-2 text-white font-semibold rounded-md">Сохранить</button>
            </div>
        </section>
    </LayoutAdmin>
</template>
