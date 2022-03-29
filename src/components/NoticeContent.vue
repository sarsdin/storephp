<template>

    <div class="flex flex-col w-full px-0">  <!-- 정렬'방향'이 colume처럼(세로정렬) -->
        <div class="overflow-x-auto shadow-md sm:rounded-md mt-0">
            <!-- 본문 -->
            <div class="inline-block min-w-full align-middle bg-slate-50 dark:bg-gray-800">
                <div class="overflow-hidden text-lg px-3 mt-3">
                    <!-- 제목 : {{ noticeT[0] ? noticeT[0].title:'' }} -->
                    <!-- 제목 : {{$route.params.title}} -->
                    [공지사항] {{ noticeT[0]['notice_title'] }}
                </div>
                <div class="flex space-x-7 text-xs p-3 border-b-2 text-slate-500">
                    <div>
                        <font-awesome-icon :icon="['far', 'user']" class="text-slate-500" /> {{ noticeT[0]['notice_writer'] }}
                    </div>
                    <div>
                        <font-awesome-icon :icon="['far', 'clock']" class="text-slate-500" /> {{ noticeT[0]['notice_date'] }}
                    </div>
                    <div>
                        <font-awesome-icon :icon="['far', 'eye']" class="text-slate-500" /> {{ noticeT[0]['notice_hit'] }}
                    </div>
                </div>

            </div>

            <!-- 내용 -->
            <div class="bg-white p-5 min-h-[300px]">
                {{ noticeT[0]['notice_content'] }} <br><br>
                <!-- {{ $route.params.content }} <br><br>
                 {{ $route.params.writer }} -->
            </div>
        </div>


         <!-- 검색바 Row -->
        <div class="flex p-4">
            <!-- <select v-model="noticeSearchType" name="option" id="searchbox"  class="block mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="제목">제목</option>
                <option value="내용">내용</option>
            </select>
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative mt-1">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input v-model="noticeSearch" @keyup.enter="searchWord" type="text" id="table-search"
                        class="block w-60 pl-10 p-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="검색어 입력">
            </div> -->
        </div>

    </div>


</template>

<script>
import http from '../modules/http';
import { useRouter, useRoute} from 'vue-router';
import { watch, reactive, ref, readonly, onMounted } from 'vue';

export default {
    name: 'noticeContent',

    setup () {
        const route = useRoute();
        // const router = useRouter();
        const noticeT = ref([{}]);      
        //미리 들어올 데이터 타입에 맞는 구조가 있어야 undefined 가 안뜬다. 만약, 들어올 데이터가 [{}] 이렇게 배열안에 객체나 배열이라면?
        //ref 안에 초기화할때도 저렇게 데이터객체를 만들어놔야 데이터가 적합한 곳에 들어간다. 들어갈 공간구조가 할당되어 있지 않으면 당연히 undefined..

        console.log("router::: " , route.query.notice_no);
        http.get('/home/noticeContent', {
            params: {
                // no: route.params.no, //params로 받을때는 params로 query로 받을땐 query로 받음. 둘의 구별 필요.
                notice_no: route.query.notice_no,     //query방식의 장점 : params는 새로고침시 데이터가 날라간다는 말이 있지만, query는 url에 데이터가 있어서 안날라간단다..
                // content : route.query.content
            }
        }).then(res => {
            console.log('NoticeContent res.data: ', res.data);
            noticeT.value = res.data;
            console.log('NoticeContent noticeT.value: ', noticeT.value);
        }).catch((err) => {
            console.error('NoticeContent err: ', err);
        })

        //라우트 인스턴스를 감시하여 uri의 parameter의 변화에 컴포넌트가 동적으로 반응하게 만듦
        // watch(() => route.params , (newValue, oldValue) => {
        //     console.log("watch->router::: " , route.params.no);
        //      http.get('/home/noticeContent', {
        //         params: {
        //             no: newValue.no,
        //             content : newValue.content
        //         }
        //     }).then(res => {
        //         console.log('NoticeContent: watch->route: ', res.data);
        //         noticeT.value = res.data;
        //         console.log('NoticeContent watch->noticeT.value: ', noticeT.value);
        //     }).catch((err) => {
        //         console.error('NoticeContent: watch->route: err: ', err);
        //     })
        //     }, { immediate: true, deep: true
        // })

        return {
            noticeT
        }
    }
}
</script>

