<template>
<div v-for="item in pList" v-bind:key="item.product_name" id="contentholderrootdiv" class="max-w-[323px] min-w-[323px] p-4"> <!-- w-screen -->
    <a href="#" class="block p-4 rounded-lg shadow-sm shadow-indigo-200" v-on:click="atag('hello',$event)" v-on:mouseleave="aonmouseleave">
        <img alt="이미지를 로드할 수 없습니다. 재시도 요망" :src="imageLoad(item)"
            class="object-cover w-full h-56 rounded-md" />
<!-- itemImgLoad != null? itemImgLoad:'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif' -->
        <div class="mt-2">
            <dl>
                <div>
                    <dt class="sr-only">
                        Price
                    </dt>
                    <dd class="text-lg font-extrabold">
                        ￦{{item.product_price.toLocaleString()}}
                    </dd>
                </div>

                <div>
                    <dt class="sr-only">
                        상품명
                    </dt>
                    <dd class="font-medium">
                        {{item.product_name}}
                    </dd>
                </div>
            </dl>

            <dl class="flex items-start mt-6 space-x-4 text-xs">
                <div class="sm:inline-flex sm:items-center sm:shrink-0">
                    <!-- <svg class="w-4 h-4 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg> -->

                    <div class="sm:ml-3 mt-1.5 sm:mt-0">
                        <dt class="text-gray-500">
                            상품가격
                        </dt>
                        <dd class="font-medium text-center">
                            {{item.product_price.toLocaleString()}}원
                        </dd>
                    </div>
                </div>

                <div class="sm:inline-flex sm:items-center sm:shrink-0">
                    <!-- <svg class="w-4 h-4 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg> -->

                    <div class="sm:ml-3 mt-1.5 sm:mt-0">
                        <dt class="text-gray-500">
                            SPEC
                        </dt>
                        <dd class="font-medium text-center">
                            {{item.product_spec }}
                        </dd>
                    </div>
                </div>

                <div class="sm:inline-flex sm:items-center sm:shrink-0">
                    <!-- <svg class="w-4 h-4 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg> -->
                    <div class="sm:ml-3 mt-1.5 sm:mt-0">
                        <dt class="text-gray-500">
                            개수선택
                        </dt>
                        <dd class="font-medium">
                            <input value="0" type="number" name="eabox" id="eabox" class="w-12 text-center border">
                            <!-- <select name="ea" id="eabox">
                                <option value="0">ea</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select> -->
                        </dd>
                    </div>
                </div>
            </dl>

        </div>
    </a>
</div>
</template>

<script>
import { ref, onMounted, getCurrentInstance, computed } from 'vue';
import http from "@/modules/http";

export default {
    name: 'Menu',
    props:{
        it :{ type: Array }  //Home items에서 넘어온 값
        // item:{ name: String, price: Number, expire: Number }
    },
    setup(props) {
        const {proxy} = getCurrentInstance();
        // const itemImg = ref({});
        const pList = ref([]);

        http.get('/productc/pList').then((res) => {
            pList.value = res.data;
        })

        const imageLoad = (item) => {
            proxy.$log('Contentholder.imageLoad(): ', item);
            if (item.product_image != null) {
                proxy.$log('Contentholder.imageLoad(): ', item);
                return 'http://192.168.112.128/uploads/'+item.product_image[0];
            } else {
                proxy.$log('Contentholder.imageLoad() else: ', item);
                return 'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif';
            }
        }

        // const itemImgLoad = computed({
        //     get: () => {
        //         if (itemImg.value['product_no'] != undefined) {
        //             http.get('/productc/pImage', { params: {'product_no':itemImg.product_no }}).then((res) => {
        //                 proxy.$log('Contentholder.itemImgLoad(): ', res.data);
        //                 if ( res.data != null ) {
        //                     proxy.$log('Contentholder.itemImgLoad() if true: ', res.data);
        //                     return res.data[0];
        //                 } else {
        //                     const url = URL.createObjectURL('./')  //'https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif'
        //                     proxy.$log('Contentholder.itemImgLoad() else false: ', url);
        //                     return url;
        //                 }
        //             }) 
        //         }
        //     },
        //     set: (v) => {
        //         itemImg.value = v;
        //     }
        // })

        let atag = (t, e) => {
            if (e.target.tagName == 'INPUT'){
                // e.stopImmediatePropagation();
                // e.stopPropagation();  //이것만 했을 때는 a 태그의 클릭이벤트가 select 태그와 겹쳐서 둘다 작동되었음.
                e.preventDefault();     // 하지만, 이것을 했을 때는 select 태그를 클릭했을 시, a 태그의 클릭이벤트가 동작하지 않음. 정답을 여기서 찾음!
            }
            // a.onclick = e =>{
            //     // e.target.style.color = 'blue';
            //     // e.target.classList.add('pointer-events-none');
            // }
        }

        const aonmouseleave = e =>{
                console.log("마우스리브")
            }

        // onMounted(()=>{
        // })

        return{
            pList, 
            aonmouseleave, atag, imageLoad
        }
    }



}
</script>
