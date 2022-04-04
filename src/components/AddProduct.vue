<template>

<div class="flex flex-col w-full px-0">
    <div class="mt-5">
        <!-- 등록:
        <input type="text" placeholder="상품명" class="border-2">
        <input type="text" placeholder="가격" class="border-2">
        <input type="text" placeholder="재고수" class="border-2"> -->
        <input @click="addClicked = true" type="button" value="등록하기" class="p-1 border-2 rounded-md cursor-pointer focus:ring-1">
        <ProductModal v-model="addClicked">
            <ProductModalContent></ProductModalContent>
        </ProductModal>
    </div>
    
    <div class="overflow-x-auto shadow-md sm:rounded-md mt-10">
        <!-- 본문 -->
        <div class="inline-block min-w-full align-middle dark:bg-gray-800">
            <div class="overflow-hidden">
                <table class="min-w-full w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th v-show="true" scope="col" class="p-4 w-12">
                            <div class="flex items-center">
                                <input id="checkbox-search-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-search-all" class="sr-only">checkbox</label>
                            </div>
                        </th>
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
                            등록날짜
                        </th>
                        <th v-show="true" scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                            <span class="sr-only">Edit</span>수정
                        </th>
                    </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <!-- <router-link :to="{ name : 'noticeContent', params: { no: item.no } }"  class="w-full" > 이건 힘들지..css수정도 힘들고 -->
                        <tr v-for="item in addProduct" :key="item.no" @click="rowClicked(item)" class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <td v-show="true" class="p-4 w-4">
                                <div class="flex items-center">
                                    <input id="checkbox-search-1" type="checkbox"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th scope="col" class="py-3 px-3 w-16 text-xs font-medium tracking-wider text-center text-gray-700 uppercase dark:text-gray-400">
                                {{item.no}}
                            </th>
                            <td class="py-4 px-6 w-96 text-sm font-medium text-gray-900 whitespace-nowrap text-ellipsis overflow-hidden dark:text-white">
                                {{item.title}}
                            </td>
                            <td class="py-4 px-6 text-sm text-center font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                {{item.writer}}
                            </td>
                            <td class="py-4 px-6 text-sm text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{item.hit}}
                            </td>
                            <td class="py-4 px-6 text-sm text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{item.date}}
                            </td>
                            
                            <td v-show="true" class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
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
        
    </div>

</div>    

</template>

<script>
import { reactive, toRefs, ref } from 'vue'
import { useRouter } from 'vue-router'
import http from '../modules/http'
import ProductModal from './ProductModal.vue'
import ProductModalContent from './ProductModalContent.vue'

export default {
    name: 'AddProduct',
    components: { ProductModal, ProductModalContent },
    setup() {
        const addClicked = ref();
        const state = reactive({
            addProduct: [],
        });
        let search = ref(""); //글 검색창
        let searchType = ref("제목"); // 글검색종류
        const router = useRouter();
        //테스트용 목록
        http.get("/home/noticeT").then(res => {
            console.log("addProduct:res: ", res.data);
            state.addProduct = res.data;
        });
        //검색버튼 엔터시
        const searchWord = () => {
            // console.log("noticeSearch: ", noticeSearch.value);
            // console.log("noticeSearchType: ", noticeSearchType.value);
            http.get("/home/noticeSearch", {
                params: {
                    noticeSearch: search.value,
                    noticeSearchType: searchType.value
                }
            }).then(res => {
                console.log("searchRes :>> ", res.data);
                state.addProduct = res.data;
            });
        };
        return {
            ...toRefs(state),
            addClicked,
            searchType,
            search,
            searchWord
        };
    }
    
}
</script>

<style lang="scss" scoped>

</style>