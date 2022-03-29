import axios from 'axios';

const instance = axios.create({
    baseURL: 'http://192.168.112.128:80'
});

export default instance;
