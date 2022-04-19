<template>
   <div class="flex relative w-full bg-airbus-7 text-white p-3 items-center rounded-b-md">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <font-awesome-icon :icon="['far', 'credit-card']" class="text-6xl text-white"></font-awesome-icon>&nbsp;&nbsp;&nbsp;
        <div class="flex flex-col">
            <div>
                <span class="text-3xl font-extrabold antialiased">결제</span>
                <span class="text-lg font-medium antialiased text-amber-500"> Payment</span>
            </div>
            <span class="text-sm mt-1">선택한 상품을 결제합니다!</span>
        </div>
        <div class="flex absolute right-14 space-x-2">
            <div class="flex flex-col">
                <span class="text-lg font-medium antialiased ">Step 01</span>
                <span class="text-3xl font-extrabold antialiased text-slate-300">장바구니</span>
            </div>
            <div>
                <font-awesome-icon :icon="['fas', 'angles-right']" class="text-6xl text-white"></font-awesome-icon>&nbsp;&nbsp;&nbsp;
            </div>
            <div class="flex flex-col">
                <span class="text-lg font-medium antialiased">Step 02</span>
                <span class="text-3xl font-extrabold antialiased text-amber-500">주문완료</span>
            </div>
        </div>
    </div>


    <!-- 구매자 정보 확인 부분 -->
    <div class="w-full my-5">
        <div class="my-2 text-2xl">
            구매자정보
        </div>
        <div class="flex flex-col border-t-4 border-b-2 divide-y-2 divide-gray-200 border-gray-300">
            <div class="flex">
                <div class="p-3 w-36 text-right text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                    이름
                </div>
                <div class="ml-3 p-3">
                    {{ userInfo.info.user.user_name }}
                </div>
            </div>
            <div class="flex items-center">
                <div class="p-3 w-36 text-right text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                    이메일
                </div>
                <div class="ml-3 p-3">
                    {{ userInfo.info.user.user_email }}
                </div>
            </div>
            <div class="flex">
                <div class="flex items-center justify-end p-3 w-36 text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                    휴대폰 번호
                </div>
                <div class="ml-3 p-3">
                    <input @change="userInfo.info.user.user_phone = $event.target.value" :value="userInfo.info.user.user_phone" class="p-1 border border-gray-300" type="tel" name="tel" >
                    <button @click="구매자폰번호수정클릭()" class="mx-2 px-2 py-1 text-sm border border-gray-500 shadow rounded">수정</button>
                </div>
            </div>
        </div>
    </div>


    <!-- 받는 사람 정보 입력 부분 -->
    <div class="w-full my-2">
        <div class="my-2 text-2xl">
            받는사람정보
            <button @click="배송지변경클릭()" class="mx-2 px-2 py-1 text-sm border border-gray-500 shadow rounded">배송지변경</button>
        </div>
        <div class="flex flex-col border-t-4 border-b-2 divide-y-2 divide-gray-200 border-gray-300">
            <div class="flex">
                <div class="p-3 w-36 text-right text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                    이름
                </div>
                <div class="ml-3 p-3">
                    {{ receiverInfo.user_name }}
                </div>
            </div>
            <div class="flex items-center">
                <div class="p-3 w-36 text-right text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                    배송주소
                </div>
                <div class="ml-3 p-3">
                    {{ receiverInfo.user_address1 + receiverInfo.user_address2 }}
                </div>
            </div>
            <div class="flex">
                <div class="flex items-center justify-end p-3 w-36 text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                    연락처
                </div>
                <div class="ml-3 p-3">
                    {{ receiverInfo.user_phone }}
                </div>
            </div>
            <div class="flex">
                <div class="flex items-center justify-end p-3 w-36 text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                    배송 요청사항
                </div>
                <div class="ml-3 p-3">
                    <input v-model="receiverInfo.user_requests" class="p-1 w-96 border border-gray-300" type="text" placeholder="요청사항을 입력해주세요." >
                    <!-- <button class="mx-2 px-2 py-1 border border-gray-500 shadow rounded">변경</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- 결제 정보 확인 부분 -->
    <div class="w-full my-5">
        <div class="my-2 text-2xl">
            결제정보
        </div>
        <div class="flex flex-col border-t-4 border-b-2 divide-y-2 divide-gray-200 border-gray-300">
            <div class="flex">
                <div class="p-3 w-36 text-right text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                    총상품가격
                </div>
                <div class="ml-3 p-3">
                    {{ Number( store.computedWholePrice ).toLocaleString('ko-KR') }}원
                </div>
            </div>
            <div class="flex items-center">
                <div class="p-3 w-36 text-right text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                    배송비
                </div>
                <div class="ml-3 p-3">
                    {{ Number( store.배송비계산 ).toLocaleString('ko-KR') }}원
                </div>
            </div>
            <div class="flex">
                <div class="flex items-center justify-end p-3 w-36 text-zinc-700 font-semibold bg-gray-100 border-r border-gray-300">
                    총결제금액
                </div>
                <div class="ml-3 p-3">
                    {{ Number( store.computedWholePrice + store.배송비계산 ).toLocaleString('ko-KR') }}원
                </div>
            </div>
            
        </div>
    </div>


    <!-- 서비스 이용 및 약관 확인 부분 -->
    <div class="flex flex-col justify-center w-full">
        <div class="flex justify-center w-full py-5">
            구매조건 확인 및 결제대행 서비스 약관 동의
            <span class="mx-2 px-2 text-sm leading-6 border border-gray-500 shadow rounded cursor-pointer"
             @click="약관동의새창열기()">
            보기</span>
        </div>
        <div class="flex justify-center w-full">
            위 주문 내용을 확인 하였으며, 회원 본인은 개인정보 이용 및 제공 및 결제에 동의합니다.
        </div>
    </div>

    <div class="flex justify-center w-full mb-20">
        <div class="flex justify-center space-x-3 mt-12">
            <!-- <router-link :to="{name: 'contentholder'}" class="w-56 p-4 border-2 text-2xl text-center border-red-500 text-red-500 font-semibold hover:bg-red-500 hover:text-white rounded">
                계속 쇼핑하기
            </router-link> -->
            <button @click="결제하기()" class="w-56 p-4 border-2 text-3xl bg-green-600 !text-white font-semibold hover:bg-green-700 rounded">
                결제하기
            </button>
        </div>
    </div>


