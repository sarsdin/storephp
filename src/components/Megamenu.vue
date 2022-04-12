<template>
    <div class="relative z-10">
        <a href="" class="hover:bg-gray-400">
            
        </a>
        <!-- <transition name="mega-menu-fade"> -->
        
        <div class="mega-menu absolute normal-case font-normal !bg-opacity-95 !bg-white shadow-sm rounded-sm overflow-hidden border w-[973px]">
            <div class="flex border-b ml-12 p-0 gap-0">
                <ul class="w-1/6 text-sm">
                    <li class="mb-2 font-bold text-green-700 text-lg">라면즉석식품</li>
                    <router-link :to="{name: 'menu', query:{category: '라면'} }"><li class="mb-2 font-bold">라면</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '즉석밥'} }"><li class="mb-2 font-bold">즉석밥</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '죽/스프'} }"><li class="mb-2 font-bold">죽/스프</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '기타즉석식품'} }"><li class="mb-2 font-bold">기타즉석식품</li></router-link>
                </ul>
                <ul class="w-1/6 pl-10 text-sm">
                    <li class="mb-2 font-bold text-green-700 text-lg">커피음료</li>
                    <router-link :to="{name: 'menu', query:{category: '커피'} }"><li class="mb-2 font-bold">커피</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '차류'} }"><li class="mb-2 font-bold">차류</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '음료'} }"><li class="mb-2 font-bold">음료</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '생수/기타면'} }"><li class="mb-2 font-bold">생수/기타</li></router-link>
                </ul>
                <ul class="w-1/6 pl-14 text-sm">
                    <li class="mb-2 font-bold text-green-700 text-lg">과자류</li>
                    <router-link :to="{name: 'menu', query:{category: '스낵'} }"><li class="mb-2 font-bold">스낵</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '쿠키/비스켓'} }"><li class="mb-2 font-bold">쿠키/비스켓</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '초콜릿'} }"><li class="mb-2 font-bold">초콜릿</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '수입과자/기타'} }"><li class="mb-2 font-bold">수입과자/기타</li></router-link>
                </ul>
                <ul class="w-1/6 pl-14 text-sm">
                    <li class="mb-2 font-bold text-green-700 text-lg">식품류</li>
                    <router-link :to="{name: 'menu', query:{category: '통조림'} }"><li class="mb-2 font-bold">통조림</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '조미/소스류'} }"><li class="mb-2 font-bold">조미/소스류</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '밀가루'} }"><li class="mb-2 font-bold">밀가루</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '장류/양념류'} }"><li class="mb-2 font-bold">장류/양념류</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '건어물/안주류'} }"><li class="mb-2 font-bold">건어물/안주류</li></router-link>
                </ul>
                <ul class="w-1/6 pl-14 text-sm">
                    <li class="mb-2 font-bold text-green-700 text-lg">생활잡화</li>
                    <router-link :to="{name: 'menu', query:{category: '가정용품'} }"><li class="mb-2 font-bold">가정용품</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '위생용품'} }"><li class="mb-2 font-bold">위생용품</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '의약외품'} }"><li class="mb-2 font-bold">의약외품</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '일회용품'} }"><li class="mb-2 font-bold">일회용품</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '주방용품'} }"><li class="mb-2 font-bold">주방용품</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '욕실용품'} }"><li class="mb-2 font-bold">욕실용품</li></router-link>
                </ul>
                <ul class="w-1/6 pl-14 text-sm">
                    <li class="mb-2 font-bold text-green-700 text-lg">기타</li>
                    <router-link :to="{name: 'menu', query:{category: '농수산물'} }"><li class="mb-2 font-bold">농수산물</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '냉동식품'} }"><li class="mb-2 font-bold">냉동식품</li></router-link>
                    <router-link :to="{name: 'menu', query:{category: '기타'} }"><li class="mb-2 font-bold">기타</li></router-link>
                </ul>
                <button @click="$emit('닫기클릭')" class="absolute border-1 right-2 bottom-1 rounded-md p-1 bg-red-400 text-white">닫기</button>
            </div>
        </div>


        <!-- </transition> -->
    </div>
</template>

<script>
// import {ref} from 'vue'

export default {
    name:'Megamenu',
    setup() {
        

        return {
            
        }
    }
}
</script>