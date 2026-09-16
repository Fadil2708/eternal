import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import TextAlign from '@tiptap/extension-text-align'
import Link from '@tiptap/extension-link'

window.createTiptapEditor = function (element, content, onUpdate) {
    return new Editor({
        element,
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
        content: content || '',
        editorProps: {
            attributes: {
                class: 'tiptap-content',
            },
        },
        onUpdate: ({ editor }) => {
            if (onUpdate) onUpdate(editor.getHTML())
        },
    })
}
