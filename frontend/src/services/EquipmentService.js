import $host from "@/api/config";
import {getHeaderSnippet} from "@/utils/common";

export const loadWithPaginate = (page, limit) => {
    return $host.get('/equipment', {
        params: {
            page: page,
            limit: limit
        },
        ...getHeaderSnippet()
    });
}

export const search = (query) => {
    return $host.get('/equipment', {
        params: {
            query: query
        },
        ...getHeaderSnippet()
    });
}

export const show = (id) => {
    return $host.get(`/equipment/${id}`, {...getHeaderSnippet()})
}

export const multipleAdd = (data) => {
    return $host.post('/equipment', {equipments: data}, {
        ...getHeaderSnippet(),
    })
}

export const edit = (id, data) => {
    return $host.put(`/equipment/${id}`, data, {
        ...getHeaderSnippet(),
    })
}

export const deleteItem = (id) => {
    return $host.delete(`/equipment/${id}`, {
        ...getHeaderSnippet()
    });
}
