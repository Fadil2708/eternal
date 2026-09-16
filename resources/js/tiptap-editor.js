import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import TextAlign from '@tiptap/extension-text-align'
import Link from '@tiptap/extension-link'

window.setupEditor = function (content) {
    let editor
    return {
        content: content,
        init(element) {
            editor = new Editor({
                element: element,
                extensions: [
                    StarterKit.configure({
                        heading: { levels: [1, 2, 3] },
                    }),
                    TextAlign.configure({
                        types: ['heading', 'paragraph'],
                    }),
                    Link.configure({
                        openOnClick: false,
                        HTMLAttributes: { class: 'tiptap-link' },
                    }),
                ],
                content: this.content,
                editorProps: {
                    attributes: {
                        class: 'tiptap-content',
                    },
                },
                onUpdate: ({ editor: e }) => {
                    this.content = e.getHTML()
                },
            })

            this.$watch('content', (val) => {
                if (val === editor.getHTML()) return
                editor.commands.setContent(val, false)
            })
        },
    }
}
