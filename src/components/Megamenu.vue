<template>
    <div class="relative z-10">
        <a href="" class="hover:bg-gray-400">
            
        </a>
        <!-- <transition name="mega-menu-fade"> -->
        
        <div class="mega-menu absolute normal-case font-normal !bg-opacity-95 !bg-white shadow-sm rounded-sm overflow-hidden border w-[973px]">
            <div class="flex border-b ml-12 p-0 gap-0">
                <ul class="w-1/6 text-sm">
                    <!-- <router-link :to="{name: 'contentholder', }" @click="megaMenuParentClicked('라면즉석식품')   "<li @click="megaMenuClicked('라면즉석식품') "  class="mb-2 cursor-pointer font-bold text-green-700 text-lg">라면즉석식품</li> -->
                    <li @click="megaMenuParentClicked('라면즉석식품') " class="mb-2 cursor-pointer font-bold text-green-700 text-lg">라면즉석식품</li>
                    <li @click="megaMenuClicked('라면') "  class="mb-2 cursor-pointer font-bold">라면</li>
                    <li @click="megaMenuClicked('즉석밥') "  class="mb-2 cursor-pointer font-bold">즉석밥</li>
                    <li @click="megaMenuClicked('죽/스프') "  class="mb-2 cursor-pointer font-bold">죽/스프</li>
                    <li @click="megaMenuClicked('기타즉석식품') "  class="mb-2 cursor-pointer font-bold">기타즉석식품</li>
                </ul>
                <ul class="w-1/6 pl-10 text-sm">
                    <li @click="megaMenuParentClicked('커피음료') "  class="mb-2 cursor-pointer font-bold text-green-700 text-lg">커피음료</li>
                    <li @click="megaMenuClicked('커피') "  class="mb-2 cursor-pointer font-bold">커피</li>
                    <li @click="megaMenuClicked('차류') "  class="mb-2 cursor-pointer font-bold">차류</li>
                    <li @click="megaMenuClicked('음료') "  class="mb-2 cursor-pointer font-bold">음료</li>
                    <li @click="megaMenuClicked('생수/기타면') "  class="mb-2 cursor-pointer font-bold">생수/기타</li>
                </ul>
                <ul class="w-1/6 pl-14 text-sm">
                    <li @click="megaMenuParentClicked('과자류') " class="mb-2 cursor-pointer font-bold text-green-700 text-lg">과자류</li>
                    <!-- <router-link :to="{name: 'contentholder', }" @click="megaMenuParentClicked('과자류') "<li @click="megaMenuClicked('라면즉석식품') "  class="mb-2 cursor-pointer font-bold text-green-700 text-lg">과자류</li> -->
                    <li @click="megaMenuClicked('스낵') "  class="mb-2 cursor-pointer font-bold">스낵</li>
                    <li @click="megaMenuClicked('쿠키/비스켓') "  class="mb-2 cursor-pointer font-bold">쿠키/비스켓</li>
                    <li @click="megaMenuClicked('초콜릿') "  class="mb-2 cursor-pointer font-bold">초콜릿</li>
                    <li @click="megaMenuClicked('수입과자/기타') "  class="mb-2 cursor-pointer font-bold">수입과자/기타</li>
                </ul>
                <ul class="w-1/6 pl-14 text-sm">
                    <li @click="megaMenuParentClicked('식품류') "  class="mb-2 cursor-pointer font-bold text-green-700 text-lg">식품류</li>
                    <li @click="megaMenuClicked('통조림') "  class="mb-2 cursor-pointer font-bold">통조림</li>
                    <li @click="megaMenuClicked('조미/소스류') "  class="mb-2 cursor-pointer font-bold">조미/소스류</li>
                    <li @click="megaMenuClicked('밀가루') "  class="mb-2 cursor-pointer font-bold">밀가루</li>
                    <li @click="megaMenuClicked('장류/양념류') "  class="mb-2 cursor-pointer font-bold">장류/양념류</li>
                    <li @click="megaMenuClicked('건어물/안주류') "  class="mb-2 cursor-pointer font-bold">건어물/안주류</li>
                </ul>
                <ul class="w-1/6 pl-14 text-sm">
                    <li @click="megaMenuParentClicked('생활잡화') " class="mb-2 cursor-pointer font-bold text-green-700 text-lg">생활잡화</li>
                    <li @click="megaMenuClicked('가정용품') "  class="mb-2 cursor-pointer font-bold">가정용품</li>
                    <li @click="megaMenuClicked('위생용품') "  class="mb-2 cursor-pointer font-bold">위생용품</li>
                    <li @click="megaMenuClicked('의약외품') "  class="mb-2 cursor-pointer font-bold">의약외품</li>
                    <li @click="megaMenuClicked('일회용품') "  class="mb-2 cursor-pointer font-bold">일회용품</li>
                    <li @click="megaMenuClicked('주방용품') "  class="mb-2 cursor-pointer font-bold">주방용품</li>
                    <li @click="megaMenuClicked('욕실용품') "  class="mb-2 cursor-pointer font-bold">욕실용품</li>
                </ul>
                <ul class="w-1/6 pl-14 text-sm">
                    <li @click="megaMenuParentClicked('기타') " class="mb-2 cursor-pointer font-bold text-green-700 text-lg">기타</li>
                    <li @click="megaMenuClicked('농수산물') "  class="mb-2 cursor-pointer font-bold">농수산물</li>
                    <li @click="megaMenuClicked('냉동식품') "  class="mb-2 cursor-pointer font-bold">냉동식품</li>
                    <li @click="megaMenuClicked('기타') "  class="mb-2 cursor-pointer font-bold">기타</li>
                </ul>
                <button @click="$emit('닫기클릭')" class="absolute border-1 right-2 bottom-1 rounded-md p-1 bg-red-400 text-white">닫기</button>
            </div>
        </div>


        <!-- </transition> -->
    </div>
</template>

<script>
// import {ref} from 'vue'

import { useProductStore } from "@/stores/product"
import { useStore } from "@/stores/store";
import { useRoute, useRouter } from "vue-router";

export default {
    name:'Megamenu',
    setup(p,context) {
        const productStore = useProductStore();
        const store = useStore();
        const route = useRoute();
        const router = useRouter();
        
        const megaMenuParentClicked = (cat) => {
            productStore.paging.currentPage = 1;    //parent 카테고리만 클릭했을때 currentPage를 초기화해서 1페이지부터 보여질수있게한다.
            productStore.paging.productCategory = ''; //마찬가지로 상품자식카테고리 또한 초기화 해준다.
            productStore.paging.categoryParent = cat; //부모카테고리만 대입해준다.

            context.emit('닫기클릭');
            store.rstate++;
            router.push({name: 'contentholder', query: { category: '' }});
        }

        const megaMenuClicked = (cat) => {
            productStore.paging.currentPage = 1;    //카테고리만 클릭했을때 currentPage를 초기화해서 1페이지부터 보여질수있게한다.
            productStore.paging.productCategory = cat;
            productStore.paging.categoryParent = productStore.breadCrumb; //자식카테고리의 유무에 따라 상품스토어의 getter(breadCrumb)에서 자동으로 계산하여 부모카테고리를 넣어준다.

            context.emit('닫기클릭');
            store.rstate++;
            router.push({name: 'contentholder', query: { category: cat }});
        }

        return {
            productStore,
            megaMenuParentClicked, megaMenuClicked
        }
    }
}
</script>