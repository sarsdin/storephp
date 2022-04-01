import {reactive, ref} from "vue";

const lstate = ref('not');      //로그인상태: 기본not , 로그인 logined
const info = ref({              //로그인하면 이 값이 setInfo()를 사용하여 업데이트됨
    id: ''
});
const setLstate = (val)=>{
    lstate.value = val;
}
const setInfo = (params) => {
    info.value.id = params;
}
export default {
    lstate, info, setLstate, setInfo
}
