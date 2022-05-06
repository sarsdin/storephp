<template>
    <div class="flex relative w-full bg-airbus-3 text-white p-3 items-center rounded-b-md">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <font-awesome-icon :icon="['fas', 'truck']" class="text-6xl text-white"></font-awesome-icon>&nbsp;&nbsp;&nbsp;
        <div class="flex flex-col">
            <div>
                <span class="text-3xl font-extrabold antialiased">주문조회</span>
                <span class="text-lg font-medium antialiased text-amber-300">Order Check</span>
            </div>
            <span class="text-sm mt-1">구매하신 주문내역을 확인할 수 있습니다!</span>
        </div>
        <div class="flex absolute right-14 space-x-2">
            <div class="flex flex-col">
                <span class="text-lg font-medium antialiased ">Order State</span>
                <span class="text-3xl font-extrabold antialiased text-amber-300">주문현황</span>
            </div>
            <div>
                <font-awesome-icon :icon="['fas', 'angles-left']" class="text-6xl text-white"></font-awesome-icon>&nbsp;&nbsp;&nbsp;
                <!-- <font-awesome-icon :icon="['fas', 'angles-right']" class="text-6xl text-white"></font-awesome-icon>&nbsp;&nbsp;&nbsp; -->
            </div>
            <div class="flex flex-col">
                <span class="text-lg font-medium antialiased">Closed Order</span>
                <span class="text-3xl font-extrabold antialiased text-slate-300">주문내역</span>
            </div>
        </div>
    </div>

    <!-- 내용시작 -->
    <div class="flex w-full my-4 space-x-1">
        <button @click="기간클릭(1)" class="px-2 py-1 border border-gray-700 rounded-full"
        :class="{ 'bg-blue-600 text-white': myStore.orderCheck.orderCheckRangeCSS == 1 }"
        >최근 1일</button>
        <button @click="기간클릭(7)" class="px-2 py-1 border border-gray-700 rounded-full"
        :class="{ 'bg-blue-600 text-white': myStore.orderCheck.orderCheckRangeCSS == 7 }"
        >최근 7일</button>
        <button @click="기간클릭(99)" class="px-4 py-1 border border-gray-700 rounded-full"
        :class="{ 'bg-blue-600 text-white': myStore.orderCheck.orderCheckRangeCSS == 99 }"
        >2022</button>
    </div>

    <!-- 목록 시작 -->
    <div class="flex flex-col w-full mt-4">
        <!-- <div class="flex items-center text-lg bg-zinc-100 border-y border-gray-300 h-14">
        </div> -->

        <!-- 주문 목록 레이아웃 -->
        <div v-for="item in myStore.orderCheckList" :key="item.order_no" class="flex justify-center">
            <div class="">
                <!-- 목록 시작  v-for="item in myStore.orderCheckList" v-bind:key="item.product_name" -->
                <div class="flex flex-col items-center w-[960px] max-w-[970px] min-w-[323px] px-2 py-7 mb-10 shadow-md border rounded-lg"> <!-- w-screen -->
                    <div class="flex w-[920px] px-4 pb-4 justify-between text-xl font-bold rounded-lg">
                        <div class="text-2xl">
                            {{new Intl.DateTimeFormat('ko-KR', {year:'numeric',month:'numeric',day:'2-digit'}).format(new Date(Date.parse(item.order_date))) }} 주문
                        </div>
                        <div class="p-1 cursor-pointer">
                            <button @click="주문상세보기클릭(item)" class="text-blue-600">주문 상세보기</button>&nbsp;
                            <font-awesome-icon :icon="['fas', 'angle-right']" class="text-blue-500"></font-awesome-icon>
                        </div>
                    </div>

                    <div class="flex w-[900px] p-4 border rounded-lg shadow-sm" >

                        <div class="flex flex-1 relative">
                            <img alt="이미지를 로드할 수 없습니다. 재시도 요망" :src="imageLoad(item)"
                                class="object-cover mr-2 w-36 h-36 bg-slate-200 rounded-md"  />
                            <!-- itemImgLoad != null? itemImgLoad:'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif'  -->
                            <div class="ml-1 mt-2 text-xl">
                                <div>
                                    {{ item.product_name }}
                                </div>
                                <div class="mt-5 text-gray-500">
                                    총 결제 금액: {{ Number(item.product_price).toLocaleString('ko-KR') }} 원
                                </div>
                                <div v-if="운송장번호온오프(item)" class="mt-5 text-gray-500">
                                    운송장번호: {{ item.transport_code }}
                                </div>
                            </div>
                            <div class="absolute right-5 top-1">
                                <button @click="문의하기(item)" class="p-1 text-gray-500 border hover:bg-gray-100 rounded-md">요청</button>
                            </div>
                        </div>

                        <div class="flex flex-col justify-center items-center pl-4 w-56 h-full space-y-2 border-l-2">
                            <div>
                                <button class="w-48 py-2 text-blue-700 border border-blue-600 rounded"> 
                                    {{ item.order_state }}
                                </button>
                            </div>
                            <div>
                                <button @click="주문상세보기클릭(item)" class="w-48 py-2 text-blue-700 border border-blue-600 rounded">리뷰 작성하기</button>
                            </div>
                            <div>
                                <button v-if="item.is_cancel != null" class="w-48 py-2 text-gray-400 border border-gray-400 rounded">취소요청완료</button>
                                <button v-if="item.is_cancel == null" @click="주문취소클릭(item)" class="w-48 py-2 text-blue-700 border border-blue-600 rounded">주문취소</button>
                            </div>
                        </div>

                    </div>

                    

                </div>
            </div>

            <!-- <div v-if="store.cartCount == 0" class="flex justify-center w-full p-2 text-xl text-center">
                장바구니가 비어 있습니다.
            </div> -->

            <!-- 배송비 레이아웃 -->
            <!-- <div v-if="store.cartCount > 0" class="flex items-center justify-center border-b h-full w-28">
                {{ Number(배송비계산).toLocaleString('ko-KR') }}원
            </div> -->
        </div>

        <!-- 주문금액 합계표시 레이아웃 -->
        <!-- <div class="flex pr-7 items-center justify-end text-lg space-x-4 bg-zinc-100 border-y border-gray-300 h-14">
            <span class="text-sm">
                상품가격 <b class="text-xl"> {{ Number( store.computedWholePrice ).toLocaleString('ko-KR') }}원 </b>
            </span>
            <font-awesome-icon :icon="['fas', 'plus']" class="p-1 border rounded-full bg-gray-400 text-sm text-white"></font-awesome-icon>
            <span class="text-sm">
                배송비 <b class="text-xl"> {{ Number(배송비계산).toLocaleString('ko-KR') }}원 </b>
            </span>
            <font-awesome-icon :icon="['fas', 'equals']" class="p-1 border rounded-full bg-gray-400 text-sm text-white"></font-awesome-icon>
            <span class="text-sm">
                주문금액 <b class="text-xl text-red-600"> {{ Number( store.computedWholePrice + 배송비계산).toLocaleString('ko-KR') }}원 </b>
            </span>
        </div> -->

        <!-- <div class="flex items-center mt-3 space-x-3">
            <button @click="선택된장바구니개체삭제()" class="p-2 border-2 bg-slate-50 hover:bg-red-500 hover:text-white rounded">선택삭제</button>
            <span class="text-gray-500">
                (총 {{ store.cartCount }}개중 {{ store.cartState.filter(item => item.isChecked).length }}개 선택)
            </span>
        </div> -->

        <!-- <div class="flex justify-center space-x-3 mt-12">
            <router-link :to="{name: 'contentholder'}" class="w-56 p-4 border-2 text-2xl text-center border-red-500 text-red-500 font-semibold hover:bg-red-500 hover:text-white rounded">
                계속 쇼핑하기
            </router-link>
            <button @click="toPaymentPage()" class="w-56 p-4 border-2 text-2xl bg-red-500 !text-white font-semibold hover:bg-red-600 rounded">
                구매하기
            </button>
        </div> -->
        
        <br>
        <br>
    </div>
