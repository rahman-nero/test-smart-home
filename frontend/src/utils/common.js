export const getToken = () => {
    return localStorage.getItem('token');
}

export const setToken = (token) => {
    localStorage.setItem('token', token);
}

export const getHeaderSnippet = (givenToken) => {
    const token = givenToken || getToken();

    return {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    };
};