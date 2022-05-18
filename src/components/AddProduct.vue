<template>

<div class="flex flex-col w-full px-0">
    <div class="mt-5">
        <!-- 등록:
        <input type="text" placeholder="상품명" class="border-2">
        <input type="text" placeholder="가격" class="border-2">
        <input type="text" placeholder="재고수" class="border-2"> -->
        <input @click="openState = true, modalState = 'add' " type="button" value="등록하기" class="p-1 border-2 rounded-md cursor-pointer focus:ring-1">
        <ProductModal v-model="openState">
            <ProductModalContent v-if="modalState == 'add' " @modalOff="openState = false"></ProductModalContent>
            <ProductModalUpdate v-if="modalState == 'update' " :productNo="passNoForUpdate" @modalOff="openState = false"></ProductModalUpdate>
        </ProductModal>
        
        <!-- <div>
            <button></button>
        </div> -->

    </div>
    
    <div class="overflow-x-auto shadow-md sm:rounded-md mt-10">
        <!-- 본문 -->
        <div class="inline-block min-w-full align-middle dark:bg-gray-800">
            <div class="overflow-hidden">
                <table class="min-w-full w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <!-- <th scope="col" class="p-4 w-12">
                            <div class="flex items-center">
                                <input id="checkbox-search-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </div>
                        </th> -->
                        <th scope="col" class="w-10 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                            번호
                        </th>
                        <th scope="col" class="py-3 px-3 w-1/6 text-ellipsis overflow-hidden whitespace-nowrap text-center text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400">
                            카테고리
                        </th>
                        <th scope="col" class="py-3 px-6 w-2/6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                            품명
                        </th>
                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                            재고
                        </th>
                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                            가격
                        </th>
                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                            규격
                        </th>
                        <th v-show="true" scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                            <span class="sr-only">Edit</span>수정
                        </th>
                    </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <!-- <router-link :to="{ name : 'noticeContent', params: { no: item.no } }"  class="w-full" > 이건 힘들지..css수정도 힘들고 -->
                        <tr v-for="item in addProduct" :key="item.product_no" @click="rowClicked(item, $event)" class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <!-- <td class="p-4 w-4">
                                <div class="flex items-center">
                                    <input @click="checkBoxClicked(item, $event)" type="checkbox" name="productDeleteSelectBox"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </td> -->
                            <td class="py-3 px-3 w-16 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                                {{item.product_no}}
                            </td>
                            <td class="py-4 px-6 w-96 text-sm font-medium text-gray-900 text-center whitespace-nowrap text-ellipsis overflow-hidden dark:text-white">
                                {{item.category_code}}
                            </td>
                            <td class="py-4 px-6 text-sm text-center font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                {{item.product_name}}
                            </td>
                            <td class="py-4 px-6 text-sm text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <!-- {{item.product_stock}} -->
                                <input v-model="item.product_stock" type="text" name="product_stock" id="product_stock" class="w-16 text-center">
                            </td>
                            <td class="py-4 px-6 text-sm text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <!-- {{item.product_price}} -->￦
                                <input v-model="item.product_price" @keyup="inputNumberFormat(item)" type="text" name="product_price" id="product_price" class="w-16">
                            </td>
                            <td class="py-4 px-6 text-sm text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <!-- {{item.product_spec}} -->
                                <input v-model="item.product_spec" type="text" name="product_spec" id="product_spec" class="w-16 text-center">
                            </td>
                            
                            <td @click="modifyClicked(item)" class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">수정</a>
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
        <select v-model="searchType" name="option" id="searchbox"  class="block mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
            <input v-model="search" @keyup.enter="searchWord" type="text" id="table-search"
                    class="block w-60 pl-10 p-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="검색어 입력">
        </div>

         <!-- 페이징 부분 -->
        <div class="flex justify-center w-96">
            <button v-if="addStore.pagingC.lastPage > 10 " @click="gotoClickedPage(1, $event)" class="mr-1" >
                <font-awesome-icon class="text-gray-700" :icon="['fas', 'angles-left']"></font-awesome-icon>
            </button> 

            <button v-if="addStore.pagingC.prevPage != 0 " @click="gotoClickedPage(addStore.pagingC.prevPage, $event)" >
                <font-awesome-icon class="text-gray-700" :icon="['fas', 'square-caret-left']"></font-awesome-icon>
            </button> 
            
            <!-- @click시 store.rstate++을 이용해서 router-view를 갱신(리로드) 해주면 css를 바인딩으로 해결해야한다. 
            이벤트target으로 css를 수정하면 수정하자마자 재랜더링때문에 적용이 풀린다. -->                                              
            <button v-for="pageNumber in addStore.pagingC.linkArray" :key="pageNumber" :class="{'currentPagingCSS': addStore.classVar == pageNumber }"
                @click="gotoClickedPage(pageNumber, $event)" 
                class="text-gray-700 w-7 hover:text-blue-500 hover:font-semibold hover:text-lg">
                {{ pageNumber }}
            </button> 
            
            <button v-if="addStore.pagingC.lastPage < addStore.pagingC.totalPageCount" @click="gotoClickedPage(addStore.pagingC.nextPage, $event)" >
                <font-awesome-icon class="text-gray-700" :icon="['fas', 'square-caret-right']"></font-awesome-icon>
            </button>

        </div>
        
    </div>

