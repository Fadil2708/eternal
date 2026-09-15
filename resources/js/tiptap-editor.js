import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import TextAlign from '@tiptap/extension-text-align'
import Link from '@tiptap/extension-link'
import HorizontalRule from '@tiptap/extension-horizontal-rule'
import Placeholder from '@tiptap/extension-placeholder'

window.tiptapEditor = () => ({
    editor: null,

    init() {
        const content = this.description || this.qualifications || ''

        this.editor = new Editor({
            element: this.$refs.editor,
            extensions: [
                StarterKit.configure({
                    heading: { levels: [2, 3] },
                }),
                Underline,
                TextAlign.configure({
                    types: ['heading', 'paragraph'],
                }),
                Link.configure({
                    openOnClick: false,
                    HTMLAttributes: { class: 'tiptap-link' },
                }),
                HorizontalRule,
                Placeholder.configure({
                    placeholder: 'Tulis konten di sini...',
                }),
            ],
            content,
            onUpdate: ({ editor }) => {
                const html = editor.getHTML()
                if ('description' in this) this.description = html
                if ('qualifications' in this) this.qualifications = html
            },
            editorProps: {
                attributes: {
                    class: 'tiptap-content',
                },
            },
        })

        this.$nextTick(() => {
            if (content && content !== '<p></p>') {
                this.editor.commands.setContent(content)
            }
        })
    },

    toggleBold() { this.editor.chain().focus().toggleBold().run() },
    toggleItalic() { this.editor.chain().focus().toggleItalic().run() },
    toggleUnderline() { this.editor.chain().focus().toggleUnderline().run() },
    toggleOrderedList() { this.editor.chain().focus().toggleOrderedList().run() },
    toggleBulletList() { this.editor.chain().focus().toggleBulletList().run() },
    toggleHeading(level) { this.editor.chain().focus().toggleHeading({ level }).run() },
    toggleBlockquote() { this.editor.chain().focus().toggleBlockquote().run() },

    setLink() {
        const url = window.prompt('URL:')
        if (url === null) return
        if (url === '') {
            this.editor.chain().focus().extendMarkRange('link').unsetLink().run()
            return
        }
        this.editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run()
    },

    setTextAlign(align) { this.editor.chain().focus().setTextAlign(align).run() },
    setHorizontalRule() { this.editor.chain().focus().setHorizontalRule().run() },
    isActive(name, attrs) { return this.editor.isActive(name, attrs) },

    destroy() {
        if (this.editor) this.editor.destroy()
    },
})
