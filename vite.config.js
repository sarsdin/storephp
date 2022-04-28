import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { quasar, transformAssetUrls } from '@quasar/vite-plugin'
import path from 'path'
// import mkcert from 'vite-plugin-mkcert'

// https://vitejs.dev/config/


export default defineConfig({
    plugins: [
        vue({
            template: { transformAssetUrls }    
        }),
        quasar({                //퀘이사 적용부분
            autoImportComponentCase: 'combined',
            sassVariables: 'src/quasar-variables.sass'
        }),
        // mkcert()
    ],
    
    server : {
        // https: true
        //빌드시 헤더에 서버 주소 추가
        //   origin: 'http://192.168.112.128:80/'
        port:3000,
        proxy: {
            '/index.php': {
                target: 'http://192.168.112.128:80',
                changeOrigin: true,
                secure: false,
            },
            '/api': {
                target: 'http://192.168.112.128:80/home/isSession',
                changeOrigin: true,
                // secure: false,
                rewrite: (path) => path.replace(/^\/api/, '')
            },
            '/': {
                target: 'http://192.168.112.128:80',
                changeOrigin: true,
                secure: false,
            },
            // '/': 'http://192.168.112.128'
        }
    },

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