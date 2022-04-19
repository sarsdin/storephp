<template>
<!--- more free and premium Tailwind CSS components at https://tailwinduikit.com/ --->
<div v-if="propsModalC == true" class="min-h-[1200px] max-h-fit mt-[290px] transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0" id="modal">
    <div role="alert" class="container mx-auto w-[500px] md:w-3/6 max-w-6xl">
        <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
            <!-- 헤더 -->
            <slot/>

            <!-- 배송지 선택 부분 -->
            <div v-if="배송지선택" >
                <h5 class="text-center font-semibold text-zinc-600">배송지 선택</h5><br><hr>
                <div v-for="item in info" :key="item.user_id" class="my-4 p-2 bg-white space-y-2 border-2">
                    <div class="flex items-center text-lg font-semibold space-x-4">
                        {{ item.user_name }}
                    </div>
                    <div class="flex items-center text-lg space-x-4">
                        {{ item.user_address1 }}
                    </div>
                    <div class="flex items-center text-lg space-x-4">
                        {{ item.user_address2 }}
                    </div>
                    <div class="flex items-center text-lg space-x-4">
                        {{ item.user_phone }}
                    </div>
                    <button @click="수정클릭(item)" class="border py-2 px-4 mx-1 rounded text-blue-500">수정</button>
                    <button @click="선택클릭(item)" class="border py-2 px-4 mx-1 rounded text-white bg-blue-500">선택</button>
                </div>

                <button @click="배송지추가클릭()" class="w-full text-blue-500 font-bold text-lg border-2 p-2 my-2 rounded">배송지 추가</button>
            </div>

            <!-- 배송지 추가 부분 -->
            <div v-if="배송지추가">
                <h5 class="text-center font-semibold text-zinc-600">배송지 추가</h5><br><hr>
                <div class="my-4 bg-white space-y-2">
                    <div class="flex items-center text-lg space-x-4">
                        <font-awesome-icon :icon="['far', 'user']" class="text-gray-400"></font-awesome-icon>
                        <input @change="tmpName = $event.target.value" :value="tmpName" type="text" name="receiver" placeholder="받는사람" >
                    </div>
                    <div class="flex items-center text-lg space-x-4">
                        <font-awesome-icon :icon="['fas', 'map-location-dot']" class="text-gray-400"></font-awesome-icon>
                        <input @click="daumPost" v-model="tmpAddressC" type="text" name="post" placeholder="우편번호 찾기" class="w-full" >
                    </div>
                    <div id="ss" ref="embed" class="w-full flex justify-center bg-[#ECECEC]">
                        
                        </div>
                    <div class="flex items-center text-lg space-x-4">
                        <font-awesome-icon :icon="['fas', 'map-location-dot']" class="text-gray-400"></font-awesome-icon>
                        <input @change="tmpAddress.address2 = $event.target.value" :value="tmpAddress.address2" type="text" name="post" placeholder="상세주소" class="w-full" >
                    </div>
                    <div class="flex items-center text-lg space-x-4">
                        <font-awesome-icon :icon="['fas', 'phone']" class="text-gray-400"></font-awesome-icon>
                        <input v-model="tmpPhone" type="text" name="phone" placeholder="휴대폰 번호" >
                    </div>
                </div>

                <button @click="저장클릭()" class="w-full text-blue-500 font-bold text-lg border-2 p-2 my-2 rounded">저장</button>
            </div>

            <!-- 배송지 수정 부분 -->
            <div v-if="배송지수정">
                <h5 class="text-center font-semibold text-zinc-600">배송지 수정</h5><br><hr>
                <div class="my-4 bg-white space-y-2">
                    <div class="flex items-center text-lg space-x-4">
                        <font-awesome-icon :icon="['far', 'user']" class="text-gray-400"></font-awesome-icon>
                        <input type="text" name="receiver" placeholder="받는사람" >
                    </div>
                    <div class="flex items-center text-lg space-x-4">
                        <font-awesome-icon :icon="['fas', 'map-location-dot']" class="text-gray-400"></font-awesome-icon>
                        <input type="text" name="post" placeholder="우편번호 찾기" >
                    </div>
                    <div class="flex items-center text-lg space-x-4">
                        <font-awesome-icon :icon="['fas', 'phone']" class="text-gray-400"></font-awesome-icon>
                        <input type="text" name="phone" placeholder="휴대폰 번호" >
                    </div>
                </div>
                <button @click="저장클릭()" class="w-full text-blue-500 font-bold text-lg border-2 p-2 my-2 rounded">저장</button>
            </div>

            

            <!-- 취소버튼 -->
            <div class="relative mx-auto max-w-screen-xl">
                <!-- <button class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-8 py-2 text-sm">
                    제출
                </button> -->
                <button class="focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-gray-400 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm" 
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
import { onMounted, reactive, toRefs, ref, computed, getCurrentInstance } from 'vue'
import http from '@/modules/http'
import { useLoginStore } from '@/stores/login';
import { useStore } from '@/stores/store';

