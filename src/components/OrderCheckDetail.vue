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
                <span class="text-3xl font-extrabold antialiased text-slate-300">주문현황</span>
            </div>
            <div>
                <font-awesome-icon :icon="['fas', 'angles-right']" class="text-6xl text-white"></font-awesome-icon>&nbsp;&nbsp;&nbsp;
                <!-- <font-awesome-icon :icon="['fas', 'angles-right']" class="text-6xl text-white"></font-awesome-icon>&nbsp;&nbsp;&nbsp; -->
            </div>
            <div class="flex flex-col">
                <span class="text-lg font-medium antialiased">Order Detail</span>
                <span class="text-3xl font-extrabold antialiased text-amber-300">주문상세</span>
            </div>
        </div>
    </div>


    <!-- 목록 시작 -->
    <div class="flex flex-col w-full mt-4">
        <!-- <div class="flex items-center text-lg bg-zinc-100 border-y border-gray-300 h-14">
        </div> -->

        <!-- 주문 목록 레이아웃 -->
        <div  class="flex justify-center">
            <div class="">
                <!-- 목록 시작  v-for="item in myStore.orderCheckList" v-bind:key="item.product_name" -->
                <div class="flex flex-col items-center w-[960px] max-w-[970px] min-w-[323px] px-2 py-7 mb-10 shadow-md border rounded-lg"> <!-- w-screen -->
                    <div class="flex w-[920px] px-4 pb-4 justify-between text-xl font-bold rounded-lg">
                        <div class="text-2xl">
                            <!-- {{new Intl.DateTimeFormat('ko-KR', {year:'numeric',month:'numeric',day:'2-digit'}).format(new Date(Date.parse(item.order_date))) }} 주문 -->
                            {{new Intl.DateTimeFormat('ko-KR', {year:'numeric',month:'numeric',day:'2-digit'}).format(new Date(Date.parse(orderInfo.order_date))) }}
                             주문상세 &nbsp;
                             <span class="text-gray-500 font-mono">
                                 주문번호 {{ orderInfo.order_no }}
                             </span>
                        </div>
                        <!-- <div class="p-1 cursor-pointer">
                            <button class="text-blue-600">주문 상세보기</button>&nbsp;
                            <font-awesome-icon :icon="['fas', 'angle-right']" class="text-blue-500"></font-awesome-icon>
                        </div> -->
                    </div>

                    <div v-for="item in items" :key="item.order_detail_no"  class="flex w-[900px] p-4 mb-4 border rounded-lg shadow-sm" >

                        <div class="flex flex-1">
                            <img alt="이미지를 로드할 수 없습니다. 재시도 요망" :src="imageLoad(item)" @click="주문상세이미지클릭(item)"
                                class="object-cover mr-2 w-36 h-36 bg-slate-200 rounded-md cursor-pointer"  />
                            <!-- itemImgLoad != null? itemImgLoad:'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif'  -->
                            <div class="ml-1 mt-2 text-xl">
                                <div>
                                    {{ item.product_name+' '+item.product_count+'개' }}
                                </div>
                                <div class="mt-5 text-gray-500">
                                    총 결제 금액: {{ Number(item.product_price).toLocaleString('ko-KR') }} 원
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col justify-center items-center pl-4 w-56 h-36 space-y-2 border-l-2">
                            <div>
                                <!-- <button class="w-48 py-2 text-blue-700 border border-blue-600 rounded"> {{ item.order_state }}</button> -->
                            </div>
                            <div>
                                <button v-if="item.is_review_created == false" @click="item.isReviewModalOpen = true" class="w-48 py-2 text-blue-700 border border-blue-600 rounded"
                                >리뷰 작성하기</button>
                                <button v-else class="w-48 py-2 text-gray-400 border border-gray-400 rounded"
                                >리뷰 작성완료</button>
                            </div>
                            <div>
                                <!-- <button class="w-48 py-2 text-blue-700 border border-blue-600 rounded">주문취소</button> -->
                            </div>
                        </div>

                        <!-- <button @click="isReviewModal = true">모달열기테스트버튼</button> -->
                        <Teleport to="body">
                            <ReviewModal v-if="item.isReviewModalOpen" :item="item" @modalOff="item.isReviewModalOpen = false, 리뷰작성하기(item)">
                                <template v-slot:reviewModal >  
                                    
                                
                                </template>
                            </ReviewModal>

                        </Teleport>

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

        <!-- 받는 사람 정보 부분 -->
        <div class="w-full my-2">
            <div class="my-2 text-2xl text-gray-700 font-semibold">
                받는사람 정보
                <!-- <button @click="배송지변경클릭()" class="mx-2 px-2 py-1 text-sm border border-gray-500 shadow rounded">배송지변경</button> -->
            </div>
            <div class="flex flex-col border-t-4 border-b-2 divide-y-2 divide-gray-200 border-gray-300">
                <div class="flex">
                    <div class="p-3 w-36 text-right text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                        받는사람
                    </div>
                    <div class="ml-3 p-3">
                        {{ orderInfo.receiver_name }}
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="p-3 w-36 text-right text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                        배송주소
                    </div>
                    <div class="ml-3 p-3">
                        {{ orderInfo.address1 + orderInfo.address2 }}
                    </div>
                </div>
                <div class="flex">
                    <div class="flex items-center justify-end p-3 w-36 text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                        연락처
                    </div>
                    <div class="ml-3 p-3">
                        {{ orderInfo.receiver_phone }}
                    </div>
                </div>
                <div class="flex">
                    <div class="flex items-center justify-end p-3 w-36 text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                        배송 요청사항
                    </div>
                    <div class="ml-3 p-3">
                        {{ orderInfo.request }}
                        <!-- <input @change="receiverInfo.user_requests = $event.target.value" :value="receiverInfo.user_requests" class="p-1 w-96 border border-gray-300" type="text" placeholder="요청사항을 입력해주세요." > -->
                        <!-- <button class="mx-2 px-2 py-1 border border-gray-500 shadow rounded">변경</button> -->
                    </div>
                </div>
            </div>
        </div>

            <!-- 결제 정보 확인 부분 -->
        <div class="w-full my-5">
            <div class="my-2 text-2xl text-gray-700 font-semibold">
                결제정보
            </div>
            <div class="flex flex-col border-t-4 border-b-2 divide-y-2 divide-gray-200 border-gray-300">
                <div class="flex">
                    <div class="p-3 w-36 text-right text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                        총상품가격
                    </div>
                    <div class="ml-3 p-3">
                        {{ Number( sumItemsOfPrice ).toLocaleString('ko-KR') }}원
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="p-3 w-36 text-right text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                        배송비
                    </div>
                    <div class="ml-3 p-3">
                        {{ Number( 3000 ).toLocaleString('ko-KR') }}원
                    </div>
                </div>
                <div class="flex">
                    <div class="flex items-center justify-end p-3 w-36 text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                        결제수단
                    </div>
                    <div class="ml-3 p-3">
                        {{ `카드명: ${orderInfo.card_name}    카드번호: ${orderInfo.card_no}    결제방법: ${orderInfo.method}    결제시간: ${orderInfo.purchased_at}` }}
                    </div>
                </div>
                <div class="flex">
                    <div class="flex items-center justify-end p-3 w-36 text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                        총결제금액
                    </div>
                    <div class="ml-3 p-3">
                        {{ Number( Number(orderInfo.product_price) ).toLocaleString('ko-KR') }}원
                    </div>
                </div>
                
            </div>
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

        <div class="flex justify-between space-x-3 mt-12">
            <button @click="goToPage('주문목록')" class="w-72 p-3 border-2 text-xl bg-white text-blue-500 font-semibold hover:bg-blue-600 hover:text-white border-blue-500 rounded">
                <font-awesome-icon :icon="['fas', 'angles-left']" class="text-xl text-blue hover:text-white"></font-awesome-icon>
                주문목록으로 돌아가기
            </button>
            <button @click="goToPage('홈')"  class="w-56 p-3 border-2 text-xl text-center text-blue-500 font-semibold hover:bg-blue-600 hover:text-white border-blue-500 rounded">
                쇼핑하러 가기
            </button>
        </div>
        
        <br>
        <br>
    </div>

    <!-- 후기 작성 모달 --><!-- v-slot:reviewModal == #reviewModal-->
    <!-- <button @click="isReviewModal = true">모달열기테스트버튼</button>
    <Teleport to="body">
        <ReviewModal v-if="isReviewModal">
            <template v-slot:reviewModal>  
                
            
            </template>
        </ReviewModal>

    </Teleport> -->