</template>

<script>
import { useStore } from '@/stores/store'
import { ref, reactive, computed, toRefs, getCurrentInstance } from 'vue'
import { useRouter } from 'vue-router'
import http from '@/modules/http'
import { useLoginStore } from '@/stores/login';
import { useMyStore } from '@/stores/my';

export default {
    name: 'OrderCheck',
    setup() {
        const {proxy} = getCurrentInstance();
        const store = useStore();
        const myStore = useMyStore();
        const userInfo = useLoginStore();
        const router = useRouter();
    
        const state = reactive({
            count: 0,
        })
        
        myStore.주문조회리스트로드();

        //대표이미지 로딩
        const imageLoad = (item) => {
            if (item.product_image != null) {
                return 'http://192.168.112.128/uploads/'+item['product_image'];
            } else {
                return 'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif'
            }
        }

        const 기간클릭 = (기간) => {
            myStore.orderCheck.orderCheckRangeCSS = 기간;
            myStore.주문조회리스트로드();
        }

        const 주문상세보기클릭 = (item) => {
            window.scrollTo({top: 0});
            myStore.orderCheck.orderInfo = item;

            router.push({
                name: 'orderCheckDetail', 
            })
        }

        const 주문취소클릭 = (item) => {
            let cancel_msg = prompt('취소사유를 입력해주세요.');
            //todo: 주문취소처리
            http.post('/paymentc/orderCancel', {
                order_no: item.order_no,
                receipt_id: item.receipt_id,
                receiver_name: item.receiver_name,
                cancel_msg: cancel_msg,
                cancel_id: '',
            }).then((res) => {
                proxy.$log('[OrderCheck] 주문취소클릭 res: ', res.data)
                myStore.주문관리리스트로드();
                
            }).catch(error=>console.log('[OrderCheck] 주문취소클릭 error: ', error.response.data))
        }

        const 운송장번호온오프 = (item) => {
            if ((item.transport_code != '') && (item.transport_code != null)) {
                return true;
            } else {
                return false;
            }
        }
      
        const 문의하기 = (item) => {
            let req = prompt('요청할 사항을 입력해주세요.');

            http.post('/paymentc/requestOrderToAdmin', {
                order_no : item.order_no,
                order_qa_writer: item.user_id,
                order_qa_content: req
            }).then((res) => {
                proxy.$log('[OrderCheck] 문의하기 res: ', res.data)


            }).catch(error=> console.log('[OrderCheck] 문의하기 error: ', error ))
        }


    
        return {
            ...toRefs(state),
            store, myStore,  
            imageLoad, 기간클릭, 주문상세보기클릭, 주문취소클릭, 운송장번호온오프, 문의하기

        }
    }
}
</script>

<style lang="scss" scoped>

</style>