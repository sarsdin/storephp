<template>
    <div class="flex relative w-full bg-airbus-7 text-white p-3 items-center rounded-b-md">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <font-awesome-icon :icon="['fas', 'cart-shopping']" class="text-6xl text-white"></font-awesome-icon>&nbsp;&nbsp;&nbsp;
        <div class="flex flex-col">
            <div>
                <span class="text-3xl font-extrabold antialiased">장바구니</span>
                <span class="text-lg font-medium antialiased text-amber-500">Shopping Cart</span>
            </div>
            <span class="text-sm mt-1">장바구니의 상품 목록을 구매할 수 있습니다!</span>
        </div>
        <div class="flex absolute right-14 space-x-2">
            <div class="flex flex-col">
                <span class="text-lg font-medium antialiased ">Step 01</span>
                <span class="text-3xl font-extrabold antialiased text-amber-500">장바구니</span>
            </div>
            <div>
                <font-awesome-icon :icon="['fas', 'angles-right']" class="text-6xl text-white"></font-awesome-icon>&nbsp;&nbsp;&nbsp;
            </div>
            <div class="flex flex-col">
                <span class="text-lg font-medium antialiased">Step 02</span>
                <span class="text-3xl font-extrabold antialiased text-slate-300">주문완료</span>
            </div>
        </div>
    </div>

    <div class="flex flex-col w-full mt-4">
        <div class="flex items-center text-lg bg-zinc-100 border-y border-gray-300 h-14">
            <span class="ml-5">
                <input @click="allCheck($event)" class="w-4 h-4" type="checkbox" name="allCheck" checked >
                전체선택
            </span>
            <span class="ml-72">
                상품정보
            </span>
            <span class="ml-72">
                상품금액
            </span>
            <span class="ml-12">
                배송비
            </span>
        </div>

        <!-- 장바구니 목록 레이아웃 -->
        <div class="flex">
            <div class="">
                <!-- 목록 시작 -->
                <div v-for="item in store.cartState" :key="item.product_no" class="flex items-center h-32 border-b border-gray-300"
                    :class="{'!text-slate-300': item.product_stock == 0}">
                    <div class="p-5">
                        <input @click="checkBoxClicked(item)" class="w-4 h-4" type="checkbox" name="allCheck" :checked="item.isChecked" >
                    </div>
        
                    <div class="mx-7">
                        <img :src="imgLoad(item)" alt="상품이미지" class="object-cover w-[120px] h-full rounded-md" />
                    </div>
        
                    <div class="flex flex-col w-[500px] h-full">
                        <div class="flex h-16 items-center p-2 border-b border-gray-300">
                            <span class="max-h-full overflow-hidden">
                                {{ item.product_name }}&nbsp;
                                <span class="text-xs text-gray-400">규격: {{ item.product_spec }}</span> 
                                
                            </span>
                        </div>
                        <div class="flex relative h-16 p-2">
                            <span class="text-slate-500">
                                2~3일 배송기간
                            </span>
                            <div class="absolute right-3 space-x-2">
                                <span class="text-slate-500">
                                    {{ Number(item.product_price).toLocaleString('ko-KR') }}원
                                </span>
                                <span v-if="item.product_stock == 0" class="text-lg font-bold text-red-500"> [재고 없음]</span> 
                                <span v-else>
                                    <input @change="장바구니추가(item)" v-model.number="item.product_count" class="w-10 border border-zinc-400 text-center" min="1" type="number" name="selectCount" >개
                                </span>
                                <button @click="장바구니에서삭제(item)" class="px-1 text-gray-400 transition duration-150 ease-in-out ring-1 focus:ring-1 ring-gray-300
                                focus:outline-none focus:ring-gray-600" aria-label="product delete" role="button">
                                    <font-awesome-icon :icon="['fas', 'x']" class="text-md text-zinc-400 hover:text-gray-600"></font-awesome-icon>
                                </button>
                            </div>
                        </div>
                    </div>
        
                    <div class="flex items-center justify-center h-full w-28 ml-3 border-x">
                        {{ Number(item.computed_price).toLocaleString('ko-KR') }}원
                    </div>
                </div> <!-- 목록 종료 -->
            </div>
            <div v-if="store.cartCount == 0" class="flex justify-center w-full p-2 text-xl text-center">
                장바구니가 비어 있습니다.
            </div>

            <!-- 배송비 레이아웃 -->
            <div v-if="store.cartCount > 0" class="flex items-center justify-center border-b h-full w-28">
                {{ Number(배송비계산).toLocaleString('ko-KR') }}원
            </div>
        </div>

        <!-- 주문금액 합계표시 레이아웃 -->
        <div class="flex pr-7 items-center justify-end text-lg space-x-4 bg-zinc-100 border-y border-gray-300 h-14">
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
        </div>

        <div class="flex items-center mt-3 space-x-3">
            <button @click="선택된장바구니개체삭제()" class="p-2 border-2 bg-slate-50 hover:bg-red-500 hover:text-white rounded">선택삭제</button>
            <span class="text-gray-500">
                (총 {{ store.cartCount }}개중 {{ store.cartState.filter(item => item.isChecked).length }}개 선택)
            </span>
        </div>

        <div class="flex justify-center space-x-3 mt-12">
            <router-link :to="{name: 'contentholder'}" class="w-56 p-4 border-2 text-2xl text-center border-red-500 text-red-500 font-semibold hover:bg-red-500 hover:text-white rounded">
                계속 쇼핑하기
            </router-link>
            <button @click="toPaymentPage()" class="w-56 p-4 border-2 text-2xl bg-red-500 !text-white font-semibold hover:bg-red-600 rounded">
                구매하기
            </button>
        </div>
        
        <br>
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


