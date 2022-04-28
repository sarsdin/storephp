<template>
    <router-view></router-view>
</template>

<script>
import Home from './components/Home.vue'
import http from '@/modules/http'
import { useRouter } from 'vue-router'
import { getCurrentInstance } from 'vue';


export default {
    name: 'App',
    components:{
        Home
    },
    setup() {
        const router = useRouter();
        const {proxy} = getCurrentInstance();
        
        http.get('/api/home/isSession').then((res) => {
            proxy.$log('[App] isSession res: ', res.data);
        }).catch(error => proxy.$log('[App] isSession error: ', error.response.data))

        if (window.localStorage.getItem('isAutoLogin') == true) {
            http.get('/home/autoLogin', {
                params: {
                    session_id : window.localStorage.getItem('session_id')
                }

            }).then((res) => {
                if (res.data == false) {
                    alert('자동로그인 기간이 만료되었습니다. 다시 로그인해주세요.');

                } else {
                    userInfo.setLstate('logined');  //전역 로그인모듈 객체의 상태를 변경
                    userInfo.setInfo(res.sessionInfo.user_id); //마찬가지로 전역 객체에 유저id정보를 갱신
                    userInfo.info.user = res.result; //회원정보를 store에 저장!
                    store.cartStateMutation();      //store 장바구니 상태 갱신
                    
                    router.push('/');
                }
                
            }).catch(error => console.log('[App] error : ', error))
            
        }

        return {

        }
    }
}
</script>

<style>
/* body{ font-family: 'sans-serif', 'Courier New', 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode' } */

</style>
