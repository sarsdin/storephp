const method = {
    consoleLog(str, target){
        console.log(str, target)
    }
}

export default {
    install(Vue){
        Vue.config.globalProperties.$log = method.consoleLog;
    }
}