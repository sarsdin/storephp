<template>

<!-- <div class="w-full"> -->
    <!-- <q-editor
        model-value="v-model='content'"
        :readonly="false"
        :square="false"
        :flat="false"
        :dense="false"
        :dark="false"
        :disable="false"
        min-height="10rem"
        max-height="1000px"
        height="100px"
        definitions=":definitions="{ save: { tip: 'Save your work', icon: 'save', label: 'Save', handler: saveWork }, upload: { tip: 'Upload to cloud', icon: 'cloud_upload', label: 'Upload', handler: uploadIt } }""
        fonts=":fonts="{ arial: 'Arial', arial_black: 'Arial Black', comic_sans: 'Comic Sans MS' }""
        :toolbar="[]"
        :toolbar-color="null"
        :toolbar-text-color="null"
        toolbar-toggle-color="primary"
        toolbar-bg="grey-3"
        :toolbar-outline="false"
        :toolbar-push="false"
        :toolbar-rounded="false"
        paragraph-tag="div"
        content-style=":content-style="{ backgroundColor: '#C0C0C0' }""
        content-class="my-special-class"
        placeholder="Type your story here ..."
        :fullscreen="false"
        :no-route-fullscreen-exit="false"
        @update:model-value="null"
    /> -->
    <q-editor
    v-model="qEditorComputed"
    ref="editorRef"
    placeholder="내용을 입력해주세요."
    @paste.native="evt => pasteCapture(evt)"
    :toolbar="[
        // ['token'],
        ['bold', 'italic', 'underline', 'strike'],
        [{
        label: $q.lang.editor.formatting,
        icon: $q.iconSet.editor.formatting,
        list: 'no-icons',
        options: ['p', 'h3', 'h4', 'h5', 'h6', 'code']
        },
        {
            label: $q.lang.editor.align,
            icon: $q.iconSet.editor.align,
            fixedLabel: true,
            list: 'only-icons',
            options: ['left', 'center', 'right', 'justify']
        },
        {
            label: $q.lang.editor.fontSize,
            icon: $q.iconSet.editor.fontSize,
            fixedLabel: true,
            fixedIcon: true,
            list: 'no-icons',
            options: [
              'size-1',
              'size-2',
              'size-3',
              'size-4',
              'size-5',
              'size-6',
              'size-7'
            ]
        },
        {
        label: $q.lang.editor.defaultFont,
        icon: $q.iconSet.editor.font,
        fixedIcon: true,
        list: 'no-icons',
        options: [
            'default_font',
            'arial',
            'arial_black',
            'comic_sans',
            'courier_new',
            'impact',
            'lucida_grande',
            'times_new_roman',
            'verdana'
        ]
        },
        'removeFormat'
        ],
        ['quote', 'unordered', 'ordered', 'outdent', 'indent'],
        ['undo'],
        
    ]"
    :fonts="{
        arial: 'Arial',
        arial_black: 'Arial Black',
        comic_sans: 'Comic Sans MS',
        courier_new: 'Courier New',
        impact: 'Impact',
        lucida_grande: 'Lucida Grande',
        times_new_roman: 'Times New Roman',
        verdana: 'Verdana'
      }"
    >
    <!-- <template v-slot:token>
        <q-btn-dropdown
        dense no-caps
        ref="tokenRef"
        no-wrap
        unelevated
        label="Token"
        size="sm"
        >
            <q-list dense>
                <q-item tag="label" clickable @click="add('email')">
                    <q-item-section side>
                        <q-icon name="mail" />
                    </q-item-section>
                    <q-item-section>Email</q-item-section>
                </q-item>

                <q-item tag="label" clickable @click="add('title')">
                    <q-item-section side>
                        <q-icon name="title" />
                    </q-item-section>
                    <q-item-section>Title</q-item-section>
                </q-item>
            </q-list>
        </q-btn-dropdown>
    </template> -->
    
    </q-editor>
<!-- </div> -->

</template>

<script>
import { ref, computed } from 'vue'

export default {
    name : 'Qeditor',
    props : ['modelValue'],
    emits : ['update:modelValue'],
    setup (props, context) {
        const editorRef = ref(null)
        const tokenRef = ref(null)
        const editor = ref('Customize it.')

        const qEditorComputed = computed({
                get: () => {
                    return props.modelValue;    //computed : 받아온 props에 변화를 감지하도록 반응성을 입혀준다.
                },
                set: (value) => {
                    context.emit('update:modelValue', value)
                }
            })

        return {
            editorRef,
            tokenRef,
            editor,

            add (name) {
                const edit = editorRef.value
                tokenRef.value.hide()
                edit.caret.restore()
                edit.runCmd('insertHTML', `&nbsp;<div class="bg-slate-300 editor_token row inline items-center" contenteditable="false">&nbsp;<span>${name}</span>&nbsp;<i class="q-icon material-icons cursor-pointer" onclick="this.parentNode.parentNode.removeChild(this.parentNode)">close</i></div>&nbsp;`)
                edit.focus()
            },
            qEditorComputed
        }
    }
}

</script>

<style lang="scss" scoped>

</style>