import { defineStore } from "pinia";
import http from '@/modules/http';
import { useLoginStore } from "@/stores/login";
import { useStore } from "@/stores/store";

export const useMyStore = defineStore('myStore', {
    
    state: () => {
        return {
            orderCheck:{
                orderCheckRangeCSS: 1,
                orderStateRangeCSS: '',
                orderInfo: {}           //주문상세조회 클릭시 해당 주문(아이템)의 정보가 저장되는 변수
            },

            //주문조회리스트를 서버로부터 받아와 이곳에 담음.
            orderCheckList : [],
        }
    },
    getters: {

    },
    actions:{
        주문조회리스트로드(){
            const userInfo = useLoginStore();
            http.post('/paymentc/getOrderCheckList', {
                user_id: userInfo.info.id,
                date_range: this.orderCheck.orderCheckRangeCSS   //주문조회페이지에서 기간버튼의 활성이 어느것이냐에 따라 불러오는 데이터의 범위가 달라짐

            }).then((res) => {
                console.log('[my.js]주문조회리스트로드 res : ', res.data);
                this.orderCheckList = res.data.result;

            }).catch(error => console.log('[my.js]주문조회리스트로드 error :>> ', error.response.data))
        },

        주문관리리스트로드(orderState){
            const userInfo = useLoginStore();
            const store = useStore();
            http.post('/paymentc/getOrderCheckAdminList', {
                user_id: userInfo.info.id,
                date_range: this.orderCheck.orderCheckRangeCSS,  //주문조회페이지에서 기간버튼의 활성이 어느것이냐에 따라 불러오는 데이터의 범위가 달라짐
                order_state: this.orderCheck.orderStateRangeCSS, //주문상태에 따라 불러오는 데이터가 달라짐

            }).then((res) => {
                console.log('[my.js]주문관리리스트로드 res : ', res.data);
                
                this.orderCheckList = res.data.result;
                this.orderCheckList.forEach((item,i,origin) => {
                    origin[i].isCustomerReqModalOpen = false;    //요청사항 개별아이템의 리뷰작성하기 버튼클릭시 각해당하는 모달의 오픈여부를 위해 넣어줌.
                })

            }).catch(error => console.log('[my.js]주문관리리스트로드 error :>> ', error.response.data))
        }
    },
    persist:{
        storage: window.sessionStorage,
        enabled: true
    }

})