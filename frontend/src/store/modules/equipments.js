import {getHeaderSnippet} from "@/utils/common";
import $host from "@/api/config";

export const equipments = {
    state: {
        equipments: [],
        page: 1,
        limit: 3,
        totalPages: 0,
        error: false,
        errorMessage: '',
    },
    getters: {},
    mutations: {
        setPage(state, page) {
            state.page = page;
        },
        setLimit(state, limit) {
            state.limit = limit;
        },
        setTotalPages(state, total) {
            state.totalPages = total;
        },
        setEquipments(state, data) {
            state.equipments = data;
        },
        setError(state, bool) {
            state.error = bool;
        },
        setErrorMessage(state, message) {
            state.errorMessage = message;
        }
    },
    actions: {
        async loadData({commit, state}) {
            try {
                const response = await $host.get('/equipment', {
                    params: {
                        page: state.page,
                        limit: state.limit
                    },
                    ...getHeaderSnippet()
                });

                console.log(response)

                commit('setEquipments', response.data.message.data);
                commit('setTotalPages', response.data.message.meta.totalPages);
            } catch (error) {
                console.log(error)
                commit('setError', true);
                commit('setErrorMessage', error.response);
            }

        },
        changePage({commit, state, dispatch}, pageNumber) {
            if (pageNumber <= state.totalPages) {
                commit('setPage', pageNumber)
                dispatch('loadData');
            }

        },
        async deleteEquipment({commit}, id) {
            try {
                return await $host.delete(`/equipment/${id}`, {...getHeaderSnippet()});
            } catch (error) {
                return error;
            }
        }
    }
};
