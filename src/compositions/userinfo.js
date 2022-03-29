import {reactive, ref} from "vue";

const lstate = ref('not');
const info = ref({
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
