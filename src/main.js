import {createApp} from 'vue';
// import Vue from 'vue';
import App from './App.vue';
import './index.css'
import axios from 'axios';
import http from './modules/http.js';
import router from './router/router.js'
// import userInfo from './compositions/userinfo.js'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

//global modules
import consoleLog from "./modules/consoleLog";

//font-awesome 관련 import
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(fas, far, fab)

//퀘이사ui quasar import
import { Quasar } from 'quasar'
import quasarLang from 'quasar/lang/ko-KR'
import quasarIconSet from 'quasar/icon-set/svg-fontawesome-v6'

// Import icon libraries
import '@quasar/extras/roboto-font/roboto-font.css'
import '@quasar/extras/material-icons/material-icons.css'
import '@quasar/extras/fontawesome-v6/fontawesome-v6.css'

// A few examples for animations from Animate.css: 퀘이사 애니메이션 적용부분
// import @quasar/extras/animate/fadeIn.css
// import @quasar/extras/animate/fadeOut.css

// Import Quasar css
import 'quasar/src/css/index.sass'

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
// app.provide('userInfo', userInfo);
app.provide('http', http);
app.provide('$axios', axios); //app인스턴스 생성시 provide함수를 이용해 axios변수를 전역에서 활용하도록 제공?!
app.use(router);
app.use(pinia);
app.use(consoleLog);
// consoleLog.install(app); //app.use(consoleLog) 와 동일
app.use(Quasar, {
    plugins: {}, // import Quasar plugins and add here
    lang: quasarLang,
    iconSet: quasarIconSet,
  })
app.mount('#app');
// createApp(App).mount('#app');



// vue2.x 버전 방식의 앱 인스턴스 생성
// new Vue({
//     render(h) {
//         h(App);
//     },
// }).$mount('#app');
