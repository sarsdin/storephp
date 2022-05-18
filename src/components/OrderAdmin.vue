<template>
    <div class="flex relative w-full bg-airbus-8 text-white p-3 items-center rounded-b-md">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <font-awesome-icon :icon="['fas', 'screwdriver-wrench']" class="text-6xl text-white"></font-awesome-icon>&nbsp;&nbsp;&nbsp;
        <div class="flex flex-col">
            <div>
                <span class="text-3xl font-extrabold antialiased">주문관리</span>
                <span class="text-lg font-medium antialiased text-amber-300">Order Admin</span>
            </div>
            <span class="text-sm mt-1">관리자 전용 주문관리 페이지입니다.</span>
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
    <div class="flex justify-between w-full my-4 space-x-1">
        <div class="space-x-1">
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
        <div class="space-x-1">
            <button @click="주문상태카테고리변경('결제완료')" class="px-2 py-1 border border-gray-700 rounded-full"
            :class="{ 'bg-blue-600 text-white': myStore.orderCheck.orderStateRangeCSS == '결제완료' }"
            >결제완료</button>
            <button @click="주문상태카테고리변경('배송준비')" class="px-2 py-1 border border-gray-700 rounded-full"
            :class="{ 'bg-blue-600 text-white': myStore.orderCheck.orderStateRangeCSS == '배송준비' }"
            >배송준비</button>
            <button @click="주문상태카테고리변경('배송중')" class="px-3 py-1 border border-gray-700 rounded-full"
            :class="{ 'bg-blue-600 text-white': myStore.orderCheck.orderStateRangeCSS == '배송중' }"
            >배송중</button>
            <button @click="주문상태카테고리변경('배송완료')" class="px-2 py-1 border border-gray-700 rounded-full"
            :class="{ 'bg-blue-600 text-white': myStore.orderCheck.orderStateRangeCSS == '배송완료' }"
            >배송완료</button>
            <button @click="주문상태카테고리변경('전체')" class="px-4 py-1 border border-gray-700 rounded-full"
            :class="{ 'bg-blue-600 text-white': myStore.orderCheck.orderStateRangeCSS == '전체' }"
            >전체</button>
        </div>
    </div>

    <!-- 목록 시작 -->
    <div class="flex flex-col w-full mt-4">
        <!-- <div class="flex items-center text-lg bg-zinc-100 border-y border-gray-300 h-14">
        </div> -->

        <!-- 주문 목록 레이아웃 -->
        <div v-for="(item, index) in myStore.orderCheckList" :key="item.order_no" class="flex justify-center">
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

                        <div class="flex flex-1">
                            <!-- <img alt="이미지를 로드할 수 없습니다. 재시도 요망" :src="imageLoad(item)"
                                class="object-cover mr-2 w-36 h-36 bg-slate-200 rounded-md"  /> -->
                            <!-- itemImgLoad != null? itemImgLoad:'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif'  -->
                            <div class="ml-1 mt-1 text-base">
                                <div>
                                    {{ item.product_name }}
                                </div>
                                <div class="mt-1 text-gray-500">
                                    총 결제 금액: {{ Number(item.product_price).toLocaleString('ko-KR') }} 원
                                </div>
                                <div class="mt-1 text-gray-500">
                                    결제일시: {{ item.purchased_at }}
                                </div>
                                <div class="mt-1 text-gray-500">
                                    결제방법: {{ item.method }}
                                </div>
                                <div class="mt-1 text-gray-500">
                                    결제카드: {{ item.card_name }}
                                </div>
                                <div class="mt-1 text-gray-500">
                                    카드번호: {{ item.card_no }}
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-1">
                            <!-- <img alt="이미지를 로드할 수 없습니다. 재시도 요망" :src="imageLoad(item)"
                                class="object-cover mr-2 w-36 h-36 bg-slate-200 rounded-md"  /> -->
                            <!-- itemImgLoad != null? itemImgLoad:'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif'  -->
                            <div class="ml-1 mt-1 text-base">
                                <div class="mt-1 text-gray-500">
                                    영수증ID: {{ item.receipt_id }}
                                </div>
                                <div class="mt-1 text-gray-500">
                                    주문회원ID: {{ item.user_id }}
                                </div>
                                <div class="mt-1 text-gray-500">
                                    받는사람: {{ item.receiver_name }}
                                </div>
                                <div class="mt-1 text-gray-500">
                                    배송지주소: {{ item.address1 + item.address2 }}
                                </div>
                                <div class="mt-1 text-gray-500">
                                    연락처: {{ item.receiver_phone }}
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col justify-center items-center pl-4 w-60 h-42 space-y-2 border-l-2">
                                <!-- text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 -->
                                <!-- <button class="w-48 py-2 text-blue-700 border border-blue-600 rounded"> {{ item.order_state }}</button> -->
                            <div class="flex flex-wrap py-2 w-48">
                                <div class="flex items-center mr-4">
                                    <input @click="주문상태변경(item,$event)" :id="'red-radio'+index" type="radio" value="결제완료" 
                                    :checked="item.order_state=='결제완료'" class="w-4 h-4" >
                                    <label :for="'red-radio'+index" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">결제완료</label>
                                </div>
                                <div class="flex items-center mr-4">
                                    <input @click="주문상태변경(item, $event)" :id="'green-radio'+index" type="radio" value="배송준비"  
                                    :checked="item.order_state=='배송준비'" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label :for="'green-radio'+index" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">배송준비</label>
                                </div>
                                <div class="flex items-center mr-4">
                                    <input @click="주문상태변경(item,$event)" :id="'purple-radio'+index" type="radio" value="배송중"  
                                    :checked="item.order_state=='배송중'" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label :for="'purple-radio'+index" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">배송중</label>
                                </div>
                                <div class="flex items-center mr-4">
                                    <input @click="주문상태변경(item,$event)" :id="'teal-radio'+index" type="radio" value="배송완료"  
                                    :checked="item.order_state=='배송완료'" class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label :for="'teal-radio'+index" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">배송완료</label>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <button @click="요청사항(item)" class="w-48 py-2 text-blue-700 border border-blue-600 rounded"
                                >요청사항</button> 
                                <!-- 요청사항 클릭시 isCustomerReqModalOpen = true 됨 -->

                                <div v-if="item.order_qa_list.length > 0"
                                class="absolute top-1 right-1 w-5 h-5 transform translate-x-1/2 -translate-y-1/2 bg-amber-400 text-base text-white font-semibold text-center leading-none rounded-full">
                                    {{ item.order_qa_list.length }} 
                                </div>

                                <Teleport to="body">
                                    <CustomerReqModal v-if="item.isCustomerReqModalOpen" :item="item" @modalOff="item.isCustomerReqModalOpen = false">
                                        <template v-slot:customerReqModal >  
                                            
                                        
                                        </template>
                                    </CustomerReqModal>

                                </Teleport>

                            </div>
                            <div>
                                <button @click="주문취소클릭(item)" class="w-48 py-2 text-blue-700 border border-blue-600 rounded">주문취소</button>
                            </div>
                        </div>

                    </div>

                    

                </div>
            </div>

            <div v-if="store.cartCount == 0" class="flex justify-center w-full p-2 text-xl text-center">
                장바구니가 비어 있습니다.
            </div>

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
import CustomerReqModal from './CustomerReqModal.vue'

