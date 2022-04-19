import { defineStore } from "pinia";
import {reactive, ref} from "vue";
import http from '@/modules/http';
import { useLoginStore } from './login';

// export const useStore = defineStore('store', ()=>{

//     const lstate = ref('not');      //로그인상태: 기본not , 로그인 logined
//     const info = ref({              //로그인하면 이 값이 setInfo()를 사용하여 업데이트됨
//         id: ''
//     });
//     const setLstate = (val)=>{
//         lstate.value = val;
//     }
//     const setInfo = (params) => {
//         info.value.id = params;
//     }

//     return {
//         lstate, info,
//         setLstate, setInfo
//     }
// },
// {
//     persist: {
//         storage: window.sessionStorage,
//         enabled: true
//     }
// })

export const useStore = defineStore('store', {
    state: () => {
        return {
            rstate : 0,  //Header - 공지사항에서 ++됨
            cartCount: 0, //장바구니 개수
            cartState: [],   //현재 카트의 전반적인 상태정보 배열
            receiverInfo: {}
        }
    },
    getters:{
    //     plus(){  //함수가 아닌 변수 취급이다..
    //         this.rstate++;       
    // 자동으로 state의 변화를 인지하여 계산 후 리턴함.  ++는 계산후 원본에 대입하는것이니 rstate가 +1될 때 이것까지 +1되서 결과적으로 +2가 증가됨.
    // getter는 한개의 함수를 리턴주는게 가능하다. 공식문서참고
    //         // return state.rstate;
    //     }
        
        // ** getter ** 사용 주의 사항 : ()=> {} 에로우 펑션 사용시 'this'의 사용이 되지 않음에 주의!!

        computedWholePrice(){  //계산된 상품금액을 합한 총 주문금액 반환
            let res = 0;
            this.cartState.forEach((item,i,origin) => {
                res = item.computed_price + res;
            })
            return res;
        },

        배송비계산() { 
            if (this.cartState.filter(item => item.isChecked).length > 0) {
                return 3000;
            } else {
                return 0;
            }
        }
        
    },
    actions: {
        cartStateMutation(){                //장바구니를 갱신하는 용도
            // console.log('object :>> ');
            const useInfo = useLoginStore();
            http.get('/productc/getCart', {         //카트 목록 가져옴 - 로그인 아이디 이용
                params:{
                    cart_owner: useInfo.info.id
                }
            }).then((res) => {                      //결과리스트를 가져와서 1개 이상이면 cartCount에 업데이트함. 아니면 0으로 초기화
                console.log('cartStateMutation res :>> ', res.data);

                if (res.data.length > 0) {
                    this.cartCount = res.data.length;
                    this.cartState = res.data;           //받아온 장바구니 정보를 업데이트하고, 각 요소에 isChecked,computed_price를 추가함
                    this.cartState.forEach((item,i,origin) => {
                        origin[i].isChecked = true; //체크박스 체크유무. 초기값은 체크한 것으로 true
                        origin[i].computed_price = origin[i].product_price * origin[i].product_count;
                    })
                } else{
                    this.cartCount = 0;
                    this.cartState = [];
                }
            }).catch((error) => {
                console.log('cartStateMutation error: ', error.response.data);
            })
        },

        

        // 장바구니상품금액계산(item){
        //     item.computed_price = item.product_price * item.product_count;
        // }
       
        
    },
    persist: {
        storage: window.sessionStorage,
        enabled: true
    }
})