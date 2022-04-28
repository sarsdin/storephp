<template>
<div v-for="item in pList" v-bind:key="item.product_name" id="contentholderrootdiv" class="max-w-[323px] min-w-[323px] p-4"> <!-- w-screen -->
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
                        ￦{{item.product_price.toLocaleString()}}
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
</template>

<script>
import { ref, onMounted, getCurrentInstance, computed } from 'vue';
import { useRouter } from "vue-router";
import http from "@/modules/http";
import { useStore } from '@/stores/store';
import { useLoginStore } from '@/stores/login';

export default {
    name: 'Contentholder',
    props:{
        it :{ type: Array }  //Home items에서 넘어온 값
        // item:{ name: String, price: Number, expire: Number }
    },
    setup(props) {
        const {proxy} = getCurrentInstance();
        const store = useStore();
        const userInfo = useLoginStore();
        const router = useRouter();
        // const itemImg = ref({});
        const pList = ref([]);
        const 개수선택 = ref(1);
        // const 장바구니팝업온오프 = ref(false);
        
        //상품리스트 서버에서 로드
        http.get('/productc/pList').then((res) => {
            pList.value = res.data;
            pList.value.forEach((item,i,origin) => {
                origin[i].count = 1;
                origin[i].popupOnOff = false;
            })
        })
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
                || ('cartPopup' in e.target.dataset === true )  //dataset안에 해당 속성이 설정되있는지 html tag내에서는 -(대쉬)case로 설정됨
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

        
        // onMounted(()=>{
        //     alert(document.cookie );
        // })

        return{
            pList, 개수선택, store, 
            aonmouseleave, productClicked, imageLoad, 장바구니추가, 장바구니확인하기
        }
    }



}
</script>
