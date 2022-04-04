<template>
 <div v-if="editor" class="border px-2 space-x-4">
    <button @click="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }">
        <font-awesome-icon :icon="['fas', 'bold']" class="mx-1 text-slate-700"></font-awesome-icon>
    </button>
    <button @click="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }">
        <font-awesome-icon :icon="['fas', 'italic']" class="mx-1 text-slate-700"></font-awesome-icon>
    </button>
    <button @click="editor.chain().focus().toggleStrike().run()" :class="{ 'is-active': editor.isActive('strike') }">
        <font-awesome-icon :icon="['fas', 'strikethrough']" class="mx-1 text-slate-700"></font-awesome-icon>
    </button>
    <!-- <button @click="editor.chain().focus().toggleUnderline().run()" :class="{ 'is-active': editor.isActive('underline') }">
        <icon name="underline" />
    </button> -->
    <button @click="editor.chain().focus().toggleCode().run()" :class="{ 'is-active': editor.isActive('code') }">
        <font-awesome-icon :icon="['fas', 'code']" class="mx-1 text-slate-700"></font-awesome-icon>
    </button>
    <button @click="editor.chain().focus().unsetAllMarks().run()">
        <font-awesome-icon :icon="['fas', 'remove']" class="mx-1 text-slate-700"></font-awesome-icon>
    </button>
    <button @click="editor.chain().focus().clearNodes().run()">
        <font-awesome-icon :icon="['fas', 'ban']" class="mx-1 text-slate-700"></font-awesome-icon>
    </button>
    <button @click="editor.chain().focus().setParagraph().run()" :class="{ 'is-active': editor.isActive('paragraph') }">
        <font-awesome-icon :icon="['fas', 'paragraph']" class="mx-1 text-slate-700"></font-awesome-icon>
    </button>
    <button @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }">
        H1
    </button>
    <button @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }">
        H2
    </button>
    <button @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }">
        H3
    </button>
  
    <button @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'is-active': editor.isActive('bulletList') }">
        <icon name1="ul"></icon>
    </button>
    <button @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'is-active': editor.isActive('orderedList') }">
        <icon name1="ol"></icon>
    </button>
    <button @click="editor.chain().focus().toggleCodeBlock().run()" :class="{ 'is-active': editor.isActive('codeBlock') }">
        <icon name1="code"></icon>
    </button>
    <button @click="editor.chain().focus().toggleBlockquote().run()" :class="{ 'is-active': editor.isActive('blockquote') }">
        <icon name1="quote"></icon>
    </button>
    <button @click="editor.chain().focus().setHorizontalRule().run()">
        <icon name1="hr"></icon>
    </button>
    <!-- <button @click="editor.chain().focus().setHardBreak().run()">
        <icon name1="hard break"></icon>
    </button> -->
    <button @click="editor.chain().focus().undo().run()">
        <icon name1="undo"></icon>
    </button>
    <button @click="editor.chain().focus().redo().run()">
        <icon name1="redo"></icon>
    </button>
  </div>

  <!-- 에디터 내용 -->
  <editor-content :editor="editor" class="p-2 min-h-[250px] max-h-fit border" />
</template>

<script>
import { watch, computed } from "vue";
import { useEditor, Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Icon from "./Icon.vue";

export default {
    components: {
        EditorContent, //== editor-content
        Icon
    },
    props: {
        modelValue: {
            type: String,
            default: '',
        },
    },
    //   emits: ['update:modelValue'],

    setup(props,context) {
        
        const tiptapContentComputed = computed({
            get: () => {
                return props.modelValue;    //computed : 받아온 props에 변화를 감지하도록 반응성을 입혀준다.
            },
            set: (v) => {
            }
        })
        
        const editor = useEditor({                  // useEditor명령을 이용해 editor 객체 만듦
            content: tiptapContentComputed.value,   //내용에 들어갈 값을 props를 처리한 coumputed의 getter로 받아옴
            extensions: [
                StarterKit.configure({              //기본 확장 적용
                    heading: {
                        levels: [1, 2, 3],
                    },
                }),
            ],
            onUpdate: ({editor}) => {               //editor 내장 메소드를 이용해 변화를 감지하고 상위 컴포넌트의 v-model에 현재값을 emit해준다.
                context.emit('update:modelValue', editor.getHTML());    //메소드의 인자로 {}안의 editor속성을 받는 것에 유의!
                // context.emit("update:modelValue", { html: editor.getHTML(), json: editor.getJSON() });
            }
        })


        // props를 watch하기위해서는 에로우함수로 한번 감싸준다. 현재 editor의 값과 변화된 props의 새로운값이 같다면 그냥 종료하고, 아니면 새값으로 설정한다
        watch(() => props.modelValue, (newValue, oldValue) => {
            const isSame = editor.value.getHTML() === newValue;
            if (isSame) {
                return
            }
            editor.value.commands.setContent(newValue, false);  //새값 설정 메소드. editor의 타입이 ShallowRef이기에 .value를 잊지말자!
        })

        return { editor }
    },
}


</script>

<style lang="scss" scoped>
// @import "@/assets/sass/main.scss";
// /* Basic editor styles */
// .ProseMirror {
//   > * + * {
//     margin-top: 0.75em;
//   }

//   ul,
//   ol {
//     padding: 0 1rem;
//   }

//   h1,
//   h2,
//   h3,
//   h4,
//   h5,
//   h6 {
//     line-height: 1.1;
//   }

//   code {
//     background-color: rgba(#616161, 0.1);
//     color: #616161;
//   }

//   pre {
//     background: #0D0D0D;
//     color: #FFF;
//     font-family: 'JetBrainsMono', monospace;
//     padding: 0.75rem 1rem;
//     border-radius: 0.5rem;

//     code {
//       color: inherit;
//       padding: 0;
//       background: none;
//       font-size: 0.8rem;
//     }
//   }

//   img {
//     max-width: 100%;
//     height: auto;
//   }

//   blockquote {
//     padding-left: 1rem;
//     border-left: 2px solid rgba(#0D0D0D, 0.1);
//   }

//   hr {
//     border: none;
//     border-top: 2px solid rgba(#0D0D0D, 0.1);
//     margin: 2rem 0;
//   }
// }
</style>


<!-- export default {
  components: {
    EditorContent,
  },

  props: {
    modelValue: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      editor: null,
    }
  },

  watch: {
    modelValue(value) {
      // HTML
      const isSame = this.editor.getHTML() === value

      // JSON
      // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)

      if (isSame) {
        return
      }

      this.editor.commands.setContent(value, false)
    },
  },

  mounted() {
    this.editor = new Editor({
      extensions: [
        StarterKit,
      ],
      content: this.modelValue,
      onUpdate: () => {
        // HTML
        this.$emit('update:modelValue', this.editor.getHTML())

        // JSON
        // this.$emit('update:modelValue', this.editor.getJSON())
      },
    })
  },

  beforeUnmount() {
    this.editor.destroy()
  },
} -->
