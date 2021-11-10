import Vue from "vue";
import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost:8000/api/',
});

api.interceptors.response.use(
    function (successRes) {
        return successRes;
    },
    function (error) {
        Vue.$toast.error('An unexpected error has occurred. Please try reloading this page.')
        return Promise.reject(error);
    }
);

export {api};