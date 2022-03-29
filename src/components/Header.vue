<template>
      <header class="flex flex-col w-[973px] h-36 mx-auto">
            <div class="flex h-full">
                <!-- 메인로고부분 -->
                <div @click="logoClick" class="w-68 h-24 cursor-pointer">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3D_9sOvBQcfB4VXxQHzz7ZjHjGRCDCEr9rQ&usqp=CAU" alt="이미지주소">

                </div>

                <!-- 상품검색창 -->
                <div class="w-80 flex justify-center items-center">
                    <div class="flex">
                        <input type="text" class="rounded-l-md py-1 px-2 border border-red-400 border-r-0  w-64 h-10" placeholder="상품을 입력해주세요">
                        <button type="button" class="rounded-r-md py-1 px-2 border border-l-0 bg-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- 메뉴 아이콘들 -->
                <div class="w-96 flex">
                    <div class="flex flex-1 justify-evenly items-center pl-7 pr-0">
                        <a href="" class="flex flex-col items-center text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                            </svg>
                            장바구니
                        </a>
                        <a href="" class="flex flex-col items-center text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                            주문조회
                        </a>
                        <router-link :to="{name:'notice'}" class="flex flex-col items-center text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd" />
                            </svg>
                            공지사항
                        </router-link>

                        <router-link v-if="userInfo.lstate.value == 'not'" :to="{name:'join'}" class="flex flex-col items-center text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                            </svg>
                            회원가입
                        </router-link>
                        <router-link v-if="userInfo.lstate.value == 'not'" :to="{name:'login'}" class="flex flex-col items-center text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd" />
                            </svg>
                            로그인
                        </router-link>
                        <router-link v-if="userInfo.info.value.id == 'admin'" :to="{name:'addproduct'}" class="flex flex-col items-center text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                            </svg>
                            상품등록
                        </router-link>
                        <a v-if="userInfo.lstate.value == 'logined'" @click="logout()" href="#" class="flex flex-col items-center text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd" />
                            </svg>
                            로그아웃
                        </a>
                    </div>

                </div>
            </div>

            <nav class="sm:w-auto box-border px-1 py-2 bg-white border-y-2 border-y-slate-400 font-bold"
            @click="showMenu">
                <ul class="flex justify-around list-none m-0 p-0 gap-4">
                    <li class="text-center"><a href="/#">라면즉석식품</a></li>
                    <li class="text-center"><a href="">커피음료</a></li>
                    <li class="text-center"><a href="">과자류</a></li>
                    <li class="text-center"><a href="">식품류</a></li>
                    <li class="text-center"><a href="">생활잡화</a></li>
                    <li class="text-center"><a href="">기타</a></li>
                </ul>
            </nav>

            <!-- 메가 메뉴 -->
            <transition name="mega-menu-fade">
                <Megamenu v-show="isVisible"></Megamenu>
            </transition>
        </header>
</template>
<script>
import {inject, ref} from 'vue'
import Megamenu from './Megamenu.vue';
import { useRouter } from 'vue-router';

export default {
    name: 'Header',
    components:{
        Megamenu
    },
    inject: ["userInfo"],

    setup(props) {
        const isVisible = ref(false);
        const router = useRouter();
        const userInfo = inject('userInfo');

        const showMenu = () => {
            console.log(isVisible.value);
            if (isVisible.value) {
                isVisible.value = false;
                console.log("hideMenu-isVisible: "+ isVisible.value);

            } else {
                isVisible.value = true;
                console.log("showMenu-isVisible: "+ isVisible.value);
            }
        }
        const logoClick = () => {
            router.push('/');
        }
        const logout = () => {
            userInfo.setLstate('not');
            router.go();
        }
        

        return {
            showMenu, isVisible, logoClick, logout
        }
    }
}
</script>
<style scoped>
        /* 메가메뉴 페이드 아웃 애니메이션 */
    .mega-menu-fade-enter-active, .mega-menu-fade-leave-active {
        transition: all .1s ease-in-out;
    }
    .mega-menu-fade-enter, .mega-menu-fade-leave-to {
        opacity: 0;
        transform: translateY(-12px);
    }
</style>