export default {
    name: "AddressModal",
    props: ["isOpened"],
    emits: ["update:isOpened", '선택클릭'],
    // components: { ProductModalContent },

    setup(props, context) {
        const userInfo = useLoginStore();
        const store = useStore();
        const {proxy} = getCurrentInstance();
        // const modal = (props["modelValue"]); //ref, reactive는 컴포넌트 내에서의 값에만 반응하는듯 외부로부터 받은값 props에는 반응성이 초기에만 한번 대입되고 그후로는 없어지는듯?? 그래서 computed로 반응성을 입혀준다!?
        const propsModalC = computed(() => { //computed의 getter를 이용해서 readonly 값을 리턴한다. writable하게 할려면 set()을 선언해줘야함.
            loadAddress();                //모달의 화면제어가 될때마다 주소목록을 불러오기
            return props["isOpened"];     //위쪽 컴포넌트에서 model props로 true를 받으면 모달 보여주기.
        });
        const embed = ref(null);        //도로명,지번 API 를 나오게 할 div 태그를 설정.`

        const state = reactive({
            배송지선택: true,            //여기 3가지 변수는 모달 화면제어를 위한 변수
            배송지추가: false,
            배송지수정: false,
            info: [],                   //Address List를 담는 변수

        })
        
        //배송지추가 임시 저장변수
        const tmpValue = reactive({
            tmpName: '',
            tmpAddress: {
                postcode: "",
                address: "",
                address2: "",
                extraAddress: "",
            },
            tmpPhone: ''
        })
        const tmpAddressC = computed(() => {
            if (tmpValue.tmpAddress.postcode == '') {
                return '';
            } else {
                return tmpValue.tmpAddress.postcode+" " + tmpValue.tmpAddress.address +" "+ tmpValue.tmpAddress.extraAddress;
            }
        })

        //초기 주소 서버로부터 불러오기
        const loadAddress = () => {
            http.get('/paymentc/getAddressList', {
                params: {
                    user_id: userInfo.info.id
                }
            }).then((res) => {
                proxy.$log('[AddressModal] getAddressList res: ', res.data);
                state.info = res.data.result;
    
            }).catch(error => proxy.$log('[AddressModal] getAddressList error: ', error.response.data))
        }


        //취소 클릭시
        const cancelClicked = () => {
            // modal.value = false;
            state.배송지선택 = true;
            state.배송지추가 = false;
            state.배송지수정 = false;
            임시주소데이터초기화();
            context.emit("update:isOpened", false);
        };
        const 임시주소데이터초기화 = () => {
            tmpValue.tmpName = "";
            tmpValue.tmpPhone = "";
            tmpValue.tmpAddress.postcode = "";
            tmpValue.tmpAddress.address = "";
            tmpValue.tmpAddress.address2 = "";
            tmpValue.tmpAddress.extraAddress = "";
        }

        const 배송지추가클릭 = () => {
            state.배송지선택 = false;
            state.배송지추가 = true;
            state.배송지수정 = false;
        }
        const 배송지초기화면 = () => {
            state.배송지선택 = true;
            state.배송지추가 = false;
            state.배송지수정 = false;
        }

      
        //배송지 추가 저장클릭시
        const 저장클릭 = () => {
            let tmpInfo = {
                user_id: userInfo.info.id,
                user_name: tmpValue.tmpName,
                user_address1: String(tmpAddressC.value).toString(),
                user_address2: tmpValue.tmpAddress.address2,
                user_phone: tmpValue.tmpPhone,
            }
            state.info.push(tmpInfo);

            http.post('/paymentc/addAddress', tmpInfo).then((res) => {
                proxy.$log('[AddressModal] 저장클릭 res: ', res.data);
            }).catch((error) => {
                proxy.$log('[AddressModal] 저장클릭 error: ', error.response.data);
            })

            배송지초기화면();
            임시주소데이터초기화();
            window.scrollTo({ top: 260, behavior: 'smooth'}); //글 클릭시 맨위로 가기 참고 - messages.scrollTo({ top: messages.scrollHeight, behavior: 'smooth' });
        };

        
        //도로,지번 주소검색 API
        const daumPost = () => {
            embed.value.classList.add('border');
            new window.daum.Postcode({
                oncomplete: (data) => {
                    if (tmpValue.tmpAddress.extraAddress !== "") {
                        tmpValue.tmpAddress.extraAddress = "";
                    }
                    if (data.userSelectedType === "R") {
                        // 사용자가 도로명 주소를 선택했을 경우
                        tmpValue.tmpAddress.address = data.roadAddress;
                    } else {
                        // 사용자가 지번 주소를 선택했을 경우(J)
                        tmpValue.tmpAddress.address = data.jibunAddress;
                    }

                    // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                    if (data.userSelectedType === "R") {
                        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                        if (data.bname !== "" && /[동|로|가]$/g.test(data.bname)) {
                            tmpValue.tmpAddress.extraAddress += data.bname;
                        }
                        // 건물명이 있고, 공동주택일 경우 추가한다.
                        if (data.buildingName !== "" && data.apartment === "Y") {
                            tmpValue.tmpAddress.extraAddress +=
                                tmpValue.tmpAddress.extraAddress !== ""
                                    ? `, ${data.buildingName}`
                                    : data.buildingName;
                        }
                        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                        if (tmpValue.tmpAddress.extraAddress !== "") {
                            tmpValue.tmpAddress.extraAddress = `(${tmpValue.tmpAddress.extraAddress})`;
                        }
                    } else {
                        tmpValue.tmpAddress.extraAddress = "";
                    }
                    // 우편번호를 입력한다.
                    tmpValue.tmpAddress.postcode = `(${data.zonecode})`;
                    embed.value.classList.remove('border');
                },
                theme: {
                    // searchBgColor: "#0B65C8", //검색창 배경색
                    // queryTextColor: "#FFFFFF" //검색창 글자색
                    // outlineColor: "#ECECEC" //테두리
                }
            }).embed(embed.value );
            
        }

        //배송지 선택 클릭시
        const 선택클릭 = (item) => {
            store.receiverInfo = item;  //store에 배송지주소 입력한다
            context.emit('선택클릭', item); //상위 컴포넌트인 Payment.vue 로 이벤트와 배송지정보 전송
            cancelClicked();            //modal을 닫은 뒤 모달임시변수 초기화
        }

        //배송지 수정 클릭시
        const 수정클릭 = (item) => {
            
        }

       
        return {
            // modal, 
            ...toRefs(state), ...toRefs(tmpValue), propsModalC, embed, tmpAddressC,
            cancelClicked, 배송지추가클릭, 저장클릭, daumPost, 선택클릭, 수정클릭
            
        };
    },
}
</script>

<style scoped>

</style>