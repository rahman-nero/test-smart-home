import $host from "@/api/config";
import {getHeaderSnippet} from "@/utils/common";

export const getTypes = (page, limit) => {
    return $host.get(`/equipment-type`, {
        params: {
            page,
            limit,
        },
        ...getHeaderSnippet()
    });
}

export const getAllTypes = () => {
    return $host.get(`/equipment-type`, {
        params: {
            limit: 0
        },
        ...getHeaderSnippet()
    });
}