<template>
    <!-- component -->
    <div class="flex justify-center min-h-screen bg-gray-100">
        <div class="container sm:mt-20 mt-24 my-auto max-w-md border-2 border-gray-200 p-3 bg-white">
            <h1 class="m-5 text-xl font-semibold text-center">회원정보 입력  <span class="block font-normal text-base"></span></h1>

            <form class="m-6">
                <label for="id" class="block my-2 text-xs font-semibold text-gray-600 uppercase">아이디</label>
                <input v-model="userid" id="id" type="text" name="id" placeholder="아이디를 입력해주세요." autocomplete="id" class="w-full px-3 py-2 text-sm placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" required />

                <div class="flex justify-between gap-3">
                    <span class="w-full">
                        <label for="firstname" class="block my-2 text-xs font-semibold text-gray-600 uppercase dark:text-gray-400">이름</label>
                        <input v-model="name" id="firstname" type="text" name="firstname" placeholder="이름을 입력해주세요." autocomplete="given-name" class="w-full px-3 py-2 text-sm placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" required />
                    </span>

                    <!-- <span class="w-1/2">
                    <label for="lastname" class="block my-2 text-xs font-semibold text-gray-600 uppercase">Lastname</label>
                    <input id="lastname" type="text" name="lastname" placeholder="Doe" autocomplete="family-name" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" required />
                    </span> -->
                </div>

                <label for="email" class="block my-2 text-xs font-semibold text-gray-600 uppercase">E-mail</label>
                <input v-model="email" ref="emailFocus" id="email" type="email" name="email" placeholder="email@company.com" autocomplete="email" class="w-full px-3 py-2 text-sm placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" required />

                <label for="password" class="block my-2 text-xs font-semibold text-gray-600 uppercase">비밀번호</label>
                <input v-model="passwd" id="password" type="password" name="password" placeholder="8 ~ 20자의 영문 대/소문자, 숫자, 특수문자를 사용하세요." autocomplete="new-password" class="w-full px-3 py-2 text-xs placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" required />

                <label for="password-confirm" class="block my-2 text-xs font-semibold text-gray-600 uppercase">비밀번호 확인</label>
                <input v-model="passwdc" id="password-confirm" type="password" name="password-confirm" placeholder="비밀번호를 다시한번 입력해주세요." autocomplete="new-password" class="w-full px-3 py-2 text-xs placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" required />

                <label for="password-confirm" class="block my-2 text-xs font-semibold text-gray-600 uppercase">휴대폰번호</label>
                <input v-model="phone" id="phone" type="tel" name="phone" placeholder="휴대폰번호를 입력해주세요." autocomplete="" class="w-full px-3 py-2 text-xs placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" required />

                <button @click.prevent="join" v-bind:disabled="(name == ''|| email == '') "
                 type="submit" class="w-full px-3 py-4 mt-6 text-white bg-gray-500 rounded-md hover:bg-indigo-600 focus:outline-none duration-100 ease-in-out">
                    회원가입
                </button>
                <p class="justify-between inline-block mt-4 text-xs text-gray-500 cursor-pointer hover:text-black">
                    <router-link to="login">이미 회원이시라면?</router-link>
                </p>
                <p class="mt-1 text-sm text-center text-gray-400">
                        <!-- Don&#x27;t have an account yet? -->
                    <router-link to="/" class="font-semibold text-indigo-500 focus:text-indigo-600 focus:outline-none focus:underline">홈으로 돌아가기&nbsp;</router-link>
                </p>
            </form>

        </div>
    </div>
</template>

<script>
import { reactive, ref, toRefs } from 'vue'
import {useRouter} from 'vue-router'
import http from '../modules/http'

export default {
    name: 'Join',
    setup () {
        const state = reactive({
            userid: '',
            name: '',
            email: '',
            passwd: '',
            passwdc: '',
            phone: null
        })
        const emailFocus = ref(null);   //email focus용
        const router = useRouter();

        const join = () => {
            console.log("join->state: ", state);

            const form = new FormData();
            form.append('user_id', state.userid);
            form.append('user_pwd', state.passwd);
            form.append('user_pwdc', state.passwdc);
            form.append('user_name', state.name);
            form.append('user_phone', state.phone);
            form.append('user_email', state.email);
            // {
            //     user_id: state.userid,
            //     user_pwd: state.passwd,
            //     user_name: state.name,
            //     user_phone: state.phone,
            //     user_email: state.email,
            // }
            http.post('/home/join',form).then((response) => {   //form형식으로 데이터보내기
                const res = response.data;
                console.log("join->then -> res: ", res);
                if (res.result == true) {
                    alert(res.msg);
                    router.push('login');
                } else if (res.msg.user_id != undefined) {
                    alert(res.msg.user_id);
                } else if (res.msg.user_email != undefined) {
                    alert(res.msg.user_email);
                    emailFocus.value.focus();   //input tag의 ref 속성을 이용한 포커스작업
                } else if (res.msg.user_pwd != undefined) {
                    alert(res.msg.user_pwd);
                } else if (res.msg.user_pwdc != undefined) {
                    alert(res.msg.user_pwdc);
                }  

            }).catch(error =>{
                console.error("join->에러발생:",error.response.data);
            })
        }
    
        return {
            ...toRefs(state),   //toRefs를 쓰는 이유: state안의 속성들을 state. 없이 쓰기위함. 각각의 속성들을 반응형으로 씌어주는 함수.
            join, emailFocus
        }
    }
}
</script>

<style scoped>

</style>
