<script setup>
import LayoutMain from '../Layouts/LayoutMain.vue'
import axiosClient from '../../axios-client';
import { useRouter } from 'vue-router';
import { ref } from 'vue';

const dataProfile = ref({})
const oldPassword = ref("")
const newPassword = ref("")
const nickname = ref("")
const description = ref("")
const name_s = ref('')
const router = useRouter()
const currentP = ref("")
const showModal = ref(false)
const error = ref("")

const passwordValidation = (value) => {
    const minLength = 8;
    const hasNumber = /\d/.test(value);
    const hasUppercase = /[A-Z]/.test(value);
    const hasLowercase = /[a-z]/.test(value);

    if (value.length < minLength) {
        return 'Пароль должен содержать минимум 8 символов.';
    } else if (!hasNumber) {
        return 'Пароль должен содержать хотя бы одну цифру.';
    } else if (!hasUppercase) {
        return 'Пароль должен содержать хотя бы одну заглавную букву.';
    } else if (!hasLowercase) {
        return 'Пароль должен содержать хотя бы одну строчную букву.';
    }

    return null;
};

const onBlurPassword = (e) => {
    const passwordValue = e.target.value;
    error.value = passwordValidation(passwordValue);
};

axiosClient.get('/profile/edit').then(({ data }) => {
    dataProfile.value = data['user']
    name_s.value = data['subscription_name']
    nickname.value = data['user'].nickname
    description.value = data['user'].description
    if (dataProfile.value.path_to_photo == null) {
        dataProfile.value.path_to_photo = '/cat_avatarka.png'
    }
}).catch(error => {
    console.error(error);
});

const openModal = () => {
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
}

const saveChange = (e) => {
    e.preventDefault();

    const payload = {
        nickname: nickname.value,
        description: description.value
    };

    const response = axiosClient.post('/profile/edit', payload).then(({ data }) => {
        alert("Данные успешно изменены");
    })
        .catch(error => {
            console.error('Ошибка при отправке данных:', error);
        });
    router.push('/profile')

}

const changePassword = (e) => {
    e.preventDefault();

    if (oldPassword.value !== newPassword.value) {
        alert('Пароль и его подтверждение должны совпадать.');
        return;
    }

    const payload = {
        oldPassword: oldPassword.value,
        newPassword: newPassword.value,
    };

    const response = axiosClient.post('/profile/edit', payload).then(({ data }) => {
        alert("Пароль успешно изменён");
    })
        .catch(error => {
            console.error('Ошибка при изменении пароля:', error);
        });

    router.push('/profile')
}

const changeSubscription = () => {
    axiosClient.patch(`/profile/edit/${currentP.value}`).then(({ data }) => {
        closeModal();
        alert("Подписка успешно обновлена")
        name_s.value = data

    }).catch(error => {
        console.error('Ошибка при обновлении подписки:', error);
    });
}

const deleteUser = () => {
    console.log(dataProfile.value.id);
    axiosClient.delete(`/profile/edit/${dataProfile.value.id}`).then(({ data }) => {
        alert("Вы удалили профиль!")
        store.methods.setUser(false);
        store.methods.setProfileImageURL(null);
        sessionStorage.setItem("ACCESS_TOKEN", false)
        router.push('/login');
    }).catch(error => {
        console.error('Ошибка при удалении профиля:', error);
    });
}
</script>

<template>
    <LayoutMain>
        <section class="text-black-text border-2 rounded-md py-[60px] px-[100px]">
            <router-link
                class="text-green1 font-semibold text-[24px] border-2 border-green1 rounded-md py-[10px] px-[30px]"
                to="/profile">Назад</router-link>
            <img :src="dataProfile.path_to_photo"
                class="m-auto w-[150px] h-[150px] border-2 border-green1 rounded-full px-[5px] py-[5px]" />
            <section class="flex justify-around text-[24px] pt-[20px]">
                <div class="grid">
                    <label class="py-[10px]">
                        Введите nickname
                    </label>
                    <input class="border-2 border-caramel bg-bgcolor px-[10px] rounded-md" type="text"
                        v-model="nickname" placeholder="nickname" />
                    <label class="pt-[20px] pb-[10px]">
                        Расскажите о себе
                    </label>
                    <textarea rows="7" class="border-2 border-caramel bg-bgcolor px-[10px] rounded-md mb-[40px]"
                        type="text" v-model="description" placeholder="description"></textarea>
                    <button class="text-[24px] font-semibold bg-green1 text-white py-[7px] px-[30px] rounded-md pointer"
                        @click="saveChange">Сохранить изменения</button>

                    <label class="font-semibold text-[31px] text-green1 pt-[40px] pb-[15px]">Подписка</label>
                    <select class="border-2 border-gray-600 rounded-md py-[5px]" v-model="currentP">
                        <option value="">Выберите тариф</option>
                        <option value="1" selected>Стандарт</option>
                        <option value="2">Расширенная</option>
                        <option value="3">Расширенная+</option>
                    </select>
                    <p v-if="name_s" class="pb-[20px] pt-[10px]">Ваш тариф: {{ name_s }}</p>
                    <p v-if="!name_s" class="pb-[20px] pt-[10px]">У вас пока нет тарифа</p>
                    <button class="font-semibold bg-green1 text-white py-[5px] rounded-md pointer"
                        @click="openModal">Подтвердить</button>
                    <div v-if="showModal"
                        class="fixed top-0 left-0 w-full h-full flex justify-center items-center bg-gray-900 bg-opacity-50 z-10">
                        <div class="relative bg-white p-8 rounded-md max-w-lg z-50">
                            <h2 class="text-xl font-semibold pt-4 pb-8">Вы уверены, что хотите сменить подписку?</h2>
                            <div class="flex justify-end">
                                <button class="rounded-md text-bgcolor bg-green1 px-[20px] py-[10px] mr-4"
                                    @click="changeSubscription">Да</button>
                                <button class="rounded-md px-[20px] py-[10px] text-bgcolor bg-red-600"
                                    @click="closeModal">Нет</button>
                                <button @click="closeModal"
                                    class="absolute top-0 right-0 bg-gray-100 px-2 rounded-full text-red-500 mt-2 mr-2 text-lg">X</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid h-fit w-[320px]">
                    <h2 class="text-[32px] font-semibold pb-[20px]">Изменение пароля</h2>
                    <label class="pb-[10px]">
                        Введите старый пароль
                    </label>
                    <input class="border-2 border-caramel bg-bgcolor px-[10px] rounded-md" v-model="oldPassword"
                        type="password" placeholder="******" />
                    <label class="pt-[20px] pb-[10px]">
                        Введите новый пароль
                    </label>
                    <input class="border-2 border-caramel bg-bgcolor px-[10px] rounded-md mb-[20px]"
                        v-model="newPassword" type="password" placeholder="******" @blur="onBlurPassword" />

                    <p class="text-red-600 pb-[10px]" v-if="error">{{ error }}</p>

                    <button class="font-semibold bg-green1 text-white py-[5px] rounded-md pointer"
                        @click="changePassword">Изменить пароль</button>
                </div>
            </section>
            <button @click="deleteUser"
                class="mr-[20px] text-[24px] font-semibold bg-red-600 text-white py-[7px] px-[30px] float-end rounded-md">Удалить
                профиль</button>
        </section>
    </LayoutMain>
</template>
