<template>

<div class="relative max-w-screen-xl px-4 py-8 mx-auto">
    <!-- 헤더 -->
    <div>
        <h1 class="text-2xl font-bold lg:text-3xl">
            상품수정
        </h1>
        <!-- <p class="mt-1 text-sm text-gray-500">
            카테고리: 카테고리명
        </p> -->
    </div>

    <!-- 본문 시작 -->
    <div class="grid gap-8 lg:items-start lg:grid-cols-4">
        <!-- 사진 등록 -->
        <div class="lg:col-span-3">
            <div class="flex relative mt-4 justify-center">
                <label class="min-w-full" for="ifile" @click="onImageClicked($event)" > <!--label이 input과 이어져 있을때 둘은 동기화(같은태그,같은이벤트). -->
                    <!-- <img alt="" :src="ifileC" class="w-fit rounded-xl h-72 lg:h-[450px] object-contain" /> -->
                    <!-- <div class="w-full rounded-xl h-72 lg:h-[450px] object-cover" >{{ this.$refs.ifiles.value }}</div> -->
                    <!-- <q-carousel
                        :dark="false"
                        height=""
                        :padding="false"
                        control-color=""
                        control-text-color=""
                        control-type="regular"
                        :autoplay="null"
                        :arrows="false"
                        prev-icon=""
                        next-icon=""
                        :navigation="false"
                        navigation-position="bottom/right"
                        navigation-icon=""
                        navigation-active-icon=""
                        :thumbnails="false"
                        v-model="panelName"
                        :keep-alive="false"
                        keep-alive-include="a,b"
                        keep-alive-exclude="a,b"
                        keep-alive-max="2"
                        :animated="false"
                        :infinite="false"
                        :swipeable="false"
                        :vertical="false"
                        transition-prev="slide-right/slide-down"
                        transition-next="slide-left/slide-up"
                        :fullscreen="false"
                        :no-route-fullscreen-exit="false"
                        @update:model-value="null"
                        @before-transition="null"
                        @transition="null"
                    >
                        <template #default>
                            content
                        </template>
                        <template #control>
                            content
                        </template>
                        <template #navigation-icon>
                            content
                        </template>
                    </q-carousel> -->

                    <q-carousel
                    class="w-full"
                    v-model="slide"
                    swipeable
                    animated
                    thumbnails
                    infinite
                    
                    >
                        <q-carousel-slide v-for="(file, index) in ifileC" :key="file" :name="index+1" :img-src="file" 
                         class="!bg-contain bg-no-repeat"/>
                        <!-- <q-carousel-slide :name="2" img-src="https://cdn.quasar.dev/img/parallax1.jpg" />
                        <q-carousel-slide :name="3" img-src="https://cdn.quasar.dev/img/mountains.jpg" /> /> -->
                    </q-carousel>
                </label>
                <input @change="ifileC = $event.target.files" id="ifile" type="file" class="hidden"  multiple accept="image/png, image/jpeg, image/gif" name="ifile" />
                <!-- <input type="text" class="" ref="ifiles" name="file" id="ifile" value="testestesstesalkjsflkjsldkgjsldkgjlgjlkjgalksjfdalkj/n sakfdjksdfj"> -->
            </div>
        </div>

        <div class="lg:top-0 lg:sticky">
        <form class="space-y-1 lg:pt-0">
            <!-- 상단 동그라미 -->
            <fieldset class="p-0">
                <legend class="text-lg font-bold">
                상품명
                </legend>

                <!-- <div class="flex mt-0 space-x-1">
                    <label for="color_green" class="cursor-pointer">
                        <input type="radio" id="color_green" name="color" class="sr-only peer" checked />
                        <span class="block w-6 h-6 bg-green-700 border border-gray-200 rounded-full ring-1 ring-offset-1 ring-transparent peer-checked:ring-gray-300"></span>
                    </label>
                </div> -->
            </fieldset>
            <input v-model="product.product['product_name']" type="text" class="w-full px-4 bg-gray-100 border rounded">

            <div class="text-lg font-bold">카테고리</div>
            <!-- <input type="number" class="w-full px-4 bg-gray-100 border rounded"> -->
            <select v-model="product.product.category_code" name="category" class="w-full px-4 bg-gray-100 border rounded">
                <optgroup label="라면즉석식품">
                    <option value="라면">라면</option>
                    <option value="즉석밥">즉석밥</option>
                    <option value="죽/스프">죽/스프</option>
                    <option value="기타즉석식품">기타즉석식품</option>
                </optgroup>
                <optgroup label="커피음료">
                    <option value="커피">커피</option>
                    <option value="차류">차류</option>
                    <option value="음료">음료</option>
                    <option value="생수/기타">생수/기타</option>
                </optgroup>
                <optgroup label="과자류">
                    <option value="스낵">스낵</option>
                    <option value="쿠키/비스켓">쿠키/비스켓</option>
                    <option value="초콜릿">초콜릿</option>
                    <option value="수입과자/기타">수입과자/기타</option>
                </optgroup>
                <optgroup label="식품류">
                    <option value="통조림">통조림</option>
                    <option value="조미/소스류">조미/소스류</option>
                    <option value="밀가루">밀가루</option>
                    <option value="장류/양념류">장류/양념류</option>
                    <option value="건어물/안주류">건어물/안주류</option>
                </optgroup>
                <optgroup label="생활잡화">
                    <option value="가정용품">가정용품</option>
                    <option value="위생용품">위생용품</option>
                    <option value="의약외품">의약외품</option>
                    <option value="일회용품">일회용품</option>
                    <option value="주방용품">주방용품</option>
                    <option value="욕실용품">욕실용품</option>
                </optgroup>
                <optgroup label="기타">
                    <option value="농수산물">농수산물</option>
                    <option value="냉동식품">냉동식품</option>
                    <option value="기타">기타</option>
                </optgroup>
            </select>

            <div class="text-lg font-bold">재고</div>
            <input v-model.number="product.product['product_stock']" type="number" class="w-full px-4 bg-gray-100 border rounded" />

            <div class="text-lg font-bold">SPEC</div>
            <div class="px-4 bg-gray-100 border rounded">
                <input v-model="product.product.product_spec" type="text" class="w-full bg-gray-100 border rounded" placeholder="SPEC" />
                <!-- <p class="text-sm">
                    <span class="block">
                    </span>
                </p> -->
            </div>

            <div>
                <p class="text-xl font-bold mb-2">가격</p>
                <input v-model.number="product.product['product_price']" type="number" class="w-full px-4 bg-gray-100 border rounded"/>
            </div>

            <hr>
            <button @click="modifyClicked" type="button" class="w-full px-6 py-3 text-sm font-bold tracking-wide text-white uppercase bg-red-700 rounded hover:bg-red-800">
                상품수정하기
            </button>

            <button type="button" class="w-full px-6 py-3 text-sm font-bold tracking-wide uppercase bg-gray-100 border border-gray-300 rounded" >
                품절처리
            </button>
        </form>
        </div>

        <!-- 내용(에디터) 부분 -->
        <div class="lg:col-span-3">
            <div class="prose max-w-none">
                <p class="mb-2"><b>내용작성</b></p>
                <!-- 에디터 위치 -->
                <!-- <Tiptap v-model="editorContent"></Tiptap> -->
                <Qeditor v-model="editor"></Qeditor>
                
                <!-- <p>{{ editor }}</p> -->
                <!-- <br><br>
                <h3>부연</h3>
                -->

            <!-- <iframe src="https://www.youtube-nocookie.com/embed/Eb-Vfe61W6A?controls=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
            </div>
        </div>

    </div><!--본문끝-->
