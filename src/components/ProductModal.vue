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
<!-- <div class="w-full flex justify-center py-12" id="button">
    <button class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 mx-auto transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm" 
        @click="modalHandler(true)">Open Modal</button>
</div> -->
      
</template>

<script>
import { onMounted, reactive, ref, computed, readonly } from 'vue'
import ProductModalContent from './ProductModalContent.vue';

export default {
    name: "ProductModal",
    props: ["modelValue"],
    emits: ["update:modelValue"],
    setup(props, context) {
        // const modal = (props["modelValue"]); //ref, reactive는 컴포넌트 내에서의 값에만 반응하는듯 외부로부터 받은값 props에는 반응성이 초기에만 한번 대입되고 그후로는 없어지는듯??
        const propsModalC = computed(() => { //computed의 getter를 이용해서 readonly 값을 리턴한다. writable하게 할려면 set()을 선언해줘야함.
            return props["modelValue"];     //위쪽 컴포넌트에서 model props로 true를 받으면 모달 보여주기.
        });
        const cancelClicked = () => {
            // modal.value = false;
            context.emit("update:modelValue", false);
        };
       
        return {
            // modal,
            cancelClicked,
            propsModalC
        };
    },
    components: { ProductModalContent }
}
</script>

<style scoped>

</style>