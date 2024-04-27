import { reactive } from "vue";

const defaultProfileImageURL = null;
const storedProfileImageURL = localStorage.getItem('profileImageURL');
const initialState = {
    user: {
        isAuthenticated: false,
        isAdmin: false,
        profileImageURL: storedProfileImageURL ? JSON.parse(storedProfileImageURL) : defaultProfileImageURL,
    },
};

const state = reactive(initialState);

const methods = {
    setUser(payload) {
        state.user.isAuthenticated = payload ? true : false;
    },
    setIsAdmin(isAdmin) {
        state.user.isAdmin = isAdmin ? true : false;
    },
    setProfileImageURL(url) {
        state.user.profileImageURL = url;
        localStorage.setItem('profileImageURL', JSON.stringify(url));
    },
};

export default {
    state,
    methods,
};