</template>

<script>
import { useStore } from '@/stores/store'
import { ref, reactive, computed, toRefs, getCurrentInstance } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import http from '@/modules/http'
import { useLoginStore } from '@/stores/login';
import { useMyStore } from '@/stores/my';
import ReviewModal from './ReviewModal.vue'

export default {
    name: 'OrderCheck',
    components: { ReviewModal },
    setup(props) {
        const {proxy} = getCurrentInstance();
        const store = useStore();
        const myStore = useMyStore();
        const userInfo = useLoginStore();
        const router = useRouter();
        const route = useRoute();
    
        const state = reactive({
            count: 0,
            orderInfo: {},
            items: [],                  //주문번호정보를 이용하여 서버로부터 불러온 실제 구매한 상품들 목록
            // isReviewModal: false,
        })
        // state.orderInfo = route.params;  //OrderCheck페이지에서 주문조회클릭으로 넘어온 값 == 에러남
        state.orderInfo =  myStore.orderCheck.orderInfo; //OrderCheck페이지에서 주문상세보기클릭으로 넘어온 값
        
        const sumItemsOfPrice = computed(() => {    //받아온 주문상세의 각 상품들의 가격의 합
            let sum = state.items.reduce((prev, currentv) => {
                return Number(prev) + Number(currentv.product_price);
            }, 0)
            return sum;
        })
        
        const 주문상세불러오기 = () => {
            proxy.$log('[OrderCheckDetail] 주문상세불러오기 state.orderInfo: ', state.orderInfo)

            http.post('/paymentc/getOrderCheckDetail', {
                order_no : state.orderInfo.order_no,
                user_id : state.orderInfo.user_id

            }).then((res) => {
                proxy.$log('[OrderCheckDetail] 주문상세불러오기 res: ', res.data)
                state.items = res.data.result;
                state.items.forEach((item,i,origin) => {
                    origin[i].isReviewModalOpen = false;    //주문상세 개별아이템의 리뷰작성하기 버튼클릭시 각해당하는 모달의 오픈여부를 위해 넣어줌.
                })

            }).catch(error => console.log('[OrderCheckDetail] 주문상세불러오기 error: ', error.response.data))
        }
        if (state.orderInfo == null || state.orderInfo == undefined || Object.keys(state.orderInfo).length == 0) {
            alert('잘못된 접근입니다. 홈으로 갑니다.');
            // store.rstate++;
            router.push({name: 'contentholder'});
        } else {
            주문상세불러오기();
        }


        //대표이미지 로딩
        const imageLoad = (item) => {
            if (item.product_image != null) {
                return 'http://192.168.112.128/uploads/'+item['product_image'];
            } else {
                return 'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif'
            }
        }

        //goToPage('주문목록')
        const goToPage = (where) => {
            if (where == '홈') {
                window.scrollTo({top:0});
                router.push('/');
            } else {
                router.push({name: 'orderCheck'});
            }
        }

        //리뷰작성하기 클릭시
        const 리뷰작성하기 = (item) => {
            주문상세불러오기();
            // window.scrollTo({ top: 0, behavior:'smooth'})
            
            if (item.is_review_created == "1") {
                let doYouGo = confirm('리뷰를 작성했습니다. 확인하시겠습니까?');
                if (doYouGo) {
                    router.push({name: 'productDetail', query: { product_no: item.product_no }}); //후기 작성 후 이동할지 물어보기
                } 
            }
        }
      
        //주문상세 상품 이미지클릭시
        const 주문상세이미지클릭 = (item) => {
            router.push({name: 'productDetail', query: { product_no: item.product_no }}); 
            
        }
    
        return {
            ...toRefs(state),
            store, myStore,  sumItemsOfPrice,
            imageLoad, goToPage, 리뷰작성하기, 주문상세이미지클릭

        }
    }
}
</script>

<style lang="scss" scoped>

</style>