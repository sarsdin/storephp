import axios from 'axios';

const instance = axios.create({
    // baseURL: 'http://192.168.112.128:80'  //cors를 피하기위해 proxy를 개발서버에 구성했을때 proxy쪽 주소를 사용하기 위해 주석처리한다.
    baseURL: import.meta.env.MODE=='development'? import.meta.env.VITE_MODE_DEV : import.meta.env.VITE_MODE_PRO
});
instance.defaults.withCredentials = true; //전역적으로 axios 인스턴스에 cookie를 첨가해서 request보내기 설정.

export default instance;
