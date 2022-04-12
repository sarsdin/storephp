<template>
    <div class="flex justify-between">
        <span>장바구니</span>
        <span>장바구니</span>
    </div>
</template>

<script>
import { reactive, toRefs } from 'vue'


export default {
    name: 'Cart',

    setup () {
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