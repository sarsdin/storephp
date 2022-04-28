import axios from 'axios';

const instance = axios.create({
    baseURL: 'http://192.168.112.128:80'
});
// instance.defaults.withCredentials = true; //전역적으로 axios 인스턴스에 cookie를 첨가해서 request보내기 설정.

export default instance;
