<template>
    <div class="flex flex-col w-full px-0 mb-5">
        <div class="overflow-x-auto shadow-md sm:rounded-md mt-10">
            <!-- <NoticeContent v-if="showed" :rowInfo="rowInfo"></NoticeContent> -->
            <!-- :key="$route.fullPath"속성을 이용하여 새로고침한다. vue-router는 동일한 구성에 관해 변경사항인지가 안된단다? -->
            <router-view name="noticeContent" v-if="$route.query != undefined" v-on:rowDeleted="rowDeleted(deletedRowNum)"></router-view>
            <!-- 본문 -->
            <div class="flex justify-end relative my-3">
                <!-- <div class="px-2">
                    <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="categorybox">
                        <option value="공지">공지</option>
                        <option value="질문">질문</option>
                    </select>
                </div> -->
                <div class="px-4">
                    <select :value="noticeStore.paging.itemsPerPage" @change="pageRowSelected(noticeStore.pagingC.currentPage, $event)"                                                                
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="categorybox">
                        <option value="5">5줄보기</option>
                        <option value="10">10줄보기</option>
                        <option value="20">20줄보기</option>
                        <option value="30">30줄보기</option>
                        <option value="50">50줄보기</option>
                    </select>
                </div>
            </div>

            <div class="inline-block min-w-full align-middle dark:bg-gray-800">
                <div class="overflow-hidden">
                    <table class="min-w-full w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th v-show="false" scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-search-all" type="checkbox"
                                           class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-search-all" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="py-3 px-3 w-16 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                                번호
                            </th>
                            <th scope="col"
                                class="py-3 px-6 w-3/6 text-ellipsis overflow-hidden whitespace-nowrap text-center text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400">
                                제목
                            </th>
                            <th scope="col"
                                class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                                작성자
                            </th>
                            <th scope="col"
                                class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                                날짜
                            </th>
                            <th scope="col"
                                class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                                조회수
                            </th>
                            <th v-show="false" scope="col" class="p-4">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        <!-- <router-link :to="{ name : 'noticeContent', params: { no: item.no } }"  class="w-full" > 이건 힘들지..css수정도 힘들고 -->
                            <tr v-for="item in noticeT" :key="item.notice_no" @click="rowClicked(item)" :class="{'rowClickedCSS': item.notice_no == noticeStore.rowClickedCSSVar}" 
                            class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                <td v-show="false" class="p-4 w-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-search-1" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="col" class="py-3 px-3 w-16 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                                    {{item.notice_no}}
                                </th>
                                <td class="py-4 px-6 w-96 text-sm font-medium text-gray-900 whitespace-nowrap text-ellipsis overflow-hidden dark:text-white">
                                    {{item.notice_title}}&nbsp;
                                    <span class="text-xs text-blue-400">{{ item.notice_reply_count? item.notice_reply_count:'' }}</span>
                                    
                                </td>
                                <td class="py-4 px-6 text-sm text-center font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                    {{item.notice_writer}}
                                </td>
                                <td class="py-4 px-6 text-sm text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{item.notice_date}}
                                </td>
                                <td class="py-4 px-6 text-sm text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{item.notice_hit}}
                                </td>
                                
                                <td v-show="false" class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                </td>
                            </tr>
                        <!-- </router-link> -->
                        </tbody>
                    </table>
                </div>

            </div>
            
        </div>

         <!-- 검색바 Row -->
        <div class="flex relative p-4">
            <select v-model="noticeStore.paging.noticeSearchType" name="option" id="searchbox"  class="block mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                <input @change="noticeStore.paging.noticeSearch = $event.target.value" :value="noticeStore.paging.noticeSearch" @keyup.enter="searchWord" type="text" id="table-search"
                        class="block w-40 pl-10 p-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="검색어 입력">
            </div>

            <!-- 페이징 부분 -->
            <div class="flex justify-center w-96 ml-20">
                <button v-if="noticeStore.pagingC.lastPage > 10 " @click="gotoClickedPage(1, $event)" class="mr-1" >
                    <font-awesome-icon class="text-gray-700" :icon="['fas', 'angles-left']"></font-awesome-icon>
                </button> 

                <button v-if="noticeStore.pagingC.prevPage != 0 " @click="gotoClickedPage(noticeStore.pagingC.prevPage, $event)" >
                    <font-awesome-icon class="text-gray-700" :icon="['fas', 'square-caret-left']"></font-awesome-icon>
                </button> 
               
                <!-- @click시 store.rstate++을 이용해서 router-view를 갱신(리로드) 해주면 css를 바인딩으로 해결해야한다. 
                이벤트target으로 css를 수정하면 수정하자마자 재랜더링때문에 적용이 풀린다. -->                                              
                <button v-for="pageNumber in noticeStore.pagingC.linkArray" :key="pageNumber" :class="{'currentPagingCSS': noticeStore.classVar == pageNumber }"
                 @click="gotoClickedPage(pageNumber, $event)" 
                 class="text-gray-700 w-7 hover:text-blue-500 hover:font-semibold hover:text-lg">
                    {{ pageNumber }}
                </button> 
                
                <button v-if="noticeStore.pagingC.lastPage < noticeStore.pagingC.totalPageCount" @click="gotoClickedPage(noticeStore.pagingC.nextPage, $event)" >
                    <font-awesome-icon class="text-gray-700" :icon="['fas', 'square-caret-right']"></font-awesome-icon>
                </button>

            </div>


            <!-- 글작성 클릭버튼 -->
            <div v-if="userInfo.lstate == 'logined' " class="absolute right-3">
                <button @click="createNotice" class="border p-1 rounded-md text-slate-500 font-semibold bg-slate-100 hover:bg-slate-300" type="button">글쓰기</button>
            </div>
        </div>



    </div>

