<template>
    <router-view></router-view>
</template>

<script>
import Home from './components/Home.vue'
import http from '@/modules/http'
import { useRouter } from 'vue-router'
import { onMounted, getCurrentInstance } from 'vue';
import { useLoginStore } from './stores/login';
import { useStore } from './stores/store';


export default {
    name: 'App',
    components:{
        Home
    },
    setup() {
        const userInfo = useLoginStore();
        const store = useStore();
        const router = useRouter();
        const {proxy} = getCurrentInstance();
        proxy.$log('pro env: ', import.meta.env); //vite 환경변수 출력하기.
        
        //세션값이 존재하는지 확인.
        http.get('/home/isSession').then((res) => { 
            proxy.$log('[App] isSession res: ', res.data);
        }).catch(error => proxy.$log('[App] isSession error: ', error.response.data))

        //쿠키를 순회하고 서버의 자동로그인처리가 되면 받아오는 'id_'로 시작하는 쿠키의 존재를 확인함.
        let cookie = document.cookie.split(";");
        proxy.$log('[App] cookie: ', cookie);


        //app component가 마운트되고 자동로그인 쿠키를 순회한다.
        onMounted(() => {
            for (let i = 0; i < cookie.length; i++) {
                const element = cookie[i];
                if (element.search('^(id_).*(__)' ) != -1 ) {
                    // if (element.search('^id' ) != -1 ) {
                    proxy.$log('[App] cookie element '+i+': ', element);
                    proxy.$log('[App] cookie element '+i+' id: ', element.match('(?<=id_)(.*?)(?=__)'));
                    let userid = element.match('(?<=id_)(.*?)(?=__)');  //id_ 와 __ 사이의 모든문자. 즉, 쿠키에서 아이디 부분만 추출하는 것!
                    autoLogin(userid[0]);
                    break;
                }
            }

        })

        //자동로그인 처리
        const autoLogin = (userid) => {
            proxy.$log('[App] autoLogin: ', userid);
            
            http.get('/home/autoLogin', {
                params: {
                    user_id : userid
                }

            }).then((res) => {
                proxy.$log('[App] autoLogin res: ', res.data);
                if (res.data.result == false) {
                    alert('없는 아이디입니다. 다시 로그인해주세요.');

                } else {
                    userInfo.setLstate('logined');  //전역 로그인모듈 객체의 상태를 변경
                    userInfo.setInfo(res.data.sessionInfo.user_id); //마찬가지로 전역 객체에 유저id정보를 갱신
                    userInfo.info.user = res.data.result; //회원정보를 store에 저장!
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





<!-- 

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

 -->