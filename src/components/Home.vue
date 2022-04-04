<template>
<!-- min-h-screen -->
    <div id="mainc" class="w-260 flex flex-col my-0 mx-auto">
        <!-- 헤더 -->
        <Header></Header>
        <!-- <router-view name="header"></router-view> -->

        <!-- 컨텐츠 -->
        <div class="flex-1 flex flex-col sm:flex-row">
            <main class="w-full flex flex-wrap bg-white">
                <router-view name="home" :key="[$route.fullPath, storeInfo.rstate]" v-bind:it="items"></router-view>
                <!-- <Notice v-if="topIcon == 'notice'"></Notice> -->
                <!-- <Contentholder v-else-if="topIcon == 'content'" v-for="item in items" v-bind:key="item.name" v-bind:item="item"/> -->
            </main>

            <nav class="order-first sm:w-68 text-white">Left Sidebar</nav>

            <aside class="sm:w-68 text-white">Right Sidebar</aside>
        </div>

        <!-- 푸터 -->
        <Footers></Footers>
        
    </div>
</template>

<script>
import Header from './Header.vue'
import Footers from './Footer.vue'
import Contentholder from './Contentholder.vue'
import {ref} from 'vue'
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
        const topIcon = ref('content');
        const items = ref([{
            name: "소파 내용 테스트 하는 중",
            price: 10000,
            expire: 100
            },
            {
            name: "소파2 내용 테스트 하는 중",
            price: 20000,
            expire: 100
            },
            {
            name: "소파3 내용 테스트 하는 중",
            price: 30000,
            expire: 100
            },
            {
            name: "소파4 내용 테스트 하는 중",
            price: 40000,
            expire: 100
            }
        ])
        

        const notice = () =>{
            alert("notice() clicked");
            topIcon.value = "notice";
        }

        return {
            items, topIcon, notice, userInfo, storeInfo
        }
    }

}
</script>

<style scoped>

</style>
