<template>
<div class="flex flex-col w-full">

    <nav class="flex my-2" aria-label="Breadcrumb">
        <ol role="list" class="flex overflow-hidden text-gray-700 border border-gray-200 rounded-lg">
            <li class="flex items-center rounded-lg">
                <a @click.prevent="logoClick()" class="flex items-center h-7 px-4 transition-colors bg-gray-200 hover:text-gray-900" href="/">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="ml-1.5 font-medium text-xs"> 홈 </span>
                </a>
            </li>

            <li v-if="productStore.breadCrumb != ''"  class="relative flex items-center">
                <span class="absolute inset-y-0 w-4 h-7 bg-gray-200 -left-px clip"> </span>
                <a @click.prevent="megaMenuParentClicked(productStore.breadCrumb)"
                    class="flex items-center h-7 pl-8 pr-4 text-xs font-medium transition-colors bg-gray-100 hover:text-gray-900"
                    href="/collections/shirts">
                    {{ productStore.breadCrumb }}
                </a>
            </li>

            <li v-if="productStore.paging.productCategory != ''" class="relative flex items-center">
                <span class="absolute inset-y-0 w-4 h-7 bg-gray-100 -left-px clip"> </span>
                <a @click.prevent="megaMenuClicked(productStore.paging.productCategory)"
                    class="flex items-center h-7 pl-8 pr-4 text-xs font-medium transition-colors bg-white hover:text-gray-900"
                    href="/collections/shirts">
                    {{ productStore.paging.productCategory }}
                </a>
            </li>
        </ol>
    </nav>

    <div class="flex flex-wrap w-full">
        <div v-for="item in productStore.productSearchList" v-bind:key="item.product_name" id="contentholderrootdiv" class="max-w-[323px] min-w-[323px] p-4"> <!-- w-screen -->
            <a href="#" class="block p-4 rounded-lg shadow-sm shadow-indigo-200" v-on:click="productClicked(item, $event)" v-on:mouseleave="aonmouseleave">
                <img alt="이미지를 로드할 수 없습니다. 재시도 요망" :src="imageLoad(item)"
                    class="object-cover w-full h-56 rounded-md" />
        <!-- itemImgLoad != null? itemImgLoad:'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif' -->
                <div class="mt-2">
                    <dl>
                        <div>
                            <dt class="sr-only">
                                Price
                            </dt>
                            <dd class="text-lg font-extrabold">
                                ￦{{ Number(item.product_price).toLocaleString('ko-KR')}}
                            </dd>
                        </div>
        
                        <div>
                            <dt class="sr-only">
                                상품명
                            </dt>
                            <dd class="font-medium">
                                {{item.product_name}}
                            </dd>
                        </div>
                    </dl>
        
                    <dl class="flex items-start mt-6 space-x-4 text-xs">
                        <div class="sm:inline-flex sm:items-center sm:shrink-0">
                            <!-- <svg class="w-4 h-4 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg> -->
        
                            <div class="sm:ml-3 mt-1.5 sm:mt-0">
                                <dt class="text-gray-500">
                                    상품가격
                                </dt>
                                <dd class="font-medium text-center">
                                    {{item.product_price.toLocaleString()}}원
                                </dd>
                            </div>
                        </div>
        
                        <div class="sm:inline-flex sm:items-center sm:shrink-0">
                            <!-- <svg class="w-4 h-4 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg> -->
        
                            <div class="sm:ml-3 mt-1.5 sm:mt-0">
                                <dt class="text-gray-500">
                                    SPEC
                                </dt>
                                <dd class="font-medium text-center">
                                    {{item.product_spec }}
                                </dd>
                            </div>
                        </div>
        
                        <div class="sm:inline-flex sm:items-center sm:shrink-0">
                            <!-- <svg class="w-4 h-4 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg> -->
                            <div class="sm:ml-3 mt-1.5 sm:mt-0">
                                <dt class="text-gray-500">
                                    개수선택
                                </dt>
                                <dd class="font-medium">
                                    <input v-model="item.count" min="1" type="number" name="eabox" class="w-12 text-center border">
                                    <!-- <select name="ea" id="eabox">
                                        <option value="0">ea</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select> -->
                                </dd>
                            </div>
                        </div>
        
                        <div class="flex items-center relative">
                            <div @click="장바구니추가(item)" class="flex items-center h-8 ml-3">
                                <!-- <q-icon name="fas fa-ambulance"></q-icon> -->
                                <!-- <font-awesome-icon id="cartBt" :icon="['fa', 'cart-shopping']" class="text-2xl text-zinc-500 hover:text-red-600"></font-awesome-icon> -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-zinc-500 hover:text-red-600" viewBox="0 0 512 512"><title>장바구니에 담기</title><circle cx="176" cy="416" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="400" cy="416" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M48 80h64l48 272h256"/><path d="M160 288h249.44a8 8 0 007.85-6.43l28.8-144a8 8 0 00-7.85-9.57H128" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
                            </div>
                            <div v-if="item.popupOnOff" data-cart-popup="confirm" class="flex flex-col items-center absolute top-[-65px] left-[-120px] w-52 h-16 border border-slate-500 bg-white rounded-sm">
                                <div data-cart-popup="confirm" class="mt-2">
                                    상품이 장바구니에 담겼습니다
                                </div>
                                <button @click="장바구니확인하기()" data-cart-popup="confirm" class="p-1 mt-1 border border-red-500 bg-red-500 text-white rounded hover:bg-red-700" >장바구니 확인하기</button>
                            </div>
                        </div>
                    </dl>
        
                </div>
            </a>
        </div>
    </div>