</div>

</template>

<script>
import { reactive, ref, toRefs, getCurrentInstance } from 'vue'
import http from "@/modules/http";
import Tiptap from './Tiptap.vue'
import Qeditor from './Qeditor.vue'
import { computed } from '@vue/reactivity';
import consoleLog from '@/modules/consoleLog';

export default {
    name: "ProductModalUpdate",
    components: { Qeditor },
    props: ['productNo'],

    setup(props,context) {
        // const editorContent = ref();
        const { proxy } = getCurrentInstance(); //global instance의 global변수를 담고있는 proxy객체를 가져옴.
        const product = reactive({  //서버로 보낼 데이터가 담기는 변수. FormData로 담기며 product_image의 경우 file(이미지)이 담긴다.
            product : {
                product_no: 0,
                product_name: '',
                category_code: '',
                product_stock: 0,
                product_price: 0,
                product_spec: '',
                product_desc: '',
            },
            product_image: {}
        })
        const slide = ref(1)    //carousel의 슬라이드 번호를 담고 있으며 슬라이드 번호는 1부터 시작한다.(0이 아님)
        let isImageLoad = false;
        const editor = ref(''); //Qeditor으 내용을 담고 있다.
        const ifile = ref([])   //ifileC에서 처리될 image file을 담는 역할을 한다.
        const ifileC = computed({ //q-carousel-slide에서 이미지슬라이드를 처리하는데 사용되는 변수
            get: () => {
                proxy.$log("ifile: ", ifile.value); //global변수를 이용하여 console.log출력
                const tmp = [];
                if(ifile.value[0] != null) {//input tag에서 받아온 사진파일(배열)의 첫번재를 검사하여 데이터가 있다면 파일을 url로 변환하여 뷰에 연결.
                    proxy.$log('ifile not null: ', ifile.value);
                    // ifile.value.forEach(element => {  //forEach가 function이 아니라고 에러남
                    //     tmp.push(URL.createObjectURL(element))
                    // });
                    if (isImageLoad) { //서버통신으로 이미지가 로드되었다면 true로 바뀔것이고 ifile에 이미지대입했을것이기에 그대로 리턴만해준다.
                        isImageLoad = false; //이미지변경의 경우를 고려하여 미리 false로 초기화 해줌.
                        return ifile.value;
                    }
                    for (let i = 0; i < ifile.value.length; i++) {  //받은 사진배열의 길이만큼 뷰에 들어갈 url을 생성하여 new배열에 넣음.
                        const element = ifile.value[i];
                        tmp.push(URL.createObjectURL(element))
                    }
                    return tmp;
                } else {        //기본 노이미지일때 디폴트 화면
                    ifile.value.push('https://img.apti.co.kr/aptHome/images/sub/album_noimg.gif')
                    return ifile.value;
                    // return tmp.push(URL.createObjectURL(ifile.value[0]));
                }
            },
            set: (v) => {   //v == input files(FileList)
                ifile.value = v;
                product.product_image = v;      //axios로 보낼 formData에 사진파일 추가해줌
            }
            // return URL.createObjectURL(ifile.value[0]);
        })

        //서버로부터 update될 데이터 로딩
        http.get('/productc/getProductInfo', {
            params:{
                product_no: props.productNo
            }
        }).then((res) => {
            proxy.$log('[ProductModalUpdate] http.get: ', res.data); //result:상품정보, resultImg:이미지경로정보
            product.product = res.data.result;
            //받아온 이미지경로 정보배열을 존재확인 후 임시배열에 주소형식으로 저장하여 ifile에 넣으면 ifileC에서 이미지슬라이드로 넘김
            if (res.data.resultImg[0] != null) {
                isImageLoad = true;     //ifileC getter에서 이미지로딩이 성공적으로 로딩되었는지(if문) 확인하는 용도.
                const tmp = [];
                for (const item of res.data.resultImg) {
                    tmp.push('http://192.168.112.128/uploads/'+item['stored_file_name']);
                }
                ifileC.value = tmp;
            }
            editor.value = res.data.result.product_desc;
            // product : {
            //     product_name: '',
            //     category_code: '',
            //     product_stock: 0,
            //     product_price: 0,
            //     product_spec: '',
            //     product_desc: '',
            // },
            // product_image: {}
        }).catch((error) => {
            proxy.$log('[ProductModalUpdate] http.get error: ', error.response.data);
        })

        //상품수정 버튼 클릭
        const modifyClicked = () => {
            let data = new FormData();
            data.append('product_no', product.product.product_no)
            data.append('product_name', product.product.product_name)
            data.append('category_code', product.product.category_code)
            data.append('product_stock', product.product.product_stock)
            data.append('product_price', product.product.product_price)
            data.append('product_spec', product.product.product_spec)
            data.append('product_desc', editor.value)

            //다중 이미지를 올리면 FileList객체안의 개별 이미지 파일들을 FormData의 'produec_image[]'라는 키에 추가적으로 append한다.
            if (product.product_image.length > 0) {
                for (const key in product.product_image) {
                    if (Object.hasOwnProperty.call(product.product_image, key)) {
                        const element = product.product_image[key];
                        //FormData의 하나의 key에 다중 파일을 추가할려는 경우 key name형식을 []로 선언해야함. 
                        //태그에서의 경우는 <input name="product_image['key1']" <input name="product_image['key2']" <<이런식으로 지정하면 하나의 배열로 서버에서 받기 가능!
                        //그래야 서버쪽에서 형식을 파악하고 다중파일을 인식해서 가져올 수 있음
                        data.append('product_image[]', element);
                    }
                }
            }
            
            // const data1 = new FormData(); //test
            // data1.append('product', product) //test

            // proxy.$log('product_name data: ', data1.getAll('product')); //test
            proxy.$log('product_name data: ', data.getAll('product_name'));
            proxy.$log('modifyClicked data: ', data.getAll('product_image'));

            //서버통신
            http.post('/productc/updateProduct', data, {
                headers:{
                    'Content-Type': 'multipart/form-data'
                },
                // maxContentLength: 1,  //응답받는 콘텐츠 사이즈
                // maxBodyLength: 1      //요청하는 바디의 사이즈
            }).then((res) => {
                if (res != 'false') {
                    alert('상품수정 되었습니다.')
                    proxy.$log('[ProductModalUpdate]상품수정modifyClicked res: ' , res.data)
                    context.emit('modalOff', false)
                    window.location.reload();
                } else{
                    alert('상품수정 중 오류가 발생하였습니다.')
                    proxy.$log('[ProductModalUpdate]상품수정modifyClicked res: ' , res.data)
                }
            }).catch((error) => {
                proxy.$log('상품수정에러', error.response.data)
            })
        }


        return {
            // editorContent, 
            editor, ifile, ifileC, slide, product,
            onImageClicked(e){
                // alert('clicked')
                if (e.target.tagName == 'IMG') {    //label을 클릭했을때 전파되는 target요소가 img태그라면 기본click작동 중지하기.
                    e.preventDefault();
                    e.stopPropagation();
                }
            },
            modifyClicked
        };
    },

}
</script>

<style lang="scss" scoped>
//   .prose h3 {
//     margin-bottom: 1rem;
//     padding-bottom: 0.5rem;
//     border-bottom: 1px solid rgb(243 244 246);

//     /* @apply mb-1 pb-2 border-b border-gray-200; */
//   }

//   .prose iframe {
//     width: 100%;
//     margin-top: 1.5rem;
//     aspect-ratio: 16 / 9;
//     border-radius: 0.75rem;

//     /* @apply w-full aspect-video mt-6 rounded-xl; */

// .ProseMirror {
//   > * + * {
//     margin-top: 0.75em;
//   }

//   code {
//     background-color: rgba(#616161, 0.1);
//     color: #616161;
//   }
// }

// .content {
//   padding: 1rem 0 0;

//   h3 {
//     margin: 1rem 0 0.5rem;
//   }

//   pre {
//     border-radius: 5px;
//     color: #333;
//   }

//   code {
//     display: block;
//     white-space: pre-wrap;
//     font-size: 0.8rem;
//     padding: 0.75rem 1rem;
//     background-color:#e9ecef;
//     color: #495057;
//   }
// }


//   }
</style>