export default {
    name: 'Cart',

    setup() {
        const {proxy} = getCurrentInstance();
        const store = useStore();
        const userInfo = useLoginStore();
        const router = useRouter();
        const 배송비 = ref(3000);
        const state = reactive({
            count: 0,
        })

        const 배송비계산 = computed({
            get: () => {
                if (store.cartState.filter(item => item.isChecked).length > 0) {
                    return 배송비.value = 3000;
                } else {
                    return 배송비.value = 0;
                }
            },
        });

        //todo: productDetail or home에서 상품을 담기 또는 장바구니 담기 하면 db에 저장되어 여기서 불러오기 가능해야함.
        store.cartStateMutation(); //장바구니 갱신용도

        //전체선택 체크유무에 따른 동작처리
        const allCheck = ($event) => {
            store.cartState.forEach((item,i,origin) => {//전역상태배열안의 체크값들을 순회해서 체크에 따라 상품금액값을 바꿈
                if (origin[i].isChecked || origin[i].product_stock == 0 ) { //예외 조건으로 재고가 0일 경우에는 그냥 체크를 해제한다.
                    origin[i].isChecked = false;
                    origin[i].computed_price = 0;
                } else {
                    origin[i].isChecked = true;
                    origin[i].computed_price = origin[i].product_price * origin[i].product_count;
                }
            })
        }

        const imgLoad = (item) => {
            if (item.product_image != null) {
                return 'http://192.168.112.128/uploads/'+item['product_image'][0];
            } else {
                return 'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif'
            }
        }

        
        const 장바구니추가 = (item) => {
            // proxy.$log('test')
            http.get('/productc/addProductInCartAtCartPage', {
                params:{
                    product_no: item.product_no,
                    product_count: item.product_count,   //추가할 개수
                    cart_owner: userInfo.info.id
                }
            }).then((res) => {
                if (res.data.result == 'false') {
                    proxy.$log('[Contentholder]장바구니추가 res false: ', res.data.msg);
                } else {
                    item.computed_price = item.product_price * item.product_count;  //추가에 따른 상품금액 업데이트 해주기.
                }
                
            }).catch((error) => {
                proxy.$log('[Contentholder]장바구니추가 error: ', error.response.data);
            })
        }

        const 장바구니에서삭제 = (item) => {
            http.delete('/productc/deleteCart', {
                params: {
                    cart_no: item.cart_no
                }
            }).then((res) => {
                proxy.$log('장바구니에서삭제() 결과: ', res.data)
                // window.location.reload();
                store.rstate++;
                router.push({name: 'cart'});
            }).catch((error) => {
                proxy.$log('장바구니에서삭제() 오류: ', error.response.data)
            })
        }

        //체크박스 클릭시
        const checkBoxClicked = (item) => {
            if (item.isChecked) {
                item.isChecked = false;
                item.computed_price = 0;
            } else {
                item.isChecked = true;
                item.computed_price = item.product_price * item.product_count;
            }
        }

        const 선택된장바구니개체삭제 = () => {
            http.delete('/productc/deleteCheckedCart', {
                params: {
                    cart_numbers: store.cartState.filter((item) => {    //조건이 true인 요소들만 새로 구성된 배열을 리턴
                        return item.isChecked;
                    }).map((item) => {                              //각 요소를 순회하면서 리턴된 값들로 구성된 새로운 배열을 반환
                        return item.cart_no;
                    })
                }
            }).then((res) => {
                proxy.$log('선택된장바구니개체삭제() 결과: ', res.data)
                // window.location.reload();
                store.rstate++;
                router.push({name: 'cart'});
            }).catch((e) => {
                proxy.$log('선택된장바구니개체삭제() 오류: ', e.response.data)
            })
        }

        //구매하기 클릭시
        const toPaymentPage = () => {
            //결제페이지로 넘어간다. 그 후 store의 cartState배열에 각 요소의 isChecked 값이 true인 상품들만 추려서 결제정보에 이용한다.
            //그리고, 결제가 '완료'되면 위에서 추린 상품들을 cartState배열에서 삭제하고 결제를 마무리한다.
            router.push({name:'payment', });
        }
    
        return {
            // ...toRefs(state),
            store, 배송비계산,
            allCheck, imgLoad, 장바구니추가, 장바구니에서삭제, checkBoxClicked, 선택된장바구니개체삭제, toPaymentPage
        }
    }
}
</script>

<style lang="scss" scoped>

</style>