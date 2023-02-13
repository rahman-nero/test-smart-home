import axios from "axios";

const $host = axios.create({
    baseURL: "http://localhost:8081/api/v1/",
    headers: {
        "Content-Type": "application/json",
    }
});

export default $host;
