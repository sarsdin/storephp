const method = {
    consoleLog(str, target){
        console.log(str, target)
    }
}

export default {
    install(Vue){   //app.use(이모듈)을 사용했을 때 app을 인자로 받아서 실행하는듯
        Vue.config.globalProperties.$log = method.consoleLog;
    }
}