<template>
    <!-- 로그인 폼 -->
    <div class="flex justify-center min-h-screen bg-gray-100">
        <div class="container sm:mt-20 mt-24 my-auto max-w-md border-2 border-gray-200 p-3 bg-white">
            <!-- 윗부분 -->
            <div class="text-center my-6">
                <h1 class="text-3xl font-semibold text-gray-700">로그인</h1>
                <p class="text-gray-500">Login</p>
            </div>

            <!-- 아이디 비번 입력 부분 -->
            <div class="m-6">
<!--                <form class="mb-4">-->
                    <!-- 아이디 -->
                    <div class="mb-6">
                        <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">아이디</label>
                        <input v-model="userid" type="email" name="email" id="email" placeholder="아이디를 입력해주세요." class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                        <!-- {{testdata.name}} 수염변수는 태그밖에서만 인식가능! 안은 v-bind로 -->
                    </div>
                    <!-- 비밀번호 -->
                    <div class="mb-3">
                        <div class="flex justify-between mb-2">
                            <label for="password" class="text-sm text-gray-600 dark:text-gray-400">비밀번호</label>
                            <!-- <a href="#!" class="text-sm text-gray-400 focus:outline-none focus:text-indigo-500 hover:text-indigo-500 dark:hover:text-indigo-300">비밀번호를 잊었다면?</a> -->
                        </div>
                        <input v-model="passwd" v-on:keyup.enter="login()" type="password" name="password" id="password" placeholder="비밀번호를 입력해주세요." class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                    </div>
                    <!-- 자동로그인 -->
                    <p class="text-sm text-center text-gray-400">
                        <!-- Don&#x27;t have an account yet? -->자동로그인&nbsp;
                        <input v-model="isAutoLogin" type="checkbox" class="font-semibold text-indigo-500 focus:text-indigo-600 focus:outline-none focus:underline">
                    </p>
                    <!-- 로그인하기 버튼 -->
                    <div class="mb-6">
                        <button v-on:click="login()" class="w-full px-3 py-4 text-white bg-gray-500 rounded-md hover:bg-indigo-600 focus:outline-none duration-100 ease-in-out">로그인</button>
                    </div>
                    <!-- 회원가입 -->
                    <p class="text-sm text-center text-gray-400">
                        <!-- Don&#x27;t have an account yet? -->계정이 없다면 가입하세요.&nbsp;
                        <router-link to="join" class="font-semibold text-indigo-500 focus:text-indigo-600 focus:outline-none focus:underline">회원가입</router-link>.
                    </p>
                    <!-- 홈으로 -->
                    <p class="mt-1 text-sm text-center text-gray-400">
                        <!-- Don&#x27;t have an account yet? -->
                        <router-link to="/" class="font-semibold text-indigo-500 focus:text-indigo-600 focus:outline-none focus:underline">홈으로 돌아가기&nbsp;</router-link>
                    </p>
<!--                </form>-->

                <!-- SNS 로그인 -->
                <!-- <div class="flex flex-row justify-center mb-8">
                    <span class="absolute bg-white px-4 text-gray-500">SNS 로그인</span>
                    <div class="w-full bg-gray-200 mt-3 h-px"></div>
                </div> -->
                <!-- alternate sign-in -->
                <!-- <div class="flex flex-row gap-2">
                    <button class="bg-blue-500 text-white w-full p-2 flex flex-row justify-center gap-2 items-center rounded-sm hover:bg-blue-600 duration-100 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="w-5" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 0C5.372 0 0 5.373 0 12s5.372 12 12 12c6.627 0 12-5.373 12-12S18.627 0 12 0zm.14 19.018c-3.868 0-7-3.14-7-7.018c0-3.878 3.132-7.018 7-7.018c1.89 0 3.47.697 4.682 1.829l-1.974 1.978v-.004c-.735-.702-1.667-1.062-2.708-1.062c-2.31 0-4.187 1.956-4.187 4.273c0 2.315 1.877 4.277 4.187 4.277c2.096 0 3.522-1.202 3.816-2.852H12.14v-2.737h6.585c.088.47.135.96.135 1.474c0 4.01-2.677 6.86-6.72 6.86z" fill="currentColor"/></g></svg>
                        Google
                    </button>
                    <button class="bg-green-500 text-white w-full p-2 flex flex-row justify-center gap-2 items-center rounded-sm hover:bg-green-600 duration-100 ease-in-out">
                        <svg class="w-5" enable-background="new 0 0 512 512" id="Layer_1" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g fill="white"><circle cx="255.999" cy="256" r="246.455"/></g><g><path d="M124.152,139.41h91.746c0,0,83.332,125.871,85.793,129.246c2.52,3.41,2.812,0,2.812,0   c-3.844-19.477-8.016-28.219-8.016-59.379V139.41h91.359v233.18h-91.359c0,0-81.621-119.156-84.082-122.449   c-2.473-3.316-2.801,0-2.801,0c3.141,16.078,5.918,18.762,5.918,46.688v75.762h-91.371V139.41L124.152,139.41z" fill="green"/></g></svg>
                        NAVER
                    </button>
                </div> -->

            </div>
        </div>
    </div>
