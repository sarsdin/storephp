import { defineStore } from "pinia";
import {reactive, ref} from "vue";
import http from '@/modules/http'

// export const useLoginStore = defineStore('loginStore', ()=>{

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

export const useLoginStore = defineStore('loginStore', {
    state: () => {
        return {
            lstate : 'not',      //로그인상태: 기본not , 로그인 logined
            info : {              //로그인하면 이 값이 setInfo()를 사용하여 업데이트됨
                id: '',
                session_id: '',
                user: {}
            },
        }
    },
    actions: {
        setLstate(val) {
            this.lstate = val;
        },
        setInfo(params) {
            this.info.id = params;
        },
    
    },
    persist: {
        storage: window.sessionStorage,
        enabled: true
    }
})