</template>


<script>
import { inject, onMounted, reactive, ref, toRefs, computed, getCurrentInstance } from "vue";
import http from '../modules/http.js';
import { useRouter, useRoute } from 'vue-router';
import NoticeContent from './NoticeContent.vue'
import { useLoginStore } from "@/stores/login.js";
import { useStore } from "@/stores/store.js";
import { useNoticeStore } from '@/stores/notice.js'

export default {
    name: 'Notice',
    components: {
        NoticeContent
    },
    setup(){
        const store = useStore();
        const noticeStore = useNoticeStore();
        const {proxy} = getCurrentInstance();
        const noticeT = ref([]); //글목록배열
        // let noticeSearch = ref(''); //글 검색창
        // let noticeSearchType = ref('제목'); // 글검색종류
        const userInfo = useLoginStore()    //전역 로그인된 유저정보
        const router = useRouter();
        const route = useRoute();
        

        //공지글 상세페이지부분
        // const showed = ref(false);
        // const rowInfo = ref({});
        // const rowDeleted = () => {
        //     showed.value = false;
        // }
        

        const gotoClickedPage = (pageNumber, $event) => {
            // proxy.$log('gotoClickedPage pageNumber: ', pageNumber);
            noticeStore.paging.currentPage = pageNumber;
            // proxy.$log('gotoClickedPage paging.currentPage: ', noticeStore.paging.currentPage);
            // proxy.$log('gotoClickedPage paging.currentPage: ', $event.target.tagName);
            $event.target.style.color = 'crimson';   //테스트용임. rstate++로 인해 작동안하는 중. 
            // $event.target.classList.add('font-bold');
            // proxy.$log('gotoClickedPage paging.currentPage: ', $event.target.style.color);
            // proxy.$log('gotoClickedPage paging.currentPage: ', $event.target.classList);
            // proxy.$log('gotoClickedPage paging.currentPage: ', $event.target.innerHTML);
            // if ($event.target.tagName == 'BUTTON') {
            //     $event.target.style.color = 'crimson';
            //     $event.target.classList.add('font-bold');
            // }
            noticeStore.classVar = pageNumber;
            // $event.target.style.color = 'crimson';
            // $event.target.classList.add('font-bold');
            // $event.target.classList.remove('text-gray-700');
            // $event.target.innerHTML = 'ggg';
            // proxy.$log('gotoClickedPage paging.currentPage: ', $event.target.style.color);
            // proxy.$log('gotoClickedPage paging.currentPage: ', $event.target.classList);
            noticeLoad();

            //query string이 없다면 noticeContent컴포넌트는 실행하지 않음.
            store.rstate++;
            if (route.query.notice_no != undefined || route.query.notice_no != null) {
                let params = {
                    name: 'noticeContent', 
                    query:{
                        notice_no: route.query.notice_no
                    }
                }
                // if (route.query.notice_) {}
                router.push(params);
            }
        }

        //글목록 서버에서 불러오기
        // const http = inject('http');  //작동은 하는데 ide에서 툴팁이 작동을 안해서 디버깅이 어렵네..
        const noticeLoad = () => {
            http.get('/home/notice', {
                params:{
                    'dbEndNumber': noticeStore.pagingC.dbEndNumber,
                    'dbStartNumber': noticeStore.pagingC.dbStartNumber,
                    'searchValue': noticeStore.pagingC.noticeSearch,
                    'searchType': noticeStore.pagingC.noticeSearchType,
                }
            }).then(res => {
                noticeStore.paging.totalItems = res.data.totalItems;
                console.log('[Notice] res: ', res.data);
                noticeT.value = res.data.result;
                console.log('[Notice] noticeT.value: ', noticeT.value);
               
            }).catch(error => proxy.$log('[Notice] noticeLoad error: ',error.response.data));
        }
        noticeLoad();


        //서버로부터 총 게시물 수를 가져옴.
        // const getTotalItems = () => {
        //     http.get('/home/getNoticeTotalItems', {
        //         params:{
        //             'searchValue': noticeStore.pagingC.noticeSearch,
        //             'searchType': noticeStore.pagingC.noticeSearchType
        //         }
        //     }).then((res) => {
        //         noticeStore.paging.totalItems = res.data;
        //     }).catch(error => proxy.$log('[Notice] getTotalItems error: ', error.response.data));
        // }
        // getTotalItems();


        const createNotice = () => {
            router.push({
                name: 'noticeCU',
                params: {    // params로 넘기면 정상작동은 하나 오류로 표시됨.  :변수 형태로 넘겨도 오류뜬다. 버그인듯..
                    user_id : userInfo.info.id,
                    isUpdate : false
                }
            });
        }


        //페이지 보여질 줄수 선택
        const pageRowSelected = (params, e) => {
            let x;
            //e.target.value == 선택이후 noticeStore.paging.itemsPerPage
            // e.target.value : 1 = noticeStore.paging.itemsPerPage : x  << 여기서 itemsPerPage는 선택이전 값을 저장중
            if (noticeStore.paging.itemsPerPage < e.target.value) {
                x = noticeStore.paging.itemsPerPage / e.target.value; // << 변경전의 페이지줄수에 관하여 선택한 줄수에 대비한 비율을 계산함. 크면 1보다 크고, 작으면 1보다 작다.
                
            } else {
                x = e.target.value / noticeStore.paging.itemsPerPage;
            }
            // console.log('x :>> ', x);
            // console.log('e.target.value :>> ', e.target.value);
            // console.log('noticeStore.paging.itemsPerPage :>> ', noticeStore.paging.itemsPerPage);
            //계산이 끝난 후에는 기존의 값을 변화된 값으로 덮어씀
            noticeStore.paging.itemsPerPage = e.target.value;
            noticeStore.paging.currentPage = Math.ceil(x * noticeStore.paging.currentPage);
            noticeStore.classVar = noticeStore.paging.currentPage;
            noticeLoad();

        }

        //라우터로 글 클릭시 이동
        // const rowClicked = (item) => {
        //     router.push({ name : 'noticeContent', query : { notice_no: item.notice_no } });
        // }
        const rowClicked = (item) => {
            console.log('rowClicked : ', item);
            // showed.value = true;
            // rowInfo.value = item;

            //조회수 업용 통신
            http.put('/home/noticeRowClicked', {
                notice_no: item.notice_no
            }).then((res) => {
                console.log('[Notice] rowClicked: 조회수업성공결과 :>> ', res.data.result);
            })

            //현재 줄 표시 css 활성
            noticeStore.rowClickedCSSVar = item.notice_no;

            router.push({ name: 'noticeContent', query: {notice_no: item.notice_no}})
            window.scrollTo({ top: 0, behavior: 'smooth'}); //글 클릭시 맨위로 가기 참고 - messages.scrollTo({ top: messages.scrollHeight, behavior: 'smooth' });
        }

        //이벤트전달 테스트용. 현재 용도 없음
        const rowDeleted = (deletedRowNum) => {
            console.log('[Notice] deletedRowNum :>> ', deletedRowNum);
            // router.go(0)
            // window.location.reload();
        }


        

        //검색버튼 엔터시
        const searchWord = () => {
            // console.log("noticeSearch: ", noticeSearch.value);
            // console.log("noticeSearchType: ", noticeSearchType.value);
            // http.get('/home/notice', {        //get방식은 params 옵션을 이용해서 쿼리스트링을 보낸다.
            //     params:{
            //         noticeSearch : noticeStore.noticeSearch,
            //         noticeSearchType : noticeStore.noticeSearchType
            //     }
            // }).then( res => {
            //     console.log('[Notice] searchRes :>> ', res.data);
            //     noticeT.value = res.data;
            //     store.rstate++;
            //     router.push({ name: 'noticeContent', query: { notice_no: route.query.notice_no, noticeSearch: noticeStore.noticeSearch }});
            // })
            noticeStore.paging.currentPage = 1; //검색 엔터시 현재 페이지를 1페이지로 초기화 시켜준다.
            noticeStore.classVar = 1;           //현재 paging을 나타내기위한 css 변수 classVar 또한 1로 현재 페이지와 동기화 시켜 css를 변화시켜준다.
            noticeLoad();
        }



        return{
            noticeT, store, noticeStore, 
            userInfo,  //showed, rowInfo, noticeSearch, noticeSearchType,
            searchWord, createNotice,  rowClicked, rowDeleted, gotoClickedPage, pageRowSelected
        }
    }

}
</script>

