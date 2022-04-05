<template>

<div class="relative max-w-screen-xl px-4 py-8 mx-auto">
    <!-- 헤더 -->
    <div>
        <h1 class="text-2xl font-bold lg:text-3xl">
            상품등록
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
                <label for="ifile">
                    <img alt="" :src="ifileC" class="w-fit rounded-xl h-72 lg:h-[450px] object-contain" />
                    <!-- <div class="w-full rounded-xl h-72 lg:h-[450px] object-cover" >{{ this.$refs.ifiles.value }}</div> -->
                </label>
                <input type="file" class="hidden" @change="ifile = $event.target.files" multiple accept="image/png, image/jpeg, image/gif" name="file" id="ifile">
                <!-- <input type="text" class="" ref="ifiles" name="file" id="ifile" value="testestesstesalkjsflkjsldkgjsldkgjlgjlkjgalksjfdalkj/n sakfdjksdfj"> -->
            </div>
        </div>

        <div class="lg:top-0 lg:sticky">
        <form class="space-y-1 lg:pt-0">
            <!-- 상단 동그라미 -->
            <fieldset>
                <legend class="text-lg font-bold">
                상품명
                </legend>

                <div class="flex mt-0 space-x-1">
                    <!-- <label for="color_green" class="cursor-pointer">
                        <input type="radio" id="color_green" name="color" class="sr-only peer" checked />
                        <span class="block w-6 h-6 bg-green-700 border border-gray-200 rounded-full ring-1 ring-offset-1 ring-transparent peer-checked:ring-gray-300"></span>
                    </label> -->
                </div>
            </fieldset>
            <input type="text" class="w-full px-4 bg-gray-100 border rounded">

            <div class="text-lg font-bold">카테고리</div>
            <!-- <input type="number" class="w-full px-4 bg-gray-100 border rounded"> -->
            <select name="category" class="w-full px-4 bg-gray-100 border rounded">
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
            <input type="number" value="0" class="w-full px-4 bg-gray-100 border rounded" />

            <div class="text-lg font-bold">SPEC</div>
            <div class="px-4 bg-gray-100 border rounded">
                <input type="text" class="w-full px-4 bg-gray-100 border rounded" placeholder="규격" />
                <!-- <p class="text-sm">
                    <span class="block">
                    </span>
                </p> -->
            </div>

            <div>
                <p class="text-xl font-bold mb-2">가격</p>
                <input type="number" value="1000" class="w-full px-4 bg-gray-100 border rounded"/>
            </div>

            <hr>
            <button type="submit" class="w-full px-6 py-3 text-sm font-bold tracking-wide text-white uppercase bg-red-700 rounded">
                상품등록
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

                <ul>
                    <li>특징1</li>
                    <li>특징2</li>
                    <li>특징3</li>
                    <li>특징4</li>
                </ul> -->

            <!-- <iframe src="https://www.youtube-nocookie.com/embed/Eb-Vfe61W6A?controls=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
            </div>
        </div>

    </div><!--본문끝-->
</div>

</template>

<script>
import { reactive, ref, toRefs } from 'vue'
import Tiptap from './Tiptap.vue'
import Qeditor from './Qeditor.vue'
import { computed } from '@vue/reactivity';

export default {
    name: "ProductModalContent",
    components: { Qeditor },
    setup() {
        // const editorContent = ref();
        const editor = ref('');
        const ifile = ref({})
        const ifileC = computed(() => {
            console.log("ifile: ", ifile.value);
            if(ifile.value[0] != null) {
                console.log("ifile not null: ", ifile.value);
                return URL.createObjectURL(ifile.value[0]);
            }
        })
        // editorContent.value = '<p>A Vue.js wrapper component for tiptap to use <code>v-model</code>.</p>';

        return {
            // editorContent, 
            editor, ifile, ifileC
        };
    },
    // data() {
    //     return {
    //         editorContent: '<p>A Vue.js wrapper component for tiptap to use <code>v-model</code>.</p>',
    //     }
    // },
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