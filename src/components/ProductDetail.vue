<template>

<div class="relative max-w-screen-xl px-4 py-8 mx-auto">
    <!-- 헤더 -->
    <div>
        <h1 class="text-2xl font-bold lg:text-3xl">
            {{ product['product_name'] }}
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            카테고리: {{ product.category_code }}
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
                {{ product['product_name'] }}
                </legend>
            </fieldset>
            <!-- <input v-model="product['product_name']" type="text" class="w-full px-4 bg-gray-100 border rounded"> -->

            <div class="text-xl font-bold">재고: {{ product['product_stock'] }}</div>
            <!-- <input v-model.number="product['product_stock']" type="number" class="w-full px-4 bg-gray-100 border rounded" /> -->

            <div class="text-xl font-bold">SPEC: {{ product.product_spec }}</div>
            <!-- <div class="px-4 bg-gray-100 border rounded">
                <input v-model="product.product_spec" type="text" class="w-full bg-gray-100 border rounded" placeholder="SPEC" />
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
            <button @click="purChaseClicked()" type="button" class="w-full px-6 py-3 text-sm font-bold tracking-wide text-white uppercase bg-red-700 rounded hover:bg-red-800">
                바로구매
            </button>

            <button @click="cartClicked()" type="button" class="w-full px-6 py-3 text-sm font-bold tracking-wide uppercase bg-gray-100 border border-gray-300 rounded" >
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

    <!-- 리뷰 시작 -->
    <section>
        <div class="max-w-screen-xl px-4 py-8 mx-auto sm:px-6 lg:px-8">
            <h2 class="text-xl font-bold sm:text-2xl">사용자 리뷰</h2>

            <div class="flex items-center mt-4">
            <p class="text-3xl font-medium">
                {{ 리뷰평균별점계산결과.toFixed(1) }}
                <span class="sr-only"> 평균 리뷰 점수 </span>
            </p>

            <div class="ml-4">
                <div class="flex -ml-1"> 
                    <svg v-for="index in Math.round( 리뷰평균별점계산결과 ) " :key="index" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg v-for="index in 5-Math.round( 리뷰평균별점계산결과 )" :key="index" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-200" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>

                <p class="mt-0.5 text-xs text-gray-500">총 리뷰수 {{ product_review.length }}개</p>
            </div>
            </div>

            <div class="grid grid-cols-1 mt-8 lg:grid-cols-2 gap-x-16 gap-y-12">
            <!-- 리뷰 목록 시작 -->
            <blockquote v-for="item in product_review">
                <header class="sm:items-center sm:flex">
                <div class="flex -ml-1">
                    <svg v-for="index in Number(item.review_grade)" :key="index" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg v-for="index in 5-Number(item.review_grade)" :key="index" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-200" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>

                <p class="mt-2 font-medium sm:ml-4 sm:mt-0"> {{ (item.writer).replace(/(..)$/, '**') }} </p>
                </header>

                <p v-html="item.content" class="mt-2 text-gray-700">  </p>

                <footer class="mt-4">
                <p class="text-xs text-gray-500"> {{ item.write_date }} </p>
                </footer>
            </blockquote>

            
            </div>
        </div>
    </section>

</div>

</template>

<script>
import { reactive, ref, toRefs, getCurrentInstance } from 'vue'
import http from "@/modules/http";
import Qeditor from './Qeditor.vue'
import { computed } from '@vue/reactivity';
import { routeLocationKey, useRoute, useRouter } from 'vue-router';
import { useLoginStore } from '@/stores/login';
import { useStore } from '@/stores/store';

