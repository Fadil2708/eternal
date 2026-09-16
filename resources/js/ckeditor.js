import { ClassicEditor } from '@ckeditor/ckeditor5-editor-classic';
import { Bold, Italic, Underline } from '@ckeditor/ckeditor5-basic-styles';
import { Heading } from '@ckeditor/ckeditor5-heading';
import { Link } from '@ckeditor/ckeditor5-link';
import { List } from '@ckeditor/ckeditor5-list';
import { BlockQuote } from '@ckeditor/ckeditor5-block-quote';
import { Alignment } from '@ckeditor/ckeditor5-alignment';
import { Undo } from '@ckeditor/ckeditor5-undo';
import { Paragraph } from '@ckeditor/ckeditor5-paragraph';

class CustomEditor extends ClassicEditor {}
CustomEditor.builtinPlugins = [
    Paragraph,
    Bold,
    Italic,
    Underline,
    Heading,
    Link,
    List,
    BlockQuote,
    Alignment,
    Undo
];

CustomEditor.defaultConfig = {
    toolbar: [
        'bold', 'italic', 'underline', '|',
        'heading', '|',
        'numberedList', 'bulletedList', '|',
        'blockQuote', 'link', '|',
        'alignment:left', 'alignment:center', 'alignment:right', '|',
        'undo', 'redo'
    ]
};

window.CKEDITOR = { ClassicEditor: CustomEditor };
