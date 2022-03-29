<template>
    <div class="flex flex-col w-full px-0">
        <div class="overflow-x-auto shadow-md sm:rounded-md mt-10">
            <NoticeContent v-if="showed"></NoticeContent>
            <!-- 본문 -->
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
                            <tr v-for="item in noticeT" :key="item.no" @click="rowClicked(item)" class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
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
                                    {{item.notice_title}}
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
        <div class="flex p-4">
            <select v-model="noticeSearchType" name="option" id="searchbox"  class="block mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
            </div>
            
        </div>

    </div>

</template>


<script>
import { inject, ref } from "vue";
import http from '../modules/http.js';
import { useRouter } from 'vue-router';
import NoticeContent from './NoticeContent.vue'

export default {
    name: 'Notice',
    components: {
        NoticeContent
    },
    setup(){
        const noticeT = ref([]); //글목록배열
        let noticeSearch = ref(''); //글 검색창
        let noticeSearchType = ref('제목'); // 글검색종류
        const router = useRouter();

        //공지글 상세페이지부분
        const showed = ref(false);
        
        //라우터로 글 클릭시 이동
        const rowClicked = (item) => {
            router.push({ name : 'noticeContent', query : { notice_no: item.notice_no } });
        }
        
        //글목록 서버에서 불러오기
        // const http = inject('http');  //작동은 하는데 ide에서 툴팁이 작동을 안해서 디버깅이 어렵네..
        http.get('/home/notice').then(res => {
            console.log('Notice:res: ', res.data);
            noticeT.value = res.data;
            console.log('Notice:noticeT.value: ', noticeT.value);

        })

        //검색버튼 엔터시
        const searchWord = () => {
            // console.log("noticeSearch: ", noticeSearch.value);
            // console.log("noticeSearchType: ", noticeSearchType.value);
            http.get('/home/noticeSearch', {        //get방식은 params 옵션을 이용해서 쿼리스트링을 보낸다.
                params:{
                    noticeSearch : noticeSearch.value,
                    noticeSearchType : noticeSearchType.value
                }
            }).then(res => {
                console.log('searchRes :>> ', res.data);
                noticeT.value = res.data;
            })
        }



        return{
            noticeT, noticeSearch, searchWord, noticeSearchType, rowClicked,
            showed
        }
    }

}
</script>




