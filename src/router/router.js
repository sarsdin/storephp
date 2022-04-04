import { nextTick } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import routes from './routes.js'

const router = createRouter({
    history: createWebHistory(),
    routes,
})

// router.beforeEach((to, from) => {
//     alert('test')
//     console.log('beforEach :>> ');
//     if (to === from) {
//         window.location.reload();
//         return next()
//     }
// })

// router.beforeResolve((to, from) => {     //Resolve는 Each와는 달리 다른 hook, async 작업이 완료되고 실행함. (navigation이 확인되기전)
//     console.log('beforResolve :>> ');
//     alert('test2222')
//     if (to === from) {
//         window.location.reload();
//         return next()
//     }
// })

export default router