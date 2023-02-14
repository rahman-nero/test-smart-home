import {getHeaderSnippet} from "@/utils/common";
import $host from "@/api/config";
import {loadWithPaginate} from "@/services/EquipmentService";

export const mainPage = {
    state: {
        equipments: [],
        page: 1,
        limit: 10,
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
                const response = await loadWithPaginate(state.page, state.limit)
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
        }
    }
};
