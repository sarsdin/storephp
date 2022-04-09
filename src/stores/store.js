import { defineStore } from "pinia";
import {reactive, ref} from "vue";

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
            rstate : 0  //Header - 공지사항에서 ++됨
        }
    },
    // getters:{
    //     plus(){
    //         this.rstate++;       
    //자동으로 state의 변화를 인지하여 계산 후 리턴함.  ++는 계산후 원본에 대입하는것이니 rstate가 +1될 때 이것까지 +1되서 결과적으로 +2가 증가됨.
    // getter는 한개의 함수를 리턴주는게 가능하다. 공식문서참고
    //         // return state.rstate;
    //     }
    // },
    actions: {
        
    },
    persist: {
        storage: window.sessionStorage,
        enabled: true
    }
})