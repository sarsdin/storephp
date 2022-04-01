<template>

    <div class="flex flex-col w-full px-0">  <!-- 정렬'방향'이 colume처럼(세로정렬) -->
        <div class="overflow-x-auto shadow-md sm:rounded-md mt-0">
            <!-- 본문 -->
            <div class="inline-block min-w-full align-middle bg-slate-50 dark:bg-gray-800">
                <div class="overflow-hidden text-lg px-3 mt-3">
                    <!-- 제목 : {{ noticeT[0] ? noticeT[0].title:'' }} -->
                    <!-- 제목 : {{$route.params.title}}  -->
                    <!-- [공지사항]  {{ rowInfo.notice_title }} -->
                    <input type="text" name="title" id="title" 
                    :value="noticeT[0]['notice_title']" @input="noticeT[0]['notice_title'] = $event.target.value"
                    class="w-full"  >                    <!-- 한글은 v-model의 경우 뒤에 한글자식 짤리기에 @input + :value를 쓴다 -->
                </div>
                <div class="flex space-x-7 text-xs p-3 border-b-2 text-slate-500">
                    <div>
                        <font-awesome-icon :icon="['far', 'user']" class="text-slate-500" /> {{ noticeT[0]['notice_writer'] }}
                    </div>
                    <div v-if="isUpdate">
                        <font-awesome-icon :icon="['far', 'clock']" class="text-slate-500" /> {{ noticeT[0]['notice_date'] }}
                        <!-- {{ rowInfo.notice_date }} -->
                    </div>
                    <div v-if="isUpdate">
                        <font-awesome-icon :icon="['far', 'eye']" class="text-slate-500" /> {{ noticeT[0]['notice_hit'] }}
                        <!-- {{ rowInfo.notice_hit }} -->
                    </div>
                </div>

            </div>

            <!-- 내용 -->
            <div class="bg-white p-5 min-h-[350px]">
                <!-- {{ rowInfo.notice_content }} -->
                <!-- {{ noticeT[0]['notice_content'] }} -->
                <!-- {{ $route.params.content }} <br><br>
                 {{ $route.params.writer }} -->
                 <textarea name="content" id="content" class="w-full h-[50vh] resize-none" placeholder=" 내용을 입력해주세요."
                    :value="noticeT[0]['notice_content']" @input="noticeT[0]['notice_content'] = $event.target.value"
                 ></textarea>
            </div>
        </div>


         <!-- 댓글 영역 -->
        <div class="flex flex-col p-4 mb-5">
             <div class="flex relative min-h-[30px] mb-3">
                <!-- <div>
                   <font-awesome-icon :icon="['far', 'comment-dots']" /> 댓글 <b class="text-amber-600">0</b>
                </div> -->
                <div class="absolute right-2 space-x-2">
                    <!-- <button  @click="deleteClicked" class="border p-1 rounded-md text-slate-600 bg-slate-100 hover:bg-slate-300">삭제</button> -->
                    <button  @click="updateClicked" class="border p-1 rounded-md text-slate-600 bg-slate-100 hover:bg-slate-300">수정하기</button>
                </div>
            </div>
            
            <!-- 개별댓글 시작 -->
            <!-- <div class="flex space-x-4 min-h-[30px] mb-3">
                <div>
                    <font-awesome-icon :icon="['fab', 'github-square']" class="text-5xl text-blue-700" />
                </div>
                <div class="flex flex-col min-w-fit">
                    <div class="text-sm text-slate-600">admin</div>
                    <div class="text-xs text-slate-600">2022-3-30 10:00:10</div>
                    <div class="text-sm text-blue-400">To:@user</div>
                </div>
                <div class="w-full">
                    <textarea name="reply" rows="3" class="w-full p-3 border rounded-md resize-none" placeholder=" 댓글을 입력해주세요." ></textarea>
                </div>
            </div> -->
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
import { watch, reactive, ref, readonly, onMounted, toRefs, computed } from 'vue';
import { router } from '@/router/router';

export default {
    name: 'noticeCU',
    // props: {
    //     rowInfo: {
    //         type: Object,
    //         default: ()=>{   //type이 Object이면 반드시 리턴함수를 적어야함.
    //             return {}
    //         }
    //     },
    // },

    setup () { //setup에 props가 전달되면 setup내에서 props는 readonly이며 컴포넌트는 반응형 변수에 반응하지않는다. watch로 변화된 값을 감지하여 메소드로 직접 값을 대입시켜줘야한다.
        const route = useRoute();
        // const router = useRouter();
        const noticeT = ref([{}]);
        const isUpdate = ref(false);
        // const noticeM = ref({
        //     notice_title: '',
        //     notice_content: ''
        // })
        //미리 들어올 데이터 타입에 맞는 구조가 있어야 undefined 가 안뜬다. 만약, 들어올 데이터가 [{}] 이렇게 배열안에 객체나 배열이라면?
        //ref 안에 초기화할때도 저렇게 데이터객체를 만들어놔야 데이터가 적합한 곳에 들어간다. 들어갈 공간구조가 할당되어 있지 않으면 당연히 undefined..

        if (route.params.isUpdate) {    //isUpdate가 true이면 update작업, 아니면 create작업
            console.log("router::: " , route.query.notice_no);
            http.get('/home/noticeContent', {   //글 상세페이지 로드
                params: {
                    // no: route.params.no, //params로 받을때는 params로 query로 받을땐 query로 받음. 둘의 구별 필요.
                    notice_no: route.query.notice_no,     //query방식의 장점 : params는 새로고침시 데이터가 날라간다는 말이 있지만, query는 url에 데이터가 있어서 안날라간단다..
                    // content : route.query.content
                }
            }).then(res => {
                console.log('NoticeContent res.data: ', res.data);
                noticeT.value = res.data;
                console.log('NoticeContent noticeT.value: ', noticeT.value);
                isUpdate.value = route.params.isUpdate;
            }).catch((err) => {
                console.error('NoticeContent err: ', err);
            })

            // const name = computed(() => {
            //     return 
            // })
            
        }
// {
//                 params: {
//                     notice_no : route.params.notice_no,
//                     notice_title : notice[0]['title'],
//                     notice_content : notice[0]['content'],
//                     notice_title : notice[0]['title'],
//                 }
//             }

        const updateClicked = () => {
            http.put('/home/updateNotice', noticeT.value[0]).then((res) => {
                if (res.data.result == true) {
                    alert('글을 업데이트 하였습니다.');
                    router.push({
                        name: 'noticeContent',
                        query: {notice_no: noticeT.value[0]['notice_no']}
                    })
                }
            })
        }

        return {
            noticeT, isUpdate, 
            updateClicked,
        }
    }
}
</script>

