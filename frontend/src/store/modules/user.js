import {getHeaderSnippet, getToken, setToken} from "@/utils/common";
import $host from "@/api/config";
import {getInfo, login, register} from "@/services/UserService";

export const user = {
    state: {
        isAuth: false,
        info: {},
    },
    getters: {},
    mutations: {
        setInfo(state, info) {
            state.info = info;
        },
        setIsAuth(state, bool) {
            state.isAuth = bool;
        }
    },
    actions: {
        async authorization({commit}) {
            return getInfo()
                .then(response => {
                    if (response.data.code === 200) {
                        commit('setIsAuth', true);
                        commit('setInfo', response.data.message);
                    }
                }).catch(error => {
                    console.log(error);
                })

        },
        async login({commit, dispatch}, {email, password}) {
            return login(email, password)
                .then((response) => {
                    if (response.data.code === 200) {
                        setToken(response.data.message.token);
                        commit('setIsAuth', true);
                        dispatch('fillInfo');
                    }
                })
        },
        async register({commit, dispatch}, {name, email, password, password_confirmation}) {
            return register(name, email, password, password_confirmation)
                .then((response) => {
                    if (response.data.code === 200) {
                        setToken(response.data.message.token);
                        commit('setIsAuth', true);
                        dispatch('fillInfo');
                    }
                })
        },
        fillInfo({commit}) {
            getInfo()
                .then(response => {
                    if (response.data.code === 200) {
                        commit('setInfo', response.data.message);
                    }

                })
                .catch(error => {
                    console.log(error);
                })
        }
    }
};
