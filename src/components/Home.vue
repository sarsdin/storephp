<template>
<!-- min-h-screen -->
    <div id="mainc" class="w-260 flex flex-col my-0 mx-auto">
        <!-- 헤더 -->
        <Header></Header>

        <!-- 컨텐츠 -->
        <div class="flex-1 flex flex-col sm:flex-row">
            <main class="w-full flex flex-wrap bg-white">
                <router-view name="home" :key="[$route.fullPath, storeInfo.rstate]" ></router-view>
            </main>

            <nav class="order-first sm:w-68 text-white">Left Sidebar</nav>

            <aside class="sm:w-68 text-white">
                <!-- <div class="flex justify-center relative w-full h-full">
                    <div class="flex sticky top-20 w-20 h-96 bg-slate-100">
                        
                    </div>
                </div> -->
            </aside>
        </div>

        <!-- 푸터 -->
        <Footers></Footers>

        <div @click="toTopScroll()" id="toTopBT" class="fixed right-20 bottom-5" style="display: none;">
            <button class="px-1 w-fit h-10 border border-airbus-16 text-airbus-16 rounded">▲위로</button>
        </div>
    </div>
</template>

<script>
import Header from './Header.vue'
import Footers from './Footer.vue'
import Contentholder from './Contentholder.vue'
import {onMounted, onBeforeUnmount, reactive, ref, toRefs} from 'vue'
import Notice from './Notice.vue'
import NoticeContent from './NoticeContent.vue'
import { useLoginStore } from "@/stores/login";
import { useStore } from "@/stores/store";


export default {
    name: 'Home',
    components:{
        Header,
        Footers,
        Contentholder,
        Notice,
        NoticeContent
},

    setup() {
        const userInfo = useLoginStore();
        const storeInfo = useStore();
        const state = reactive({
            scrollTop: 0,
            target: null
        })



        //일정이상 스크롤이 내려가면 위로버튼이 나와서 스크롤을 위로 올려주는 메소드
        var timer;
        function handleScrollToTop(e) {
            if (!timer) {
                timer = setTimeout(() => {  //쓰로틀링 기법
                    timer = null; //200ms후에 timer변수를 풀어줘서 if문이 true로 통과되어 안의 코드가 실행될 수 있게 해준다. 성능상 이점 위함.
                                //debouncing도 있음. 이건 clearTimeout(timer)을 걸고 이후 timer = setTimeout{},200을 걸어서 
                                //setTimeout의 지연시간안에 또다시 검색등을 입력하면
                                //기존에 지연중인 setTimeout을 clearTimeout으로 취소시켜 연속 검색을 통한 부하 방지의 목적으로 이용됨.

                    state.scrollTop = document.documentElement.scrollTop;
                    // console.log('e.target.scrollTop :>> ', document.documentElement.scrollTop);  //현재 스크롤탑 위치의 값을 보여줌. 스크롤이동시마다 바뀜
                    // console.log('e.target.scrollTop2 :>> ', state.scrollTop);
                    // console.log('e.target.scrollTop22 :>> ', ev.target.scrollTop);
                        if (state.scrollTop > 400) {
                            // state.isScrollDown = true;
                            document.getElementById('toTopBT').style.display = 'block';

                        } else {
                            document.getElementById('toTopBT').style.display = 'none';
                            // state.isScrollDown = false;
                        }

                }, 200)
            }
        }

        onMounted(() => {
            // console.log('e.target.scrollTop :>> ');
            // state.target = document.getElementById('toTopBT');
            // state.target = document.querySelector('');
            state.target = document;
            // document.addEventListener('scroll', (doc, e) => {
                state.target.addEventListener('scroll', handleScrollToTop);
        })
        onBeforeUnmount(() => {
            state.target.removeEventListener('scroll', handleScrollToTop);
        })

        const toTopScroll = () => {
            window.scrollTo({top:0, behavior:'smooth'});
        }

        return {
            userInfo, storeInfo, ...toRefs(state), 
            toTopScroll
        }
    }
    

}

</script>

<style scoped>

</style>
