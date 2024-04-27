import { createRouter, createWebHistory } from "vue-router"
import MainPage from "../components/views/MainPage.vue"
import Books from "../components/views/Books.vue"
import Audiobooks from "../components/views/Audiobooks.vue"
import Login from "../components/views/Auth/Login.vue"
import SignUp from "../components/views/Auth/SignUp.vue"
import Profile from "../components/views/Profile.vue"
import EditProfile from '../components/views/EditProfile.vue'
import BookPage from '../components/views/BookPage.vue'
import BookPageGuest from "../components/views/BookPageGuest.vue"
import DescriptionBookPage from "../components/views/DescriptionBookPage.vue"
import Subscription from "../components/views/Subscription.vue"
import About_us from "../components/views/About_us.vue"
import AdminMain from '../components/views/Admin/AdminMain.vue'
import BookAdmin from "../components/views/Admin/BookAdmin.vue";
import ReviewBook from "../components/views/ReviewBook.vue";
import AppReviewAdmin from "../components/views/Admin/AppReviewAdmin.vue";
import AdminBookReview from "../components/views/Admin/AdminBookReview.vue";
import AdminBookSubscription from "../components/views/Admin/AdminBookSubscription.vue";
import Search from '../components/views/Search.vue'



const router = createRouter({
    routes: [
        {
            path: "/",
            name: "Main",
            component: MainPage,
        },
        {
            path: "/catalog/books",
            name: "Books",
            component: Books,
        },
        {
            path: "/catalog/audiobooks",
            name: "Audiobooks",
            component: Audiobooks,
        },
        {
            path: "/bookpage/:id",
            name: "DescriptionBookPage",
            component: DescriptionBookPage,
        },
        {
            path: "/book/:id",
            name: "BookPage",
            component: BookPage,
        },
        {
            path: "/book/:id/excerpt",
            name: "BookPageGuest",
            component: BookPageGuest,
        },
        {
            path: "/login",
            name: "login",
            component: Login,
        },
        {
            path: "/signup",
            name: "signup",
            component: SignUp,
        },
        {
            path: "/profile",
            name: "Profile",
            component: Profile,
            meta: { requiresAuth: true },
        },
        {
            path: "/profile/edit",
            name: "EditProfile",
            component: EditProfile,
            meta: { requiresAuth: true },
        },
        {
            path: "/subscription",
            name: "Subscription",
            component: Subscription,
        },
        {
            path: "/about_us",
            name: "AboutUs",
            component: About_us,
        },
        {
            path: "/adminPanel/user",
            name: "AdminMain",
            component: AdminMain,
            meta: { requiresAuth: true },
        },
        {
            path: "/adminPanel/book",
            name: "BookAdmin",
            component: BookAdmin,
            meta: { requiresAuth: true },
        },
        {
            path: "/adminPanel/appReview",
            name: "AppReviewAdmin",
            component: AppReviewAdmin,
            meta: { requiresAuth: true },
        },
        {
            path: "/review/:id",
            name: "ReviewBook",
            component: ReviewBook,
        },
        {
            path: "/adminPanel/bookReview",
            name: "AdminBookReview",
            component: AdminBookReview,
            meta: { requiresAuth: true },
        },
        {
            path: "/adminPanel/bookSubscription",
            name: "AdminBookSubscription",
            component: AdminBookSubscription,
            meta: { requiresAuth: true },
        },
        {
            path: "/search/:str",
            name: "Search",
            component: Search,
        },
    ],
    history: createWebHistory(),
});

router.beforeEach((to, from, next) => {
     const token = sessionStorage.getItem("ACCESS_TOKEN");
     if (to.matched.some((route) => route.meta.requiresAuth)) {
         if (token) {
             next();
         } else {
             next("/login");
         }
     } else {
         next();
     }
});

export default router;
