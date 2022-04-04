<template>

<div class="relative max-w-screen-xl px-4 py-8 mx-auto">
    <div>
        <h1 class="text-2xl font-bold lg:text-3xl">
            상품등록
        </h1>
        <!-- <p class="mt-1 text-sm text-gray-500">
            카테고리: 카테고리명
        </p> -->
    </div>

    <div class="grid gap-8 lg:items-start lg:grid-cols-4">
        <div class="lg:col-span-3">
            <div class="relative mt-4">
                <img alt="" src="../../photos/tee-green-hanger.png" class="w-full rounded-xl h-72 lg:h-[450px] object-cover" />
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
                    <option value="gg">라면즉석식품</option>
                    <option value="gg">커피음료</option>
                    <option value="gg">생활잡화</option>
                </optgroup>
                <optgroup label="커피음료">
                    <option value="gg">라면즉석식품</option>
                    <option value="gg">커피음료</option>
                    <option value="gg">생활잡화</option>
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
    </div>
</div>

</template>

<script>
import { reactive, ref, toRefs } from 'vue'
import Tiptap from './Tiptap.vue'
import Qeditor from './Qeditor.vue'

export default {
    name: "ProductModalContent",
    setup() {
        const editorContent = ref();
        const editor = ref('');
        // editorContent.value = '<p>A Vue.js wrapper component for tiptap to use <code>v-model</code>.</p>';

        return {
            editorContent, editor
        };
    },
    components: { Qeditor },
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