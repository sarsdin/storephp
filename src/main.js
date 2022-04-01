import {createApp} from 'vue';
// import Vue from 'vue';
import App from './App.vue';
import './index.css'
import axios from 'axios';
import http from './modules/http.js';
import {router} from './router/router.js'
import userInfo from './compositions/userinfo.js'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

//font-awesome 관련 import
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(fas, far, fab)

// Vue.prototype.$axios = axios;

//크롬 dev.tool 프로덕션모드에서도 활성화하기
// globalThis.__VUE_OPTIONS_API__ = process.env.NODE_ENV === "development";
// globalThis.__VUE_PROD_DEVTOOLS__ = process.env.NODE_ENV === "development";

// Vue.component('todo-item', {
//     props: ['todo'],
//     template: '<li>{{ todo.text }}</li>'
// })
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

const app = createApp(App);
app.component("font-awesome-icon", FontAwesomeIcon);
app.provide('userInfo', userInfo);
app.provide('http', http);
app.provide('$axios', axios); //app인스턴스 생성시 provide함수를 이용해 axios변수를 전역에서 활용하도록 제공?!
app.use(router);
app.use(pinia);
app.mount('#app');
// createApp(App).mount('#app');



// vue2.x 버전 방식의 앱 인스턴스 생성
// new Vue({
//     render(h) {
//         h(App);
//     },
// }).$mount('#app');
