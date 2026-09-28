{{--
    Rich text editor for any <textarea data-rich-editor>.

    Options (data attributes on the textarea):
      data-toolbar="basic"          smaller toolbar (default: full)
      data-height="480"             editor height in px
      data-upload-folder="blog"     where pasted / inserted images are stored

    TinyMCE is served from /vendor/tinymce (bundled with the site), so the
    editor never falls back to a plain textarea because a CDN was slow or blocked.
    It is configured to keep pasted formatting exactly: inline styles, colours,
    font sizes, alignment, lists, tables and images from Word, Google Docs,
    web pages and ChatGPT.
--}}
@once
    @push('scripts')
        <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
        <script>
            (() => {
                const textareas = document.querySelectorAll('textarea[data-rich-editor]');
                if (!textareas.length) return;

                if (!window.tinymce) {
                    textareas.forEach((textarea) => {
                        const warning = document.createElement('p');
                        warning.className = 'mt-2 text-xs font-medium text-red-600';
                        warning.textContent = 'The text editor could not load, so pasted formatting will not be kept. Reload the page before editing.';
                        textarea.insertAdjacentElement('afterend', warning);
                    });
                    return;
                }

                const uploadUrl = @json(route('admin.images.upload'));
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const fullToolbar = 'undo redo | blocks fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | removeformat code fullscreen';
                const basicToolbar = 'undo redo | bold italic underline | forecolor backcolor | alignleft aligncenter alignright | bullist numlist | link | removeformat code';

                textareas.forEach((textarea) => {
                    const basic = textarea.dataset.toolbar === 'basic';
                    const folder = textarea.dataset.uploadFolder || 'products/descriptions';

                    tinymce.init({
                        target: textarea,
                        base_url: @json(asset('vendor/tinymce')),
                        suffix: '.min',
                        height: parseInt(textarea.dataset.height || (basic ? '240' : '480'), 10),
                        menubar: false,
                        branding: false,
                        promotion: false,
                        statusbar: !basic,
                        convert_urls: false,
                        relative_urls: false,
                        plugins: basic
                            ? 'autolink lists link code'
                            : 'advlist autolink lists link image charmap anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount',
                        toolbar: basic ? basicToolbar : fullToolbar,
                        toolbar_mode: 'wrap',
                        block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4; Quote=blockquote',
                        font_size_formats: '12px 13px 14px 16px 18px 20px 24px 28px 32px',

                        // Keep pasted content exactly as copied.
                        paste_as_text: false,
                        paste_data_images: true,
                        paste_merge_formats: true,
                        paste_webkit_styles: 'all',
                        paste_remove_styles_if_webkit: false,
                        valid_elements: '*[*]',
                        extended_valid_elements: '*[*]',
                        invalid_elements: 'script,style,meta,link,title,base,object,embed,applet',
                        inline_styles: true,
                        keep_styles: true,

                        table_default_attributes: { border: '1' },
                        table_default_styles: { 'border-collapse': 'collapse', width: '100%' },
                        images_file_types: 'jpeg,jpg,png,webp',
                        automatic_uploads: true,
                        images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                            const formData = new FormData();
                            formData.append('image', blobInfo.blob(), blobInfo.filename());
                            formData.append('folder', folder);
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', uploadUrl);
                            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
                            xhr.upload.onprogress = (event) => event.lengthComputable && progress(event.loaded / event.total * 100);
                            xhr.onload = () => {
                                if (xhr.status < 200 || xhr.status >= 300) return reject('Image upload failed (' + xhr.status + ').');
                                try {
                                    const json = JSON.parse(xhr.responseText);
                                    json.url ? resolve(json.url) : reject('Image upload returned no URL.');
                                } catch (error) {
                                    reject('Invalid image upload response.');
                                }
                            };
                            xhr.onerror = () => reject('Image upload failed.');
                            xhr.send(formData);
                        }),

                        // Show text the way the website will show it.
                        content_css: 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Outfit:wght@600;700&display=swap',
                        content_style: `
                            body { font-family: 'Open Sans', Arial, sans-serif; font-size: 14px; line-height: 1.75; color: #656D78; margin: 14px; }
                            h1, h2, h3, h4 { font-family: 'Outfit', Arial, sans-serif; color: #252A32; line-height: 1.3; }
                            strong, b { color: #252A32; }
                            a { color: #075FB8; }
                            table { border-collapse: collapse; }
                            table:not([border="0"]) th, table:not([border="0"]) td { border: 1px solid #d4d4d8; padding: 6px 10px; }
                            img { max-width: 100%; height: auto; }
                        `,

                        setup: (editor) => {
                            editor.on('change input undo redo SetContent', () => editor.save());
                        },
                    });
                });

                document.querySelectorAll('form').forEach((form) => {
                    if (form.querySelector('textarea[data-rich-editor]')) {
                        form.addEventListener('submit', () => tinymce.triggerSave());
                    }
                });
            })();
        </script>
    @endpush
@endonce