</div>    

</template>

<script>
import { reactive, toRefs, ref, getCurrentInstance } from 'vue'
import { useRouter } from 'vue-router'
import { useAddStore } from '@/stores/addproduct'
import { useStore } from '@/stores/store'
import http from '../modules/http'
import ProductModal from './ProductModal.vue'
import ProductModalContent from './ProductModalContent.vue'
import ProductModalUpdate from './ProductModalUpdate.vue'

export default {
    name: 'AddProduct',
    components: { ProductModal, ProductModalContent, ProductModalUpdate },
    setup() {
        const addStore = useAddStore();
        const store = useStore();
        const openState = ref();  //modal이 클릭되어 오픈되어 있는지 여부상태 저장.
        const modalState = ref(); //modal이 클릭되는 버튼에 따라 다른 페이지를 오픈시킴.
        const passNoForUpdate = ref(); //updateModal이 열릴때 서버와 초기통신하기 위한 상품번호
        const state = reactive({
            addProduct: [],
        });
        let search = ref(""); //글 검색창
        let searchType = ref("제목"); // 글검색종류
        const router = useRouter();
        const { proxy } = getCurrentInstance();

        //상품 목록 로딩
        const 상품목록로드 = () => {
            http.get("/productc/addProductList", {
                params:{
                    'dbEndNumber': addStore.pagingC.dbEndNumber,
                    'dbStartNumber': addStore.pagingC.dbStartNumber,
                    'searchValue': addStore.pagingC.addProductSearch,
                    'searchType': addStore.pagingC.addProductSearchType,
                }
            }).then(res => {
                console.log("[addProduct] res: ", res.data); //todo: res.data의 price속성들의 값에 , 자리수를 처리해야함.(미완료)
                addStore.paging.totalItems = res.data.totalItems;

                state.addProduct = res.data.result;
                state.addProduct.forEach((item,i,origin) => {
                    origin[i].isDeleteChecked = false;
                })

            }).catch(error => console.log('[addProdcut] 상품목록로딩 error: ', error.response.data))
        }
        상품목록로드();

        const gotoClickedPage = (pageNumber, $event) => {
            addStore.paging.currentPage = pageNumber;
            $event.target.style.color = 'crimson';   //테스트용임. rstate++로 인해 작동안하는 중. 
            addStore.classVar = pageNumber;
            상품목록로드();

            //query string이 없다면 addContent컴포넌트는 실행하지 않음.
            store.rstate++;
            // if (route.query.product_no != undefined || route.query.product_no != null) {
            //     let params = {
            //         name: 'addContent', 
            //         query:{
            //             product_no: route.query.product_no
            //         }
            //     }
            //     // if (route.query.product_no) {}
            //     router.push(params);
            // }
        }

        //검색버튼 엔터시 -- 미완성
        const searchWord = () => {
            // console.log("noticeSearch: ", noticeSearch.value);
            // console.log("noticeSearchType: ", noticeSearchType.value);
            http.get("/home/noticeSearch", {
                params: {
                    noticeSearch: search.value,
                    noticeSearchType: searchType.value
                }
            }).then(res => {
                console.log("[addProdcut] searchWord Res: ", res.data);
                state.addProduct = res.data;

            }).catch(error => console.log('[addProdcut] searchWord error: ', error.response.data))
        };

        //줄 클릭시
        const rowClicked = (item, e) => {
            window.scrollTo({top:0})
            if (e.target.getAttribute('type') == 'checkbox') {
                e.stopPropagation();
                return;
            }
            if ((e.target.tagName == 'INPUT'|| e.target.tagName == 'A') ) { //해당 태그일 경우 이벤트 전파 중지
                e.preventDefault();
                e.stopPropagation();
                return;
            }
            // alert('test');
            passNoForUpdate.value = item.product_no; //이 값을 no가 아닌 item자체를 넣고 이걸 모달컴포넌트에 v-model props로 공유한다. 모달에서 그 값을 이용해 업데이트 작업(통신)을 한뒤 모달창 닫으면 끝. 등록은 새로고침이 되도 괜찮지만, 수정은 새로고침시 보고있는 상품의 화면이 없어지니깐  새로고침없이 업데이트 되도록 처리되는것이 좋다.
            openState.value = true;
            modalState.value = 'update';
        }

        //수정 클릭시
        const modifyClicked = (item) => {
            //아이템에 있는 값들 받아서 백엔드에 업데이트 해야지
            http.put('/productc/modifyProduct', {
                product_no: item.product_no,
                product_stock: item.product_stock,
                product_price: item.product_price,
                product_spec: item.product_spec
            }).then((res) => {
                if (res.data.result == true) {
                    alert('상품정보를 수정하였습니다.')
                    item.product_price = Number(res.data.resData.product_price.replaceAll(',','')).toLocaleString('ko-KR');//숫자데이터 자릿수 넣기용.
                    item.product_stock = res.data.resData.product_stock;
                    item.product_spec = res.data.resData.product_spec;
                    proxy.$log('[AddProduct] modifyClicked res: ', res.data);
                } else {
                    alert('수정 실패. 재시도해주세요.')
                    proxy.$log('[AddProduct] modifyClicked res: ', res.data);
                }

            }).catch((error) => {
                alert('통신-서버 오류. 재시도해주세요.')
                proxy.$log('[AddProduct] modifyClicked error: ', error.response.data);
            })
        }


        //input tag에 입력시 숫자의 자릿수를 , 로 구분하기위해 사용하는 함수
        function inputNumberFormat(obj) {
            obj.product_price = comma(uncomma(obj.product_price));
        }
        function comma(str) {
            str = String(str);
            return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
        }
        function uncomma(str) {
            str = String(str);
            return str.replace(/[^\d]+/g, '');
        }

        const checkBoxClicked = (item, $event) => {
            // if ($event.target.tagName == 'TR') {
            item.isDeleteChecked = $event.target.checked;
            //     $event.preventDefault();
            //     $event.stopPropagation();
            // }
            // return true;

        }


        return {
            ...toRefs(state), addStore,
            openState,
            modalState,
            searchType,
            search,
            passNoForUpdate,
            searchWord, rowClicked, modifyClicked, inputNumberFormat, checkBoxClicked, gotoClickedPage
        };
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

</style>