<!-- 페이징 부분 -->
<div class="flex justify-center w-96 h-10 mx-auto my-5">
    <button v-if="productStore.pagingC.lastPage > 10 " @click="gotoClickedPage(1, $event)" class="mr-1" >
        <font-awesome-icon class="text-gray-700" :icon="['fas', 'angles-left']"></font-awesome-icon>
    </button> 

    <button v-if="productStore.pagingC.prevPage != 0 " @click="gotoClickedPage(productStore.pagingC.prevPage, $event)" >
        <font-awesome-icon class="text-gray-700" :icon="['fas', 'square-caret-left']"></font-awesome-icon>
    </button> 
    
    <!-- @click시 store.rstate++을 이용해서 router-view를 갱신(리로드) 해주면 css를 바인딩으로 해결해야한다. 
    이벤트target으로 css를 수정하면 수정하자마자 재랜더링때문에 적용이 풀린다. -->                                              
    <button v-for="pageNumber in productStore.pagingC.linkArray" :key="pageNumber" :class="{'currentPagingCSS': productStore.classVar == pageNumber }"
        @click="gotoClickedPage(pageNumber, $event)" 
        class="text-gray-700 w-7 hover:text-blue-500 hover:font-semibold hover:text-lg">
        {{ pageNumber }}
    </button> 
    
    <button v-if="productStore.pagingC.lastPage < productStore.pagingC.totalPageCount" @click="gotoClickedPage(productStore.pagingC.nextPage, $event)" >
        <font-awesome-icon class="text-gray-700" :icon="['fas', 'square-caret-right']"></font-awesome-icon>
    </button>

</div>

</div>
</template>

<script>
import { ref, onMounted, getCurrentInstance, computed } from 'vue';
import { useRouter, useRoute } from "vue-router";
import http from "@/modules/http";
import { useStore } from '@/stores/store';
import { useLoginStore } from '@/stores/login';
import { useProductStore } from '@/stores/product';

