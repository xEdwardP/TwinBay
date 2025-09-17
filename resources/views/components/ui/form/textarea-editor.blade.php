<div class="editor-wrapper">
    <textarea id="description" name="description"></textarea>
</div>

<style>
    .ck.ck-editor {
        width: 100% !important;
    }

    .ck-editor__editable {
        width: 100% !important;
        min-height: 300px;
        box-sizing: border-box;
    }

    .ck.ck-toolbar {
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .ck-editor__editable {
            min-height: 250px;
            padding: 10px;
        }
    }
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|',
                    'link', 'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'alignment', '|',
                    'blockQuote', 'insertTable', 'mediaEmbed', '|',
                    'undo', 'redo', '|',
                    'fontBackgroundColor', 'fontColor', 'fontSize', 'fontFamily', '|',
                    'code', 'codeBlock', 'htmlEmbed', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            language: 'es'
        })
        .then(editor => {
            // Forzar responsive después de crear el editor
            const editorEl = editor.ui.view.element;
            editorEl.style.width = '100%';
            editorEl.querySelector('.ck-editor__editable').style.width = '100%';
        })
        .catch(error => {
            console.error(error);
        });
</script>