export default {
    name: "ProductDetail",
    components: { Qeditor },
    // props: ['productNo'],

    setup(props,context) {
        const userInfo = useLoginStore();
        const store = useStore();
        const { proxy } = getCurrentInstance(); //global instance의 global변수를 담고있는 proxy객체를 가져옴.
        const route = useRoute();
        const router = useRouter();
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
            product_image: {},   //[]을 {}로 받아도 무방하네 결국 []도 객체니깐? 좀더 알아보자
            product_review: [],  //이건 그냥 []로 받아버리기
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
                    if (isImageLoad) { //서버통신으로 이미지가 로드되었다면 true로 바뀔것이고 ifile에 이미지대입했을것이기에 그대로 리턴만해준다. 성능위함
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


        const 서버로부터데이터로딩 = () => {
            http.get('/productc/getProductInfo', {
                params:{
                    product_no: route.query.product_no
                }
            }).then((res) => {
                proxy.$log('[ProductDetail] 서버로부터데이터로딩: ', res.data); //result:상품정보, resultImg:이미지경로정보
                product.product = res.data.result;
                //받아온 이미지경로 정보배열을 존재확인 후 임시배열에 주소형식으로 저장하여 ifile에 넣으면 ifileC에서 이미지슬라이드로 넘김
                if (res.data.resultImg[0] != null) {
                    isImageLoad = true;     //ifileC getter에서 이미지로딩이 성공적으로 로딩되었는지(if문) 확인하는 용도. 이미지를 잘받아왔으니 true를 넣는다는 뜻.
                    const tmp = [];
                    for (const item of res.data.resultImg) {
                        tmp.push('http://192.168.112.128/uploads/'+item['stored_file_name']);
                    }
                    ifileC.value = tmp;
                }
                editor.value = res.data.result.product_desc; //Qeditor의 내용에 받아온 상품설명값을 넣음
                product.product_review = res.data.resultReview; //상품 리뷰목록 대입
               
            }).catch((error) => {
                proxy.$log('[ProductDetail] 서버로부터데이터로딩 error: ', error.response.data);
            })
        }
        서버로부터데이터로딩();


        //바로구매 버튼 클릭시
        const purChaseClicked = () => {
            cartClicked();
            router.push({name: 'cart'});
        }

        //장바구니 버튼 클릭시
        const cartClicked = () => {
            http.get('/productc/addProductInCart', {
                params:{
                    product_no: route.query.product_no,
                    product_count: selectCount.value,   //추가할 개수
                    cart_owner: userInfo.info.id
                }
            }).then((res) => {
                if (res.data.result == 'false') {
                    proxy.$log('[ProductDetail] 장바구니추가 res false: ', res.data.msg);
                } else {
                    // store.$state.cartCount += 개수선택.value;
                    selectCount.value = 1; //장바구니 추가후에는 초기화해줌
                    let doYouGo = confirm('상품이 장바구니에 담겼습니다. 확인하시겠습니까?')
                    if(doYouGo){
                        store.cartStateMutation(); //전역 스토어의 장바구니 현황을 갱신하기 위해 실행해준다.
                        router.push({name: 'cart'})
                    }
                }
                
            }).catch(error => proxy.$log('[ProductDetail] 장바구니추가 error: ', error.response.data))
            
            //db추가 & 장바구니 아이콘에 1,2 ..개수표시 (이건 pinia에 글로벌 변수로 계산되게 해야할듯 개수선택변수의 숫자에 따라 글로벌변수가 자동으로 계산되게끔) 
        }

        const 리뷰평균별점계산결과 = computed(() => {
            const initialValue = 0;
            const sum = product.product_review.reduce((prev, crrentv) => {
                proxy.$log('[ProductDetail] 리뷰평균별점계산결과 length: ', product.product_review.length);
                proxy.$log('[ProductDetail] 리뷰평균별점계산결과 prev: ', prev);
                proxy.$log('[ProductDetail] 리뷰평균별점계산결과 currt: ', Number(crrentv.review_grade));

                return Number(prev) + Number(crrentv.review_grade);
            }, initialValue);
            const avg = (sum / product.product_review.length) || 0 ;  //아니면 0 이라는 뜻이니 앞의 숫자가 null or undefined이면 0을 리턴한다는 뜻인듯??
            proxy.$log('[ProductDetail] 리뷰평균별점계산결과: ', avg);
            return avg;
        })
        


        return {
            editor, ifile, ifileC, slide, ...toRefs(product), selectCount, computedPrice, 리뷰평균별점계산결과,
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