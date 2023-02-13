import {getHeaderSnippet, getToken, setToken} from "@/utils/common";
import $host from "@/api/config";
import {register} from "@/services/user";

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
            const token = getToken();

            return await $host.get('/user', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            }).then(response => {
                if (response.data.code === 200) {
                    commit('setIsAuth', true);
                    commit('setInfo', response.data.message);
                }
            }).catch(error => {
                console.log(error);
            })

        },
        async login({commit, dispatch}, {email, password}) {
            return new Promise((resolve, reject) => {
                $host.get('/login', {
                    params: {
                        email,
                        password,
                    }
                }).then(response => {
                    if (response.data.code === 200) {
                        setToken(response.data.message.token);
                        commit('setIsAuth', true);
                        dispatch('fillInfo');
                    }
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            })


        },
        async register({commit, dispatch}, {name, email, password, password_confirmation}) {
            // return register(name, email, password, password_confirmation).then(() => {
            //
            // })

            return new Promise((resolve, reject) => {
                $host.post('/register', {
                    name,
                    email,
                    password,
                    password_confirmation,
                }, {...getHeaderSnippet()}).then(response => {
                    if (response.data.code === 200) {
                        setToken(response.data.message.token);
                        commit('setIsAuth', true);
                        dispatch('fillInfo');
                    }
                    resolve(response);
                }).catch(error => {
                    reject(error);
                })
            });

        },
        fillInfo({commit}) {
            const token = getToken();

            $host.get('/user', {
                ...getHeaderSnippet()
            }).then(response => {
                if (response.data.code === 200) {
                    commit('setInfo', response.data.message);
                }

            }).catch(error => {
                console.log(error);
            })
        }
    }
};
