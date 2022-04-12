<template>

<div class="relative max-w-screen-xl px-4 py-8 mx-auto">
    <!-- 헤더 -->
    <div>
        <h1 class="text-2xl font-bold lg:text-3xl">
            {{ product.product['product_name'] }}
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            카테고리: {{ product.product.category_code }}
        </p>
    </div>

    <!-- 본문 시작 -->
    <div class="grid gap-8 lg:items-start lg:grid-cols-4">
        <!-- 사진 등록 -->
        <div class="lg:col-span-3">
            <div class="flex relative mt-4 justify-center">
                <label class="min-w-full" for="ifile" > <!--label이 input과 이어져 있을때 둘은 동기화(같은태그,같은이벤트). -->
                    <!-- <img alt="" :src="ifileC" class="w-fit rounded-xl h-72 lg:h-[450px] object-contain" /> -->
                    <!-- <div class="w-full rounded-xl h-72 lg:h-[450px] object-cover" >{{ this.$refs.ifiles.value }}</div> -->
                    <q-carousel
                    class="w-full"
                    v-model="slide"
                    swipeable
                    animated
                    thumbnails
                    infinite
                    :arrows="false"
                    :autoplay="true"
                    >

                        <q-carousel-slide v-for="(file, index) in ifileC" :key="file" :name="index+1" :img-src="file" 
                         class="!bg-contain bg-no-repeat"/>
                    </q-carousel>
                </label>
                <!-- <input @change="ifileC = $event.target.files" id="ifile" type="file" class="hidden"  multiple accept="image/png, image/jpeg, image/gif" name="ifile" /> -->
            </div>
        </div>

        <div class="lg:top-0 lg:sticky">
        <form class="space-y-3 lg:pt-0">
            <!-- 상단 동그라미 -->
            <fieldset class="p-0">
                <legend class="text-xl font-bold">
                {{ product.product['product_name'] }}
                </legend>
            </fieldset>
            <!-- <input v-model="product.product['product_name']" type="text" class="w-full px-4 bg-gray-100 border rounded"> -->

            <div class="text-xl font-bold">재고: {{ product.product['product_stock'] }}</div>
            <!-- <input v-model.number="product.product['product_stock']" type="number" class="w-full px-4 bg-gray-100 border rounded" /> -->

            <div class="text-xl font-bold">SPEC: {{ product.product.product_spec }}</div>
            <!-- <div class="px-4 bg-gray-100 border rounded">
                <input v-model="product.product.product_spec" type="text" class="w-full bg-gray-100 border rounded" placeholder="SPEC" />
                <p class="text-sm">
                    <span class="block">
                    </span>
                </p>
            </div> -->

            <div>
                <p class="text-xl font-bold mb-2">가격: 
                    <span class="text-red-500">{{ computedPrice }}원</span> 
                </p>
            </div>
            <div>
                <span class="text-xl font-bold mb-2">개수: </span>
                <input v-model.number="selectCount" type="number" min="0" pattern="[0-9]+" class="w-24 px-2 bg-gray-100 border rounded"/>
            </div>

            <hr>
            <button @click="purChaseClicked" type="button" class="w-full px-6 py-3 text-sm font-bold tracking-wide text-white uppercase bg-red-700 rounded hover:bg-red-800">
                바로구매
            </button>

            <button @click="cartClicked" type="button" class="w-full px-6 py-3 text-sm font-bold tracking-wide uppercase bg-gray-100 border border-gray-300 rounded" >
                장바구니
            </button>
        </form>
        </div>

        <!-- 내용(에디터) 부분 -->
        <div class="lg:col-span-3">
            <div class="prose max-w-none">
                <p class="mb-2"><b>상품상세</b></p>
                <!-- 에디터 위치 -->
                <Qeditor v-model="editor"
                :readonly="true" :toolbar="[]"
                class="!border-0"
                ></Qeditor>
                
            <!-- <iframe src="https://www.youtube-nocookie.com/embed/Eb-Vfe61W6A?controls=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
            </div>
        </div>

    </div><!--본문끝-->
</div>

</template>

<script>
import { reactive, ref, toRefs, getCurrentInstance } from 'vue'
import http from "@/modules/http";
import Qeditor from './Qeditor.vue'
import { computed } from '@vue/reactivity';
import { routeLocationKey, useRoute } from 'vue-router';

export default {
    name: "ProductDetail",
    components: { Qeditor },
    // props: ['productNo'],

    setup(props,context) {
        const { proxy } = getCurrentInstance(); //global instance의 global변수를 담고있는 proxy객체를 가져옴.
        const route = useRoute();
        const selectCount = ref(1); //선택한 상품 수량 - 이 수량에 따라 computedPrice가격도 같이 계산되어 변한다.
        const computedPrice = computed(() => {
            return Number(product.product.product_price * selectCount.value).toLocaleString('ko-KR');
        })
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

        //서버로부터  데이터 로딩
        http.get('/productc/getProductInfo', {
            params:{
                product_no: route.query.product_no
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
            editor.value = res.data.result.product_desc; //Qeditor의 내용에 받아온 상품설명값을 넣음
           
        }).catch((error) => {
            proxy.$log('[ProductModalUpdate] http.get error: ', error.response.data);
        })

        //바로구매 버튼 클릭시
        const purChaseClicked = () => {
            
        }

        //장바구니 버튼 클릭시
        const cartClicked = () => {
            
        }

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
            editor, ifile, ifileC, slide, product, selectCount, computedPrice,
            onImageClicked(e){
                // alert('clicked')
                if (e.target.tagName == 'IMG') {    //label을 클릭했을때 전파되는 target요소가 img태그라면 기본click작동 중지하기.
                    e.preventDefault();
                    e.stopPropagation();
                }
            },
            // modifyClicked,
            purChaseClicked,
            cartClicked
        };
    },

}
</script>

<style scoped>
/* input tag가 유효하지 않으면 발생 */
input:invalid {
  border: 3px solid red;
}
</style>

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