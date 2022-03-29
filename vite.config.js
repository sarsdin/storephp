import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()]//,
//   server:{
//       //빌드시 헤더에 서버 주소 추가
//       origin: 'http://192.168.112.128:80/'
//   }
})