<!-- 배송지 정보 제어 모달 -->
<AddressModal v-model:isOpened="isOpened" v-on:선택클릭="선택클릭"></AddressModal>

</template>

<script>
import { getCurrentInstance, reactive, toRefs } from 'vue'
import { useRouter } from 'vue-router';
import AddressModal from './AddressModal.vue'
import http from '../modules/http'
import { useLoginStore } from '@/stores/login';
import { useStore } from '@/stores/store';

export default {
    name: 'Payment',
    components: { AddressModal },

    setup() {
        const userInfo = useLoginStore();
        const store = useStore();
        const {proxy} = getCurrentInstance();
        const router = useRouter();
        const state = reactive({
            count: 0,
            isOpened : false,
            buyerInfo : {},
            receiverInfo : {
                user_name: '',
                user_address1 : '',
                user_address2 : '',
                user_phone : '',
                user_requests : '',
            },
            paymentInfo : {},
        })

        //결제 페이지의 초기 정보 초기화데이터 불러오기.
        http.get('/paymentc/getAddressList', {
            params:{
                user_id : userInfo.info.id
            }
        }).then((res) => {
            proxy.$log('[Payment] getAddressList res: ', res.data);
            let result = res.data.result.filter((item,i,origin) => {
                return item.basic_address == 1;     //1(true)은 db에 기본배송지로 지정되어 있다는 말.
            })[0];

            선택클릭(result);   //기본배송지로 지정된 객체로 배송지 초기화.

        }).catch(error => proxy.$log('[Payment] getAddressList res: ', error.response.data))

        
        const 구매자폰번호수정클릭 = () => {
            //임시로 변경하는거니깐 db에 업데이할 필요는 없겠지?
            alert('변경된 휴대폰 번호를 사용하여 구매합니다.');
        }

        const 배송지변경클릭 = () => {
            state.isOpened? state.isOpened = false : state.isOpened = true;
            window.scrollTo({ top: 260, behavior: 'smooth'}); //글 클릭시 맨위로 가기 참고 - messages.scrollTo({ top: messages.scrollHeight, behavior: 'smooth' });
        }

        const 약관동의새창열기 = () => {
            let {href} = router.resolve({ name: 'tos' })
            window.open(href, '보기', 'width=800, height=700, toolbar=no, menubar=no, scrollbars=yes, resizable=yes' );
        }

        //AddressModal.vue로부터온 이벤트를 수신한뒤 실행되는 메소드
        const 선택클릭 = (item) => {
            state.receiverInfo.user_name = item.user_name;
            state.receiverInfo.user_address1 = item.user_address1;
            state.receiverInfo.user_address2 = item.user_address2;
            state.receiverInfo.user_phone = item.user_phone;
        }

        const 결제하기 = () => {
            
        }
    
        return {
            ...toRefs(state), store, userInfo,
            약관동의새창열기, 배송지변경클릭, 선택클릭, 구매자폰번호수정클릭, 결제하기
        }
    }
}
</script>

<style lang="scss" scoped>

</style>