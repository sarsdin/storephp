<template>
<!--- more free and premium Tailwind CSS components at https://tailwinduikit.com/ --->
<div v-if="propsModalC == true" class="min-h-[1300px] max-h-fit py-12 bg-gray-700 bg-opacity-30 transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0" id="modal">
    <div role="alert" class="container mx-auto w-full md:w-5/6 max-w-6xl">
        <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
            <!-- 헤더 -->
            <slot/>

            <!-- 제출,취소버튼 -->
            <div class="relative px-5 mx-auto max-w-screen-xl">
                <!-- <button class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-8 py-2 text-sm">
                    제출
                </button> -->
                <button class="focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-gray-400 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm" 
                    @click="cancelClicked()">취소</button>
            </div>
            <!-- X버튼 -->
            <button class="absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" 
                @click="cancelClicked()" aria-label="close modal" role="button">
                <svg  xmlns="http://www.w3.org/2000/svg"  class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>

        </div>
    </div>
</div>


<!-- 리뷰쓰기 모달전용 -->
<slot name="reviewModal">
    <div class="min-h-[1300px] max-h-fit py-12 bg-gray-700 bg-opacity-30 transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0" id="modal">
        <div role="alert" class="container mx-auto w-full md:w-5/6 max-w-4xl">
            <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
                <!-- 헤더 -->
                
                <h5 class="mb-5">
                    {{ ($props.item == undefined)? '':$props.item.product_name }} 리뷰쓰기

                </h5>
                <!-- <button @click="$emit('modalOff', false)">모달닫기테스트버튼</button> -->
                <Qeditor class="w-full h-96 mb-5 bg-slate-50 overflow-auto" v-model="editor"></Qeditor>

                <div class="mb-2 text-gray-700 font-mono">
                    평점남기기
                </div>
                <div class="flex flex-wrap mb-5">
                    <div class="flex items-center mr-4">
                        <input @click="평점남기기버튼클릭($event)" id="red-radio" type="radio" value="1" name="colored-radio" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="red-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">1점</label>
                    </div>
                        <div class="flex items-center mr-4">
                        <input @click="평점남기기버튼클릭($event)"  id="green-radio" type="radio" value="2" name="colored-radio" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="green-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">2점</label>
                    </div>
                        <div class="flex items-center mr-4">
                        <input @click="평점남기기버튼클릭($event)"  id="purple-radio" type="radio" value="3" name="colored-radio" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="purple-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">3점</label>
                    </div>
                        <div class="flex items-center mr-4">
                        <input @click="평점남기기버튼클릭($event)"  id="teal-radio" type="radio" value="4" name="colored-radio" class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="teal-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">4점</label>
                    </div>
                        <div class="flex items-center mr-4">
                        <input @click="평점남기기버튼클릭($event)"  checked="true" id="yellow-radio" type="radio" value="5" name="colored-radio" class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="yellow-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">5점</label>
                    </div>
                </div>

    
                <!-- 제출,취소버튼 -->
                <div class="relative px-5 mx-auto max-w-screen-xl">
                    <button @click="리뷰제출클릭($props.item)" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-8 py-2 text-sm">
                        제출
                    </button>
                    <button class="focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-gray-400 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm" 
                        @click="$emit('modalOff', false)">취소</button>
                </div>
                <!-- X버튼 -->
                <button class="absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" 
                    @click="$emit('modalOff', false)" aria-label="close modal" role="button">
                    <svg  xmlns="http://www.w3.org/2000/svg"  class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
    
            </div>
        </div>
    </div>
</slot>

<!-- <div class="w-full flex justify-center py-12" id="button">
    <button class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 mx-auto transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm" 
        @click="modalHandler(true)">Open Modal</button>
</div> -->
      
</template>

<script>
import { onMounted, reactive, ref, computed, readonly, toRefs } from 'vue'
import http from '@/modules/http'
import Qeditor from './Qeditor.vue';
import { useLoginStore } from '@/stores/login';
// import ReviewModalContent from './ReviewModalContent.vue';

export default {
    name: "ReviewModal",
    components: { Qeditor },
    props: ["modelValue", "item"],
    emits: ["update:modelValue", "modalOff"],
    setup(props, context) {
        const userInfo = useLoginStore();
        // const modal = (props["modelValue"]); //ref, reactive는 컴포넌트 내에서의 값에만 반응하는듯 외부로부터 받은값 props에는 반응성이 초기에만 한번 대입되고 그후로는 없어지는듯??
        const propsModalC = computed(() => {
            return props["modelValue"]; //위쪽 컴포넌트에서 model props로 true를 받으면 모달 보여주기.
        });
        const cancelClicked = () => {
            // modal.value = false;
            context.emit("update:modelValue", false);
        };



        //////////////////////////////////////////////////////////////
        //리뷰 쓰기 모달관련 시작 부분
        //////////////////////////////////////////////////////////////
        // const editor = ref('');  
        const state = reactive({
            editor: '',         //Qeditor컴포넌트 내용
            review_grade: 5

        })

        const 리뷰제출클릭 = (item) => {
            http.post('/paymentc/reviewCreate', {
                order_detail_no: item.order_detail_no,
                product_no: item.product_no,
                writer: userInfo.info.id,
                content: state.editor,
                write_date: '',
                review_grade: state.review_grade

            }).then((res) => {
                console.log('[ReviewModal] 리뷰제출클릭 res: ', res.data);
                context.emit('modalOff', false); //상위컴포넌트에 모달off하라는 이벤트전달

            }).catch(error => console.log('[ReviewModal] 리뷰제출클릭 error: ', error.response.data))
        }

        const 평점남기기버튼클릭 = (e) => {
            state.review_grade = e.target.value;
        }



        return {
            // modal,
            cancelClicked,
            propsModalC,

            //리뷰 쓰기 모달 시작 부분 변수
            ...toRefs(state),
            리뷰제출클릭, 평점남기기버튼클릭
        };
    },
    
}
</script>

<style scoped>

</style>