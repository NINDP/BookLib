import { createRouter, createWebHistory } from "vue-router";
import MainPage from "../components/views/MainPage.vue";
import Books from "../components/views/Books.vue";
import Login from "../components/views/Auth/Login.vue";
import SignUp from "../components/views/Auth/SignUp.vue";


const router = createRouter({
    routes: [
        {
            path: "/",
            name: "Main",
            component: MainPage,
        },
        {
            path:'/catalog/books',
            name:"Books",
            component: Books,
        },
        {
            path:'/login',
            name:"login",
            component: Login,
        },
        {
            path:'/signup',
            name:"signup",
            component: SignUp,
        }
    ],
    history: createWebHistory(),
});

export default router;
