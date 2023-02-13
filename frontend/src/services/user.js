import $host from "@/api/config";
import {getHeaderSnippet} from "@/utils/common";

export const login = (email, password) => {
    return $host.get('/login', {
        params: {
            email,
            password,
        }
    })
}

export const register = (name, email, password, password_confirmation) => {
    return $host.post('/register', {
        name,
        email,
        password,
        password_confirmation,
    }, {
        ...getHeaderSnippet()
    })
}