<style scoped>

.currentPagingCSS {
    font-weight: 700;
    font-size: larger;
    text-decoration: underline;
    
    /* --tw-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
    --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);
    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); */
}

.rowClickedCSS {
    --tw-border-opacity: 0.25;
    background-color: rgb(209 213 219 / var(--tw-border-opacity));
}


</style>


<!-- 
const paging = reactive({
            prevPage: 0,
            nextPage: 0,
            firstPage: 0,
            lastPage: 0,
            currentPage: 1,             //초기화 필요
            totalPageCount: 0,
            itemsPerPage: 5,           //초기화 필요
            pageCountPerPageGroup: 10,  //초기화 필요
            seqOfPageGroup: 0,
            totalItems: 0,              //서버로부터 받아오는 값
            currentItem: 0,             
            noticeSearch: '',
            noticeSearchType: '제목'
        })

        const pagingC = computed({
            get: () => {
                const res = {
                    currentItem: paging.currentItem,                         //현재 클릭한 게시물 번호
                    currentPage: paging.currentPage,
                    totalItems: paging.totalItems,
                    itemsPerPage: paging.itemsPerPage,
                    pageCountPerPageGroup: paging.pageCountPerPageGroup,
                    
                    linkArray: [],
                    noticeSearch: paging.noticeSearch,
                    noticeSearchType: paging.noticeSearchType
                }
                res.totalPageCount = Math.ceil(res.totalItems/res.itemsPerPage);                  //모든 게시물이 표시되는데 필요한 총 페이지 수
                res.seqOfPageGroup = Math.ceil(res.currentPage/res.pageCountPerPageGroup);        //화면에 보여지는게 몇번째 페이지 그룹인지 나타낸 수
                res.lastPage = res.seqOfPageGroup * res.pageCountPerPageGroup;                    //현재 화면에 보이는 마지막 페이지 번호
                res.firstPage = res.lastPage - res.pageCountPerPageGroup + 1;                     //현재 화면에 보이는 첫번째 페이지 번호
                res.nextPage = res.lastPage+1;                                                    //다음 페이지 번호 << 현재페이지에 대입해야함.
                res.prevPage = res.firstPage-1;

                if (res.lastPage > res.totalPageCount) {
                    res.lastPage = res.totalPageCount;  //현재 화면에 보여질 마지막 페이지 번호가 총 페이지 수보다 크면 총페이지수를 마지막번호로 지정
                }
                for (let i = res.firstPage; i <= res.lastPage; i++) {
                    res.linkArray.push(i);
                }

                //db에서 검색할 게시물 번호 범위
                res.dbEndNumber = res.currentPage * res.itemsPerPage;
                res.dbStartNumber = res.dbEndNumber - res.itemsPerPage + 1;

                return res;
            },
            set: (paging) => {
            }
        })




 -->