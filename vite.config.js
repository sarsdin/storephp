import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { quasar, transformAssetUrls } from '@quasar/vite-plugin'
import path from 'path'

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue({
        template: { transformAssetUrls }    //퀘이사 적용부분
      }),
  
      quasar({
        autoImportComponentCase: 'combined',
        sassVariables: 'src/quasar-variables.sass'
      })]//,
    //   server:{
        //       //빌드시 헤더에 서버 주소 추가
        //       origin: 'http://192.168.112.128:80/'
        //   }
    ,
    resolve:{   //경로 별칭 적용부분
        alias:{
            '@' : path.resolve(__dirname, './src'),
            '@components' : path.resolve(__dirname, './src/components')
        },
    },
})
    
// // const path = require('path')
// module.exports = {
//     alias: {
//         '/@/': path.resolve(__dirname, './src'),

//     }
// }