export default {
    name: 'OrderAdmin',
    components: { CustomerReqModal },
    setup() {
        const {proxy} = getCurrentInstance();
        const store = useStore();
        const myStore = useMyStore();
        const userInfo = useLoginStore();
        const router = useRouter();
    
        const state = reactive({
            count: 0,
        })
        
        myStore.주문관리리스트로드();

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
            myStore.주문관리리스트로드();
        }

        const 주문상태카테고리변경 = (orderState) => {
            store.rstate++;
            myStore.orderCheck.orderStateRangeCSS = orderState;
            myStore.주문관리리스트로드();
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
                proxy.$log('[OrderAdmin] 주문취소클릭 res: ', res.data)
                myStore.주문관리리스트로드();

            }).catch(error=>console.log('[OrderAdmin] 주문취소클릭 error: ', error.response.data))
        }

        const 주문상태변경 = (item, e) => {
            let transport_code = '';
            if (e.target.value == '배송중') {
                transport_code = prompt('운송장번호를 입력해주세요.'); //배송중을 클릭하면 송장번호 입력창 뜨게끔.
            }
            item.order_state = e.target.value;
            http.post('/paymentc/updateOrderState', {
                order_state: item.order_state,
                order_no : item.order_no,
                transport_code: transport_code

            }).then((res) => {
                console.log('[OrderAdmin] 주문상태변경 res: ', res.data)

            }).catch(error=>console.log('[OrderAdmin] 주문상태변경 error: ', error.response.data))
        }

        const 요청사항 = (item) => {
            item.isCustomerReqModalOpen = true;
        }

      
    
        return {
            ...toRefs(state),
            store, myStore,  
            imageLoad, 기간클릭, 주문상세보기클릭, 주문취소클릭, 주문상태변경, 주문상태카테고리변경, 요청사항

        }
    }
}
</script>

<style lang="scss" scoped>

</style>