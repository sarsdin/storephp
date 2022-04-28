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
        <div class="flex flex-col p-4">
            <div class="flex relative min-h-[30px] mb-3">
                <div>
                   <font-awesome-icon :icon="['far', 'comment-dots']" /> 댓글 <b class="text-amber-600">{{ noticeStore.replyL.length }}</b>
                </div>
                <div class="absolute right-2 space-x-2">
                    <button v-show="isOwner == true" @click="deleteClicked" class="border p-1 rounded-md text-slate-600 bg-slate-100 hover:bg-slate-300">삭제</button>
                    <button v-show="isOwner == true" @click="updateClicked" class="border p-1 rounded-md text-slate-600 bg-slate-100 hover:bg-slate-300">수정</button>
                </div>
            </div>
            <hr class="mb-3">

            <!-- 개별댓글 시작 -->
            <div v-for="item in noticeStore.replyL" class="flex flex-col" >
                <div class="flex space-x-4 min-h-[30px] mb-3"
                :class="{'ml-10': item.parent_reply_writer != null }"> <!-- 받아온 댓글 중 자식댓글이라면 들여쓰기해줌 -->
                    <div>
                        <font-awesome-icon :icon="['fab', 'github-square']" class="text-5xl text-blue-700" />
                    </div>
                    <div class="min-w-fit">
                        <div class="flex flex-col min-w-fit">
                            <div class="text-sm text-slate-600">{{ item.notice_reply_writer }}</div>
                            <div class="text-xs text-slate-600">{{ item.notice_reply_writedate }}</div>
                            <div class="text-sm text-blue-400">{{ item.parent_reply_writer? 'To:@'+item.parent_reply_writer:'' }}</div>
                        </div>
                        <div class="mt-2 text-sm text-right">
                            <button v-if="item.notice_reply_writer == userInfo.info.id" @click="deleteReply(item)" class="border p-1 rounded-md text-slate-600 hover:text-white hover:font-bold hover:bg-slate-300">삭제</button>
                            <button v-if="item.notice_reply_writer == userInfo.info.id" @click="updateReply(item)" class="border p-1 rounded-md text-slate-600 hover:text-white hover:font-bold hover:bg-slate-300">수정</button>
                            <button v-if="item.notice_reply_writer != userInfo.info.id" @click="answerInputToggle(item)" class="border p-1 rounded-md text-slate-600 hover:text-white hover:font-bold hover:bg-slate-300">답글</button>
                        </div>
                        
                    </div>
                    <div class="w-full">
                        <textarea v-if="item.visibleState" :value="item.notice_reply_content" :readonly="item.notice_reply_writer != userInfo.info.id"
                        name="reply" rows="3" class="w-full p-3 border rounded-md resize-none" placeholder=" 댓글을 입력해주세요." ></textarea>
                        <div v-else v-html="item.notice_reply_content"
                        name="reply" rows="3" class="w-full min-h-[100px] p-3 border text-gray-600 bg-gray-50 rounded-md resize-none" >
                        </div>
                    </div>
                </div>

                <!-- 대댓글 입력창 - 조건에 따라 나타나게끔. -->
                <div v-if="item.notice_reply_no == noticeStore.currentAnswerInputItemNumber" class="flex space-x-4 min-h-[30px] mb-2 ml-11">
                    <div>
                        <font-awesome-icon :icon="['fab', 'github-square']" class="text-5xl text-blue-700" />
                    </div>
                    <div class="min-w-fit">
                        <div class="flex flex-col min-w-fit">
                            <div class="text-sm text-slate-600">{{ userInfo.info.id }}</div>
                            <div class="text-xs text-slate-600">{{ '' }}</div>
                            <div class="text-sm text-blue-400">{{ '' }}</div>
                        </div>
                        <div class="mt-2 text-sm text-right">
                            <button @click="createReplyAnswer(item)" class="border p-1 w-full rounded-md text-slate-600 hover:text-white hover:font-bold hover:bg-slate-300">답글달기</button>
                            <!-- <button>수정</button> -->
                        </div>
                    </div>

                    <div class="w-full">
                        <textarea :value="noticeStore.reply.notice_reply_content" @change="noticeStore.reply.notice_reply_content = $event.target.value"
                            name="reply" rows="3" class="w-full p-3 border rounded-md resize-none" placeholder=" 댓글을 입력해주세요." ></textarea>
                    </div>
                </div>    

                <!-- 대댓글 로딩부분 -->
                <!-- <div v-if="item.parent_reply_no != null">
                    <div v-for="answerItem in noticeAnswerItemsLoad(item)">

                    </div>
                        ddd
                </div> -->

            </div>


            <!-- 댓글 쓰기 UI 부분 -->
            <div class="flex space-x-4 min-h-[30px] my-3 mt-5">
                <div>
                    <font-awesome-icon :icon="['fab', 'github-square']" class="text-5xl text-blue-700" />
                </div>
                <div class="min-w-fit">
                    <div class="flex flex-col min-w-fit">
                        <div class="text-sm text-slate-600">{{ userInfo.info.id }}</div>
                        <div class="text-xs text-slate-600">{{ '' }}</div>
                        <div class="text-sm text-blue-400">{{ '' }}</div>
                    </div>
                    <div class="mt-2 text-sm text-right">
                        <button @click="createReply(item)" class="border p-1 w-full rounded-md text-slate-600 hover:text-white hover:font-bold hover:bg-slate-300">댓글쓰기</button>
                        <!-- <button>수정</button> -->
                    </div>
                </div>

                <div class="w-full">
                    <textarea :value="noticeStore.reply.notice_reply_content" @change="noticeStore.reply.notice_reply_content = $event.target.value"
                     name="reply" rows="3" class="w-full p-3 border rounded-md resize-none" placeholder=" 댓글을 입력해주세요." ></textarea>
                </div>
            </div>
            
            
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
        </div>

    </div>

