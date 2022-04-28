<template>
    <div>
        주문조회
    </div>
</template>

<script>
import { reactive, toRefs } from 'vue'

export default {
    name: 'OrderCheck',
    setup() {
        const state = reactive({
            count: 0,
        })
    
        return {
            ...toRefs(state),
        }
    }
}
</script>

<style lang="scss" scoped>

</style>