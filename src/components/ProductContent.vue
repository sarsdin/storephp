<template>

<div class="relative max-w-screen-xl px-4 py-8 mx-auto">
    <div>
        <h1 class="text-2xl font-bold lg:text-3xl">
            상품명
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            카테고리: 카테고리명
        </p>
    </div>

    <div class="grid gap-8 lg:items-start lg:grid-cols-4">
        <div class="lg:col-span-3">
            <div class="relative mt-4">
                <img alt="" src="../../photos/tee-green-hanger.png" class="w-full rounded-xl h-72 lg:h-[450px] object-cover" />
                <!-- 확대버튼 -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 rounded-full bg-black/75 text-white px-3 py-1.5 inline-flex items-center">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                    <span class="text-xs ml-1.5">
                    확대
                    </span>
                </div>
            </div>

        <!-- <ul class="flex gap-1 mt-1">
          <li>
            <img class="object-cover w-16 h-16 rounded-md" src="../../photos/tee-green-hanger-2.png" alt="" />
          </li>

          <li>
            <img class="object-cover w-16 h-16 rounded-md" src="../../photos/tee-green-hanger-3.png" alt="" />
          </li>

          <li>
            <img class="object-cover w-16 h-16 rounded-md" src="../../photos/tee-green-person.png" alt="" />
          </li>

          <li>
            <img class="object-cover w-16 h-16 rounded-md" src="../../photos/tee-green-person-2.png" alt="" />
          </li>
        </ul> -->
        </div>

      <div class="lg:top-0 lg:sticky">
        <form class="space-y-4 lg:pt-8">
            <!-- 상단 동그라미 -->
            <fieldset>
                <legend class="text-lg font-bold">
                Color
                </legend>

                <div class="flex mt-2 space-x-1">
                    <label for="color_green" class="cursor-pointer">
                        <input type="radio" id="color_green" name="color" class="sr-only peer" checked />
                        <span class="block w-6 h-6 bg-green-700 border border-gray-200 rounded-full ring-1 ring-offset-1 ring-transparent peer-checked:ring-gray-300"></span>
                    </label>

                    <label for="color_blue" class="cursor-pointer">
                        <input type="radio" id="color_blue" name="color" class="sr-only peer" />
                        <span class="block w-6 h-6 bg-blue-700 border border-gray-200 rounded-full ring-1 ring-offset-1 ring-transparent peer-checked:ring-gray-300"></span>
                    </label>

                    <label for="color_pink" class="cursor-pointer">
                        <input type="radio" id="color_pink" name="color" class="sr-only peer" />
                        <span class="block w-6 h-6 bg-pink-700 border border-gray-200 rounded-full ring-1 ring-offset-1 ring-transparent peer-checked:ring-gray-300"></span>
                    </label>

                    <label for="color_red" class="cursor-pointer">
                        <input type="radio" id="color_red" name="color" class="sr-only peer" />
                        <span class="block w-6 h-6 bg-red-700 border border-gray-200 rounded-full ring-1 ring-offset-1 ring-transparent peer-checked:ring-gray-300"></span>
                    </label>

                    <label for="color_indigo" class="cursor-pointer">
                        <input type="radio" id="color_indigo" name="color" class="sr-only peer" />
                        <span class="block w-6 h-6 bg-indigo-700 border border-gray-200 rounded-full ring-1 ring-offset-1 ring-transparent peer-checked:ring-gray-300"></span>
                    </label>
                </div>
            </fieldset>

            <fieldset>
                <legend class="text-lg font-bold">
                개수
                </legend>

                <div class="flex mt-2 space-x-1">
                    <label for="material_cotton" class="cursor-pointer">
                        <input type="radio" id="material_cotton" name="material" class="sr-only peer" checked />
                        <span class="block px-3 py-1 text-xs border border-gray-200 rounded-full peer-checked:bg-gray-100">
                        종류
                        </span>
                    </label>

                    <label for="material_wool" class="cursor-pointer">
                        <input type="radio" id="material_wool" name="material" class="sr-only peer" checked />
                        <span class="block px-3 py-1 text-xs border border-gray-200 rounded-full peer-checked:bg-gray-100">
                        종류2
                        </span>
                    </label>
                </div>
            </fieldset>

            <div class="p-4 bg-gray-100 border rounded">
                <p class="text-sm">
                <span class="block">
                    간단 설명들
                </span>

                <a href="" class="inline-block mt-1 underline">
                    부연설명
                </a>
                </p>
            </div>

            <div>
                <p class="text-xl font-bold">가격 1,000원</p>
            </div>

            <button type="submit" class="w-full px-6 py-3 text-sm font-bold tracking-wide text-white uppercase bg-red-700 rounded">
                상품등록
            </button>

            <button type="button" class="w-full px-6 py-3 text-sm font-bold tracking-wide uppercase bg-gray-100 border border-gray-300 rounded" >
                알림처리
            </button>
        </form>
        </div>

        <div class="lg:col-span-3">
            <div class="prose max-w-none">
                <p><b>내용</b></p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi eveniet ipsam mollitia nesciunt illo! Suscipit, corrupti!</p>
                <br><br>
                <h3>부연</h3>

                <ul>
                    <li>특징1</li>
                    <li>특징2</li>
                    <li>특징3</li>
                    <li>특징4</li>
                </ul>

            <!-- <iframe src="https://www.youtube-nocookie.com/embed/Eb-Vfe61W6A?controls=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
            </div>
        </div>
    </div>
</div>

</template>

<script>
import { ref } from 'vue'

export default {
    name: 'ProductContent',
    setup () {
        let dkf = ref('');

        return {}
    }
}
</script>

<style scoped>
  .prose h3 {
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgb(243 244 246);

    /* @apply mb-1 pb-2 border-b border-gray-200; */
  }

  .prose iframe {
    width: 100%;
    margin-top: 1.5rem;
    aspect-ratio: 16 / 9;
    border-radius: 0.75rem;

    /* @apply w-full aspect-video mt-6 rounded-xl; */
  }
</style>