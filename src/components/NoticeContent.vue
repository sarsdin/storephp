<template>

    <div class="flex flex-col w-full px-0">  <!-- 정렬'방향'이 colume처럼(세로정렬) -->
        <div class="overflow-x-auto shadow-md sm:rounded-md mt-0">
            <!-- 본문 -->
            <div class="inline-block min-w-full align-middle bg-slate-50 dark:bg-gray-800">
                <div class="overflow-hidden text-lg px-3 mt-3">
                    <!-- 제목 : {{ noticeT[0] ? noticeT[0].title:'' }} -->
                    <!-- 제목 : {{$route.params.title}}  -->
                    <!-- [공지사항]  {{ rowInfo.notice_title }} -->
                    [공지사항]  {{ noticeT[0]['notice_title'] }}
                </div>
                <div class="flex space-x-7 text-xs p-3 border-b-2 text-slate-500">
                    <div>
                        <font-awesome-icon :icon="['far', 'user']" class="text-slate-500" /> {{ noticeT[0]['notice_writer'] }}
                        <!-- {{ rowInfo.notice_writer }} -->
                    </div>
                    <div>
                        <font-awesome-icon :icon="['far', 'clock']" class="text-slate-500" /> {{ noticeT[0]['notice_date'] }}
                        <!-- {{ rowInfo.notice_date }} -->
                    </div>
                    <div>
                        <font-awesome-icon :icon="['far', 'eye']" class="text-slate-500" /> {{ noticeT[0]['notice_hit'] }}
                        <!-- {{ rowInfo.notice_hit }} -->
                    </div>
                </div>

            </div>

            <!-- 내용 -->
            <div class="bg-white p-5 min-h-[250px]">
                <!-- {{ rowInfo.notice_content }} -->
                {{ noticeT[0]['notice_content'] }}
                <!-- {{ $route.params.content }} <br><br>
                 {{ $route.params.writer }} -->
            </div>
        </div>


         <!-- 댓글 영역 -->
        <div class="flex flex-col p-4 mb-5">
            <div class="flex relative min-h-[30px] mb-3">
                <div>
                   <font-awesome-icon :icon="['far', 'comment-dots']" /> 댓글 <b class="text-amber-600">0</b>
                </div>
                <div class="absolute right-2 space-x-2">
                    <button v-show="isOwner == true" @click="deleteClicked" class="border p-1 rounded-md text-slate-600 bg-slate-100 hover:bg-slate-300">삭제</button>
                    <button v-show="isOwner == true" @click="updateClicked" class="border p-1 rounded-md text-slate-600 bg-slate-100 hover:bg-slate-300">수정</button>
                </div>
            </div>
            <hr class="mb-3">

            <!-- 개별댓글 시작 -->
            <div class="flex space-x-4 min-h-[30px] mb-3">
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
            </div>
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
import { watch, reactive, ref, readonly, onMounted, toRefs, computed, inject } from 'vue';
import { useLoginStore } from '@/stores/login';

export default {
    name: 'noticeContent',
    // props: {
    //     rowInfo: {
    //         type: Object,
    //         default: ()=>{   //type이 Object이면 반드시 리턴함수를 적어야함.
    //             return {}
    //         }
    //     },
    // },
    // props: ['rowInfo'],
    inject: ['userInfo'],
    emits: ['rowDeleted'],

    setup (props, context) { //setup에 props가 전달되면 setup내에서 props는 readonly이며 컴포넌트는 반응형 변수에 반응하지않는다. watch로 변화된 값을 감지하여 메소드로 직접 값을 대입시켜줘야한다.
        // const ownerShip = inject('userInfo');  //전역 유저 정보 로딩
        const userInfo = useLoginStore();       //전역 유저 정보 로딩
        const isOwner = ref(false);            //현재 유저가 글의 주인인지 확인하는 변수. 삭제,수정버튼용
        const route = useRoute();
        const router = useRouter();
        const noticeT = ref([{}]);
        //미리 들어올 데이터 타입에 맞는 구조가 있어야 undefined 가 안뜬다. 만약, 들어올 데이터가 [{}] 이렇게 배열안에 객체나 배열이라면?
        //ref 안에 초기화할때도 저렇게 데이터객체를 만들어놔야 데이터가 적합한 곳에 들어간다. 들어갈 공간구조가 할당되어 있지 않으면 당연히 undefined..
        
        //받아오는 데이터 값은 제일 먼저 실행되어야 한다
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
           
            isOwner.value = ownerShipCompute.value;       //전역 저장소의 userInfo의 id 값이 이 글의 주인과 일치하는지를 계산된 결과값으로 대입
            console.log('NoticeContent ownerShipCompute: ', ownerShipCompute.value); //computed된 값도 setup안에서 다룰려면 .value를 붙여야함!!!!
        }).catch((err) => {
            console.error('NoticeContent err: ', err);
        })

        //전역 user Id 값이 해당 글의 주인인지 확인하고 결과여부를 반환
        let ownerShipCompute = computed(() => {
            if (userInfo.info.id == noticeT.value[0]['notice_writer'] ) {
                return true;
            }
        })

        const updateClicked = () => {
            router.push({
                name: 'noticeCU',
                query: {
                    notice_no: noticeT.value[0]['notice_no'],
                },
                params: {
                    notice_no: noticeT.value[0]['notice_no'],
                    isUpdate: true
                }
            })
        }
        const deleteClicked = () => {
            const tORf = confirm('정말 삭제하시겠습니까?');
            if (tORf) {
                http.get('/home/deleteNotice',{
                    params: {
                        notice_no: noticeT.value[0]['notice_no'],
                    }
                }).then((res) => {
                    alert(res.data.msg);
                    // window.location.href="notice";
                    context.emit('rowDeleted', noticeT.value[0]['notice_no']);
                    // window.location.reload();
                    router.push({ name: 'notice'}); //새로고침안되지만 router-view속성에 :key="$route.fullPath" 를 추가하여 새로고침함. 이때 로딩될 router-view에 지정하는것이 중요!
                    // router.resolve({ name: 'notice'})
                    // router.push({ path: '/notice'})
                    // router.go(1);
                }).catch((error) => {
                    console.log("deleteClicked error: ", error.response.data);
                })
            }
        }

      

        // 라우트 인스턴스를 감시하여 uri의 parameter의 변화에 컴포넌트가 동적으로 반응하게 만듦
        // watch(() => route.query.notice_no, (newValue, oldValue) => { 
        //     // console.log("watch->noticeT::: " , noticeT.value);
        //     // console.log("watch->noticeT:::new " , newValue);
        //     // console.log("watch->noticeT:::old " , oldValue);
        //     // noticeT.value = newValue;                        //이곳이 반응형 컴포넌트를 만들기 위해 props의 값을 감지하여 직접 대입시켜주는 부분이다!
        //     console.log("watch->router::: " , route.query.notice_no);
        //     if (route.query.notice_no != undefined) {
        //         http.get('/home/noticeContent', {
        //             params: {
        //                 notice_no: newValue,
        //             }
        //         }).then(res => {
        //             console.log('NoticeContent: watch->route: ', res.data);
        //             noticeT.value = res.data;
        //             console.log('NoticeContent watch->noticeT.value: ', noticeT.value);
        //         }).catch((err) => {
        //             console.error('NoticeContent: watch->route: err: ', err);
        //         })
        //     }

        //     }, { 
        //         immediate: true, deep: true
        // })

        return {
            noticeT, isOwner,
            updateClicked, deleteClicked
        }
    }
}
</script>

