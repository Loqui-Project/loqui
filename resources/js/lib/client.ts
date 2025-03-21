import axios from 'axios';

export function client() {
    return axios.create({
        baseURL: 'http://localhost:8000/api',
        withCredentials: true,
    });
}
