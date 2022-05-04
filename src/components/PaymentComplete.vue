<template>
    <!-- component -->
<div class="w-full mt-10 mb-40 mx-auto">
  <div class="w-full shadow-2xl subpixel-antialiased rounded h-[500px] bg-black border-black mx-auto">
    
    <div class="flex items-center h-6 rounded-t bg-gray-100 border-b border-gray-500 text-center text-black" id="headerTerminal">
      <div class="flex ml-2 items-center text-center border-red-900 bg-red-500 shadow-inner rounded-full w-3 h-3" id="closebtn">
      </div>
      <div class="ml-2 border-yellow-900 bg-yellow-500 shadow-inner rounded-full w-3 h-3" id="minbtn">
      </div>
      <div class="ml-2 border-green-900 bg-green-500 shadow-inner rounded-full w-3 h-3" id="maxbtn">
      </div>
      <div class="mx-auto pr-16" id="terminaltitle">
        <p class="text-center text-sm">Terminal</p>
      </div>
    </div>

    <div class="pl-1 pt-1 h-auto  text-green-200 font-mono text-2xl bg-black" id="console">
      <p class="pb-1">Last payment: {{ Date() }}</p>
      <p class="pb-1">root: <span id="test"></span></p>
      <div v-if="isOrderCheck" class="pb-1">root: 주문조회로 가시겠습니까? (Y/n) 
        <div class="flex justify-center mt-20 space-x-3">
            <button @click="$router.push({name:'orderCheck'})" class="text-5xl">&lt;&nbsp;&nbsp;Y&nbsp;&nbsp;></button>
            <button @click="$router.push('/')" class="text-sm">&lt;&nbsp;&nbsp;n&nbsp;&nbsp;></button>
        </div>
      </div>
    </div>
  
  </div> 
</div>

</template>

<script>
import { onMounted, reactive, toRefs } from 'vue'
import { useStore } from '@/stores/store';
import { useRoute } from 'vue-router';

export default {
    name: 'PaymentComplete',
    setup() {
        const store = useStore();
        const route = useRoute();
        const state = reactive({
            test: '결제가 완료되었습니다.',
            isOrderCheck: false,
        })
        const resInfo = route.params;           //결제(부트페이)에서 받아온 결제완료 정보
        console.log('[PaymentComplete] resInfo: ', resInfo);

        const test = () => {
            setTimeout(() => {
                state.isOrderCheck = true;
            }, 2500)
        }
        test();

        const testC = () => {
            let ta = [];
            let test = document.getElementById('test');
            for (let i = 0; i < state.test.length; i++) {
                // ta.push(state.test.charAt(i));
                let tmp = document.createElement('span');
                setTimeout(() => {
                    tmp.append(state.test.charAt(i));
                    test.append(tmp);
                    // state.test.charAt(i);
                }, i*120)
                setTimeout(() => {
                    setTimeout(() => {
                        tmp.style.textDecorationLine = 'underline';
                    }, i*10);
                }, 1800)
            }
        }

        onMounted(() => {
            testC();
        })
    
        return {
            ...toRefs(state),
        }

        // function sliceByByte(str, maxByte) {
        //     for(b=i=0; c=str.charCodeAt(i);) {
        //         b += c >> 7? 2:1;
        //         if (b > maxByte){
        //             break;
        //         }
        //         i++;
        //     }
        //     return str.substring(0,i);
        // }
    }
}
</script>

<style lang="sass" scoped>

p
    margin: 0


</style>