</template>

<script>
import http from '../modules/http';
import { useRouter, useRoute} from 'vue-router';
import { watch, reactive, ref, readonly, onMounted, toRefs, computed, inject, getCurrentInstance } from 'vue';
import { useLoginStore } from '@/stores/login';
import { useNoticeStore } from '@/stores/notice';
import { useStore } from '@/stores/store';

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
    // inject: ['userInfo'],
    emits: ['rowDeleted'],

    setup (props, context) { //setup에 props가 전달되면 setup내에서 props는 readonly이며 컴포넌트는 반응형 변수에 반응하지않는다. watch로 변화된 값을 감지하여 메소드로 직접 값을 대입시켜줘야한다.
        // const ownerShip = inject('userInfo');  //전역 유저 정보 로딩
        const noticeStore = useNoticeStore();   //전역 공지 관련 store
        const store = useStore();
        const userInfo = useLoginStore();       //전역 유저 정보 로딩
        const isOwner = ref(false);            //현재 유저가 글의 주인인지 확인하는 변수. 삭제,수정버튼용
        const {proxy} = getCurrentInstance();
        const route = useRoute();
        const router = useRouter();
        const noticeT = ref([{}]);
        //미리 들어올 데이터 타입에 맞는 구조가 있어야 undefined 가 안뜬다. 만약, 들어올 데이터가 [{}] 이렇게 배열안에 객체나 배열이라면?
        //ref 안에 초기화할때도 저렇게 데이터객체를 만들어놔야 데이터가 적합한 곳에 들어간다. 들어갈 공간구조가 할당되어 있지 않으면 당연히 undefined..

        //답글달기 나타나게 할지말지 결정하는 변수
        // const answerVar = reactive({
        //         isAnswerInput: false,

        //     }
        // )

        //받아오는 데이터 값은 제일 먼저 실행되어야 한다
        const noticeContentLoad = () => {
            console.log("router::: " , route.query.notice_no);
            http.get('/home/noticeContent', {
                params: {
                    // no: route.params.no, //params로 받을때는 params로 query로 받을땐 query로 받음. 둘의 구별 필요.
                    notice_no: route.query.notice_no,     //query방식의 장점 : params는 새로고침시 데이터가 날라간다는 말이 있지만, query는 url에 데이터가 있어서 안날라간단다..
                }
            }).then(res => {
                console.log('[NoticeContent] res.data: ', res.data);
                noticeT.value = res.data;
                console.log('[NoticeContent] noticeT.value: ', noticeT.value);
            
                isOwner.value = ownerShipCompute.value;       //전역 저장소의 userInfo의 id 값이 이 글의 주인과 일치하는지를 계산된 결과값으로 대입
                console.log('[NoticeContent] ownerShipCompute: ', ownerShipCompute.value); //computed된 값도 setup안에서 다룰려면 .value를 붙여야함!!!!
            }).catch((err) => {
                console.error('[NoticeContent] err: ', err);
            })
        }
        noticeContentLoad();


        //전역 user Id 값이 해당 글의 주인인지 확인하고 결과여부를 반환
        let ownerShipCompute = computed(() => {
            if (userInfo.info.id == noticeT.value[0]['notice_writer'] ) {
                return true;
            }
        })


        // 글수정 버튼 클릭
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

        // 글삭제 버튼 클릭
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
                    router.push({ name: 'notice'}); //새로고침안되지만 router-view속성에 :key="$route.fullPath" 를 추가하여 새로고침함. 이때 로딩될 router-view에 지정하는것이 중요!
                }).catch((error) => {
                    console.log("deleteClicked error: ", error.response.data);
                })
            }
        }


        //댓글 로드
        const noticeReplyLoad = () => {
            http.get('/home/noticeReplyLoad', {params: { notice_no: route.query.notice_no }}).then((res) => {
                proxy.$log('[NoticeContent] noticeReplyLoad res: ', res.data);
                noticeStore.replyL = res.data;
                noticeStore.replyL.forEach((item,i,origin) => {
                    origin[i].visibleState = false;             //현재 그냥 보이는 div 상태인지, 수정하는 textarea상태인지에 대한 여부
                    // origin[i].isAnswerInput = false;
                    origin[i].notice_reply_content = origin[i].notice_reply_content.replace(/(\n|\r\n)/g, '<br>'); //textarea 줄바꿈처리 정규식

                })

            }).catch(error=>proxy.$log('[NoticeContent] noticeReplyLoad error: ', error.response.data))
        }
        noticeReplyLoad();


        //댓글 쓰기 클릭시
        const createReply = (item) => {
            let postData = {
                    notice_no : route.query.notice_no,
                    notice_reply_content: noticeStore.reply.notice_reply_content,
                    notice_reply_writer: userInfo.info.id,
                }
            http.post('/home/noticeCreateReply', postData).then((res) => {
                proxy.$log('[NoticeContent] noticeCreateReply res: ', res.data);
                if (res.data == true) {
                    noticeStore.reply.notice_reply_content = '';
                }
                
            }).catch(error=>proxy.$log('[NoticeContent] noticeCreateReply error: ', error.response.data))
        }

        //답글 버튼 토글 메소드
        const answerInputToggle = (item) => {
            if (noticeStore.currentAnswerInputItemNumber == item.notice_reply_no) {
                noticeStore.currentAnswerInputItemNumber = -1;
                
            } else {
                noticeStore.currentAnswerInputItemNumber = item.notice_reply_no;
            }

            // if (item.isAnswerInput == false) {
            //     // noticeStore.replyL.isAnswerInput == true
            //     noticeStore.replyL.currentAnswerInputItemNumber = item.notice_reply_no
            //     item.isAnswerInput = true;
                
            // } else {
            //     item.isAnswerInput = false;
            // }
        }


        //답글달기 클릭시
        const createReplyAnswer = (item) => {
            let postData = {
                    notice_no : route.query.notice_no,
                    notice_reply_content: noticeStore.reply.notice_reply_content,
                    notice_reply_writer: userInfo.info.id,
                    reply_group : item.reply_group,
                    parent_reply_no : item.notice_reply_no,
                    parent_reply_writer : item.notice_reply_writer,
                }
            http.post('/home/noticeCreateReplyAnswer', postData).then((res) => {
                proxy.$log('[NoticeContent] createReplyAnswer res: ', res.data);
                if (res.data == true) {
                    noticeStore.reply.notice_reply_content = ''; //textarea 에 쓴 글들은 작업이 끝나면 초기화 되어야함.
                    // store.rstate++;
                    answerInputToggle(item);
                    noticeReplyLoad();
                }
                
            }).catch(error=>proxy.$log('[NoticeContent] createReplyAnswer error: ', error.response.data))
        }

        //실험 - 답글정보 로딩 v-for에서 메소드로..
        const noticeAnswerItemsLoad = async (item) => {
            await http.get('/home/noticeAnswerItemsLoad', {
                params:{ 
                    'notice_no': route.query.notice_no,
                    'reply_group': item.reply_group,
                    'parent_reply_no': item.notice_reply_no,
                }
            }).then((res) => {
                proxy.$log('[NoticeContent] noticeAnswerItemsLoad res: ', res.data);
                item.answerData = res.data;
                return item.answerData;
                
            }).catch(error=>proxy.$log('[NoticeContent] noticeAnswerItemsLoad error: ', error.response.data))
        }


        //댓글 수정
        const updateReply = (item) => {
            
        }

        //댓글 삭제
        const deleteReply = (item) => {
            
        }



        return {
            noticeT, isOwner, noticeStore, userInfo,// ...toRefs(answerVar),
            updateClicked, deleteClicked,
            createReply, updateReply, deleteReply, createReplyAnswer, answerInputToggle, noticeAnswerItemsLoad
        }

       

    }
}
</script>






<!-- 

        //라우트 인스턴스를 감시하여 uri의 parameter의 변화에 컴포넌트가 동적으로 반응하게 만듦
        watch(() => route.query.notice_no, (newValue, oldValue) => { 
            // console.log("watch->noticeT::: " , noticeT.value);
            // console.log("watch->noticeT:::new " , newValue);
            // console.log("watch->noticeT:::old " , oldValue);
            // noticeT.value = newValue;                        //이곳이 반응형 컴포넌트를 만들기 위해 props의 값을 감지하여 직접 대입시켜주는 부분이다!
            console.log("watch->router::: " , route.query.notice_no);
            if (route.query.notice_no != undefined) {
                http.get('/home/noticeContent', {
                    params: {
                        notice_no: newValue,
                    }
                }).then(res => {
                    console.log('NoticeContent: watch->route: ', res.data);
                    noticeT.value = res.data;
                    console.log('NoticeContent watch->noticeT.value: ', noticeT.value);
                }).catch((err) => {
                    console.error('NoticeContent: watch->route: err: ', err);
                })
            }

            }, { 
                immediate: true, deep: true
        })



 -->