export default {
    name: 'Contentholder',
    props:{
        it :{ type: Array }  //Home items에서 넘어온 값
        // item:{ name: String, price: Number, expire: Number }
    },
    setup(props) {
        const {proxy} = getCurrentInstance();
        const store = useStore();
        const productStore = useProductStore();
        const userInfo = useLoginStore();
        const router = useRouter();
        const route = useRoute();
        // const itemImg = ref({});
        const pList = ref([]);
        const 개수선택 = ref(1);
        // const 장바구니팝업온오프 = ref(false);
        
        //상품리스트 서버에서 로드
        // if (route.query.category != undefined && route.query.category != null) {
            // productStore.paging.productCategory = route.query.category; //uri 에 queryString category가 존재하면(메가메뉴에서 넘어왔다면)store에 갱신해줌.
        // }

        // const 상품리스트로드 = () => {
        //     http.get('/productc/pList').then((res) => {
        //         pList.value = res.data;
        //         pList.value.forEach((item,i,origin) => {
        //             origin[i].count = 1;                //상품뷰에서 장바구니 개수선택 1로 초기화
        //             origin[i].popupOnOff = false;       //상품뷰에서 장바구니 클릭시 뜨는 팝업창 초기값 설정 - 클릭시 true로 바뀌고 일정시간 후 다시 false로 바뀜
        //         })
        //     }).catch(error => console.log('[Contentholder] 상품리스트로드 res: ', error.response.data))
        // }
        
        // if (productStore.paging.productSearch == '') { //전역 상품store의 헤더 검색어가 없다면 상품전체리스트 로드.
        //     상품리스트로드();
        // } else {
        //     productStore.headerSearch();
        // }
        productStore.headerSearch();

        //각 상품이미지 로드
        const imageLoad = (item) => {
            // proxy.$log('Contentholder.imageLoad(): ', item);
            if (item.product_image != null) {
                // proxy.$log('Contentholder.imageLoad(): ', item);
                return 'http://192.168.112.128/uploads/'+item.product_image[0];
            } else {
                // proxy.$log('Contentholder.imageLoad() else: ', item);
                return 'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif';
            }
        }

        // const itemImgLoad = computed({
        //     get: () => {
        //         if (itemImg.value['product_no'] != undefined) {
        //             http.get('/productc/pImage', { params: {'product_no':itemImg.product_no }}).then((res) => {
        //                 proxy.$log('Contentholder.itemImgLoad(): ', res.data);
        //                 if ( res.data != null ) {
        //                     proxy.$log('Contentholder.itemImgLoad() if true: ', res.data);
        //                     return res.data[0];
        //                 } else {
        //                     const url = URL.createObjectURL('./')  //'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif'
        //                     proxy.$log('Contentholder.itemImgLoad() else false: ', url);
        //                     return url;
        //                 }
        //             }) 
        //         }
        //     },
        //     set: (v) => {
        //         itemImg.value = v;
        //     }
        // })

        let productClicked = (item, e) => {
            if ((e.target.tagName == 'INPUT')  || (e.target.id == 'cartPopup') //|| (e.target.getAttribute('id') == 'cartBt')
                || ('cartPopup' in e.target.dataset === true )  //dataset안에 해당 속성이 설정되있는지? html tag내에서는 -(대쉬)case로 설정됨
                || (e.target.tagName == 'svg') || (e.target.tagName == 'path')){ //svg or path tag의 name은 소문자로 표시됨. 예외사항 유의!
                // e.stopImmediatePropagation();
                e.stopPropagation();  //이것만 했을 때는 a 태그의 클릭이벤트가 select 태그와 겹쳐서 둘다 작동되었음.
                e.preventDefault();     // 하지만, 이것을 했을 때는 select 태그를 클릭했을 시, a 태그의 클릭이벤트가 동작하지 않음. 정답을 여기서 찾음!
                return;
            }
            // a.onclick = e =>{
            //     // e.target.style.color = 'blue';
            //     // e.target.classList.add('pointer-events-none');
            // }
            // e.preventDefault();
            router.push({name: 'productDetail', query: { product_no: item.product_no }});
        }

        const aonmouseleave = e =>{
                console.log("마우스리브")
            }

        const 장바구니추가 = (item) => {
            // proxy.$log('test')
            //db추가 & 장바구니 아이콘에 1,2 ..개수표시 (이건 pinia에 글로벌 변수로 계산되게 해야할듯 개수선택변수의 숫자에 따라 글로벌변수가 자동으로 계산되게끔) 
            http.get('/productc/addProductInCart', {
                params:{
                    product_no: item.product_no,
                    product_count: item.count,   //추가할 개수
                    cart_owner: userInfo.info.id
                }
            }).then((res) => {
                if (res.data.result == 'false') {
                    proxy.$log('[Contentholder]장바구니추가 res false: ', res.data.msg);
                } else {
                    // store.$state.cartCount += 개수선택.value;
                    item.popupOnOff = true; //장바구니 확인 팝업창 켜고 끔
                    setTimeout(() => {
                        item.popupOnOff = false;
                    }, 5000)
                    item.count = 1; //장바구니 추가후에는 초기화해줌
                    store.cartStateMutation(); //전역 스토어의 장바구니 현황을 갱신하기 위해 실행해준다.
                }
                
            }).catch((error) => {
                proxy.$log('[Contentholder]장바구니추가 error: ', error.response.data);
            })
        }

        const 장바구니확인하기 = () => {
            store.rstate++;
            router.push({name: 'cart'})
        }

        const gotoClickedPage = (pageNumber, $event) => {
            productStore.paging.currentPage = pageNumber;
            $event.target.style.color = 'blue';   //테스트용임. rstate++로 인해 작동안하는 중. -- 하는중..
            productStore.classVar = pageNumber;
            productStore.headerSearch();

            if (route.query.category != undefined && route.query.category != null) {
                // store.rstate++;
                productStore.paging.productCategory = route.query.category; //uri 에 queryString category가 존재하면(메가메뉴에서 넘어왔다면)store에 갱신해줌.
            }

            window.scrollTo({ top: 0, behavior: 'smooth'}); //글 클릭시 맨위로 가기 참고 - messages.scrollTo({ top: messages.scrollHeight, behavior: 'smooth' });
            
            //query string이 없다면 noticeContent컴포넌트는 실행하지 않음.
            // store.rstate++;
            // if (route.query.notice_no != undefined || route.query.notice_no != null) {
            //     let params = {
            //         name: 'noticeContent', 
            //         query:{
            //             notice_no: route.query.notice_no
            //         }
            //     }
            //     // if (route.query.notice_) {}
            //     router.push(params);
            // }
        }
        

        //breadCrumb 홈 클릭시
        const logoClick = () => {
            productStore.paging.productCategory = '';   //로고 클릭시 카테고리 초기화 (전체메뉴로)
            productStore.paging.categoryParent = '';   //로고 클릭시 카테고리 초기화 (전체메뉴로)
            productStore.paging.currentPage = 1;   //로고 클릭시 카테고리 초기화 (전체메뉴로)
            productStore.classVar = 1;   //로고 클릭시 css 초기화 (전체메뉴로)
            store.rstate++;
            router.push('/');
        }

        //breadCrumb 부모카테고리 클릭시
        const megaMenuParentClicked = (cat) => {
            productStore.paging.currentPage = 1;    //parent 카테고리만 클릭했을때 currentPage를 초기화해서 1페이지부터 보여질수있게한다.
            productStore.paging.productCategory = '';
            productStore.paging.categoryParent = cat;

            store.rstate++;
            router.push({name: 'contentholder', query: { category: '' }});
        }

        //breadCrumb 자식카테고리 클릭시
        const megaMenuClicked = (cat) => {
            productStore.paging.currentPage = 1;    //카테고리만 클릭했을때 currentPage를 초기화해서 1페이지부터 보여질수있게한다.
            productStore.paging.productCategory = cat;
            productStore.paging.categoryParent = productStore.breadCrumb;

            store.rstate++;
            router.push({name: 'contentholder', query: { category: cat }});
        }
       
        return{
            pList, 개수선택, store, productStore,
            aonmouseleave, productClicked, imageLoad, 장바구니추가, 장바구니확인하기, gotoClickedPage, logoClick,
            megaMenuParentClicked, megaMenuClicked
        }
    }



}
</script>


<style scoped>

.currentPagingCSS {
    font-weight: 700;
    font-size: larger;
    text-decoration: underline;
    
    /* --tw-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
    --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);
    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); */
}
.clip {
    clip-path: polygon(0 0, 0% 100%, 100% 50%);
}

.rowClickedCSS {
    --tw-border-opacity: 0.25;
    background-color: rgb(209 213 219 / var(--tw-border-opacity));
}


</style>