</template>

<script>
import http from '../modules/http.js';
import { inject, ref, reactive, onMounted, getCurrentInstance } from 'vue';
import { login } from '../modules/auth.js';
import {useRouter} from "vue-router";
// import {router} from "../router/router";
import { useLoginStore } from "@/stores/login";
import { useStore } from '@/stores/store.js';

export default {
    name: "Login",
    // inject: ["userInfo"],

    setup() {
        const {proxy} = getCurrentInstance();
        const userInfo = useLoginStore()
        const store = useStore();
        const router = useRouter(); //inject():useRouter()는 setup()내에서 선언되어야 작동함. setup내의 자식함수에서는 동작안함.
        // let userInfo = inject("userInfo");
        let userid = ref("");
        let passwd = ref("");
        let isAutoLogin = ref(false);


        //로그인 처리
        const login = ()=>{
            // http.defaults.withCredentials = true;
            http.post('/home/login', {
                    user_id:userid.value,
                    user_pwd:passwd.value,
                    isAutoLogin: isAutoLogin.value
                }, {
                // params:{
                //     user_id:userid.value,
                //     user_pwd:passwd.value,
                //     isAutoLogin: isAutoLogin.value
                // },
                // withCredentials: true,
                headers: { 
                    'content-Type': 'application/json',
                    "Accept": "/",
                },
                credentials: 'same-origin'
                
            },
            // {
            //     // headers: { "Content-Type": "application/json; charset=UTF-8"},
            //     withCredentials: true
            // }
            ).then(res =>{
                // const res =  response.data;
                console.log("[Login] res.data: ", res.data);

                if (res.data.result != false) {
                    alert(res.data.msg);
                    userInfo.setLstate('logined');  //전역 로그인모듈 객체의 상태를 변경
                    userInfo.setInfo(res.data.sessionInfo.user_id); //마찬가지로 전역 객체에 유저id정보를 갱신
                    userInfo.info.user = res.data.result; //회원정보를 store에 저장!
                    userInfo.info.session_id = res.data.sessionInfo.session_id; //세션id를 store에 저장
                    store.cartStateMutation();      //store 장바구니 상태 갱신
                    
                    //자동로그인일경우 로컬스토리지에 저장
                    // if (res.sessionInfo.isAutoLogin == true) {
                    //     window.localStorage.setItem('isAutoLogin', true);
                    //     window.localStorage.setItem('session_id', res.sessionInfo.session_id);
                    // } else {
                    //     window.localStorage.removeItem('isAutoLogin');
                    //     window.localStorage.removeItem('session_id');
                    //     // window.localStorage.clear();
                    // }

                    router.push('/');

                } else if(res.data.error != undefined) { //error 속성이 존재하면 서버쪽에서 로그인이 실패한거라서 관련 실패메시지가 도착한다.
                    alert(res.data.msg);  
                }

            }).catch(error =>{
                console.error("[Login] 에러발생: ",error.response.data);
            })
        };

        // onMounted(() => {
        //     const login2 = ()=>{
        //         console.log("login2 clicked: "+ userid.value);
        //     }
        // });

        return {
            userid, passwd, isAutoLogin, 
            login
        }
    }
}
</script>

<style scoped>

</style>
