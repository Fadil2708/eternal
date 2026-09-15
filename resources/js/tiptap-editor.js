import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import TextAlign from '@tiptap/extension-text-align'
import Link from '@tiptap/extension-link'
import HorizontalRule from '@tiptap/extension-horizontal-rule'
import Placeholder from '@tiptap/extension-placeholder'

const extensions = [
    StarterKit.configure({ heading: { levels: [2, 3] } }),
    Underline,
    TextAlign.configure({ types: ['heading', 'paragraph'] }),
    Link.configure({ openOnClick: false, HTMLAttributes: { class: 'tiptap-link' } }),
    HorizontalRule,
    Placeholder.configure({ placeholder: 'Tulis konten di sini...' }),
]

window.createTipTapEditor = (element, content, onUpdate) => {
    if (!element) return null
    return new Editor({
        element,
        content: content || '',
        extensions,
        onUpdate: ({ editor }) => onUpdate(editor.getHTML()),
        editorProps: { attributes: { class: 'tiptap-content' } },
    })
}

window.tiptapField = (fieldKey) => ({
    ed: null,

    init() {
        this.$nextTick(() => {
            const initial = this[fieldKey] || ''
            this.ed = window.createTipTapEditor(
                this.$refs.editor,
                initial,
                (html) => { this[fieldKey] = html }
            )
        })
    },

    destroy() { this.ed?.destroy() },

    focus() { this.ed?.chain().focus().run() },

    toggleBold() { this.ed?.chain().focus().toggleBold().run() },
    toggleItalic() { this.ed?.chain().focus().toggleItalic().run() },
    toggleUnderline() { this.ed?.chain().focus().toggleUnderline().run() },
    toggleOrderedList() { this.ed?.chain().focus().toggleOrderedList().run() },
    toggleBulletList() { this.ed?.chain().focus().toggleBulletList().run() },
    toggleHeading(level) { this.ed?.chain().focus().toggleHeading({ level }).run() },
    toggleBlockquote() { this.ed?.chain().focus().toggleBlockquote().run() },

    setLink() {
        const url = window.prompt('URL:')
        if (url === null) return
        if (url === '') {
            this.ed?.chain().focus().extendMarkRange('link').unsetLink().run()
            return
        }
        this.ed?.chain().focus().extendMarkRange('link').setLink({ href: url }).run()
    },

    setTextAlign(align) { this.ed?.chain().focus().setTextAlign(align).run() },
    setHorizontalRule() { this.ed?.chain().focus().setHorizontalRule().run() },

    isActive(name, attrs) { return this.ed?.isActive(name, attrs) ?? false },
})
