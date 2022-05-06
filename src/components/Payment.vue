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
                    <input @change="receiverInfo.user_requests = $event.target.value" :value="receiverInfo.user_requests" class="p-1 w-96 border border-gray-300" type="text" placeholder="요청사항을 입력해주세요." >
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
            <button @click="결제하기클릭()" class="w-56 p-4 border-2 text-3xl bg-green-600 !text-white font-semibold hover:bg-green-700 rounded">
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
import { computed } from '@vue/reactivity';

export default {
    name: 'Payment',
    components: { AddressModal },

    setup() {
        const userInfo = useLoginStore();
        const store = useStore();
        const {proxy} = getCurrentInstance();
        const router = useRouter();
        const state = reactive({
            isOpened : false,       //배송지변경 버튼에 사용되는 상태변수
            buyerInfo : {},         //현재는 안쓰는중
            receiverInfo : {
                user_name: '',
                user_address1 : '',
                user_address2 : '',
                user_phone : '',
                user_requests : '',
            },
            paymentInfo : {},       //현재는 안쓰는중
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
            })[0];                                  //받아온 배열의 0번째 인덱스 == 기본배송지
            
            if (result == undefined) {              //받아온 주소지목록에 기본배송지로 설정이 안되있으면 제일처음 주소를 넣어서 받는사람정보를 초기화해준다.
                result = res.data.result[0];
            }
            console.log('[Payment] getAddressList res result: ', result);
            선택클릭(result);   //기본배송지로 지정된 객체로 배송지 초기화.

        }).catch(error => proxy.$log('[Payment] getAddressList error: ', error.response.data))

        
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
            state.receiverInfo.user_requests = state.receiverInfo.user_requests==undefined? '':state.receiverInfo.user_requests;
        }

        const 결제하기클릭 = async () => {
            let computedItemsInfo = store.cartState.filter(item => item.isChecked); //장바구니에서 체크된 아이템들만 추린 배열(결재할 상품들)
            let order_no = 0;   //밑의 post에서 받아옴.
            await http.post('/paymentc/createOrder', {
                user_id: userInfo.info.user.user_id,
                order_date: '',
                address1: state.receiverInfo.user_address1,
                address2: state.receiverInfo.user_address2,
                receiver_name: userInfo.info.user.user_name,
                receiver_phone: userInfo.info.user.user_phone,
                request: state.receiverInfo.user_requests,
                receipt_id: '',
                purchased_at: null,
                method: '',
                product_name: computedItemsInfo[0].product_name,
                product_image: computedItemsInfo[0].product_image[0],
                card_name: '',
                computedItemInfo: computedItemsInfo
            
            }).then((res) => {
                proxy.$log('결제하기클릭 res: ', res.data)
                order_no = res.data.result;

            }).catch(error=>proxy.$log('결제하기클릭 error: ', error.response.data));
            

            //실제 복사하여 사용시에는 모든 주석을 지운 후 사용하세요
            window.BootPay.request({
                price: Number(store.computedWholePrice ) + 3000, //실제 결제되는 가격 + store.배송비계산
                application_id: "625ea25f2701800020f69142",
                name:  `${computedItemsInfo[0].product_name} 외 ${computedItemsInfo.length}건`, //결제창에서 보여질 이름
                pg: 'kcp',
                method: 'npay', //결제수단, 입력하지 않으면 결제수단 선택부터 화면이 시작합니다.
                show_agree_window: 0, // 부트페이 정보 동의 창 보이기 여부
                items: computedItemsInfo.map((item) => {     //결재할 상품들을 api모듈양식에 맞게 객체를 구성하여 새로운 배열로 반환
                    return {
                        item_name: item.product_name, //상품명
                        qty: item.product_count, //수량
                        unique: item.product_no, //해당 상품을 구분짓는 primary key
                        price: item.product_price, //상품 단가
                        cat1: item.category_code, // 대표 상품의 카테고리 상, 50글자 이내
                        cat2: item.category_code, // 대표 상품의 카테고리 중, 50글자 이내
                        cat3: item.category_code, // 대표 상품의 카테고리 하, 50글자 이내
                    }
                }),

                user_info: {
                    username:  userInfo.info.user.user_name,  //'사용자 이름',
                    email: userInfo.info.user.user_email,      //'사용자 이메일',
                    addr:  state.receiverInfo.user_address1 + state.receiverInfo.user_address2,      //'사용자 주소',
                    phone: state.receiverInfo.user_phone,      //'010-1234-4567'
                },
                order_id: order_no, //고유 주문번호로, 생성하신 값을 보내주셔야 합니다. //백앤드에서 주문레코드생성후 받아와야할듯?
                params: {callback1: '그대로 콜백받을 변수 1', callback2: '그대로 콜백받을 변수 2', customvar1234: '변수명도 마음대로'},
                account_expire_at: '2020-10-25', // 가상계좌 입금기간 제한 ( yyyy-mm-dd 포멧으로 입력해주세요. 가상계좌만 적용됩니다. )
                extra: {
                    start_at: '2019-05-10', // 정기 결제 시작일 - 시작일을 지정하지 않으면 그 날 당일로부터 결제가 가능한 Billing key 지급
                    end_at: '2022-05-10', // 정기결제 만료일 -  기간 없음 - 무제한
                    vbank_result: 1, // 가상계좌 사용시 사용, 가상계좌 결과창을 볼지(1), 말지(0), 미설정시 봄(1)
                    quota: '0,2,3', // 결제금액이 5만원 이상시 할부개월 허용범위를 설정할 수 있음, [0(일시불), 2개월, 3개월] 허용, 미설정시 12개월까지 허용,
                    theme: 'purple', // [ red, purple(기본), custom ]
                    custom_background: '#00a086', // [ theme가 custom 일 때 background 색상 지정 가능 ]
                    custom_font_color: '#ffffff' // [ theme가 custom 일 때 font color 색상 지정 가능 ]
                }
            }).error(function (data) {
                //결제 진행시 에러가 발생하면 수행됩니다.
                console.log(data);
                http.get('/paymentc/cancelPaymentInProcessing', {
                    params:{ order_no: order_no }
                }).then((res) => {
                    if (res.data.result == true) {
                        proxy.$log('결제하기중 취소완료', res.data.result);
                    } else {
                        proxy.$log('결제하기중 취소실패', res.data.result);
                    }
                }).catch(error=>proxy.$log('결제하기중 취소 error: ', error.response.data));

            }).cancel(function (data) {
                //결제가 취소되면 수행됩니다.
                console.log(data);
                http.get('/paymentc/cancelPaymentInProcessing', {
                    params:{ order_no: order_no }
                }).then((res) => {
                    if (res.data.result == true) {
                        proxy.$log('결제하기중 취소완료', res.data.result);
                    } else {
                        proxy.$log('결제하기중 취소실패', res.data.result);
                    }
                }).catch(error=>proxy.$log('결제하기중 취소 error: ', error.response.data));

            }).ready(function (data) {
                // 가상계좌 입금 계좌번호가 발급되면 호출되는 함수입니다.
                console.log(data);
            }).confirm(async function (data) {
                //결제가 실행되기 전에 수행되며, 주로 재고를 확인하는 로직이 들어갑니다.
                //주의 - 카드 수기결제일 경우 이 부분이 실행되지 않습니다.
                console.log(data);
                await http.post('/paymentc/stockVerify', computedItemsInfo).then((res) => {
                    proxy.$log('결제하기클릭 confirm->stockVerify res: ', res.data);
                    var enable = res.data.result; // 재고 수량 관리 로직 혹은 다른 처리
                    if (enable) {
                        BootPay.transactionConfirm(data); // 조건이 맞으면 승인 처리를 한다.
                    } else {
                        BootPay.removePaymentWindow(); // 조건이 맞지 않으면 결제 창을 닫고 결제를 승인하지 않는다.
                        store.rstate++;
                        router.push({name: 'cart'});
                    }
                }).catch(error=>proxy.$log('결제하기클릭 confirm->stockVerify error: ', error.response.data));

            }).close(function (data) {
                // 결제창이 닫힐때 수행됩니다. (성공,실패,취소에 상관없이 모두 수행됨)
                console.log(data);
            }).done(function (data) {
                //결제가 정상적으로 완료되면 수행됩니다
                //비즈니스 로직을 수행하기 전에 결제 유효성 검증을 하시길 추천합니다.
                console.log('결제하기클릭 done: ',data);
                store.rstate++;
                let resultEnd = {
                    computedItemsInfo: computedItemsInfo,  //결제에 사용했던 데이터(상품정보 등)
                    doneInfo: data                         //결제가 완료되고 부트페이에서 내려받은 결제완료정보
                }

                //서버에 결제완료 정보 송출하여 db에 주문정보 업데이트 및 주문상품상세정보에 해당 상품정보들 추가.
                http.post('/paymentc/orderCompleted', {
                    order_no: data.order_id,
                    receipt_id: data.receipt_id,
                    purchased_at: data.purchased_at,
                    method: data.method,
                    product_name: data.item_name,
                    product_price: data.price,
                    order_state: '결제완료',
                    card_name: data.card_name,
                    card_no: data.card_no,
                    computedItemsInfo: computedItemsInfo    

                }).then((res) => {
                    console.log('결제하기클릭 done: ', res.data);
                    router.push({name: 'paymentComplete', params: resultEnd }); //params로 보내니깐 el에러남. 데이터는 넘어간다.

                }).catch(error => console.log('결제하기클릭 done error: ', error.response.data))

            });
        }
    


        return {
            ...toRefs(state), store, userInfo,
            약관동의새창열기, 배송지변경클릭, 선택클릭, 구매자폰번호수정클릭, 결제하기클릭
        }
    }
}
</script>

<style lang="scss" scoped>

</style>