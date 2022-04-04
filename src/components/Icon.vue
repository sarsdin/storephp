<template>
  <div
    class="icon"
    :class="[`icon--${name1}`, `icon--${size}`, { 'has-align-fix': fixAlign }]"
  >
    <img :src="`src/assets/icons/${name1}.svg`" class="w-4" />
  </div>
</template>

<script>
export default {
    name: 'Icon',
  props: {
    name1: {
      type: String,
      default: '',
    },
    size: {
      type: String,
      default: 'normal',
    },
    modifier: {
      type: Object,
      default: null,
    },
    fixAlign: {
      type: Boolean,
      default: false,
    },
  },
  // created: function() {}
    setup(props) {
        const getImageUrl = () => {
            return `../assets/icons/${props.name1}.svg`;
        }

        return { getImageUrl }
    }
}
</script>

<style lang="scss" scoped> //상위 컴포넌트(Tiptap)에서 scss를 공유하는듯.. scope범위안에 드는듯
// @import "@/assets/sass/icon.scss";
// .icon {
//   position: relative;
//   width: 100px;
//   height: 100%;

//   &.has-align-fix {
//     top: -.1rem;
//   }
// }

</style>
