import SketchEngine from '../SketchEngine/SketchEngine.js';


export default class BackArticlesController extends SketchEngine {
        
    constructor() {
        super();
        this.variables.baseurl = arguments[0].baseurl;
    }

    
    variables = {};


    execute = [
        'tinymceEditorInit'
    ];


    components = [];


    selectors = {
        tinyarea: '.tinymce-editalbe-area',
        categorySelect: '.svp-category-select',
        thumbPrev: '.svp-thumbnail-review',
        thumbInput: '.svp-thumbnail-input',
        removeThumb: '.svp-remove-thumbnail'
    };


    html = {}


    catchDOM() {}


    bindEvents() {
        this.lib('body').on('change', this.functions.previewThumb.bind(this), this.selectors.thumbInput);
        this.lib(this.selectors.removeThumb).on('click', this.functions.removeThumb.bind(this));
    }


    functions = {
        
        removeThumb(e) {
            e.preventDefault();
            const img = `${this.variables.baseurl}/assets/images/not-found.png`;
            const hidden = document.querySelector('input[name=thumbnail_hidden]');
            document.querySelector(this.selectors.thumbPrev).setAttribute('src', img);
            document.querySelector(this.selectors.thumbInput).value = null;
            if (hidden) hidden.value = null;
        },
        
        
        previewThumb(e) {
            e.preventDefault();
            
            const chooseFile = document.querySelector(this.selectors.thumbInput);
            const imgPreview = document.querySelector(this.selectors.thumbPrev);
            const files = chooseFile.files[0];
            
            if (files) {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(files);
                fileReader.addEventListener("load", function () {
                    imgPreview.src = this.result;
                });    
            }
            
            console.log(e.target.value);
        },
        
        
        tinymceEditorInit() {
            
            window.tinyeditorPath = this.variables.baseurl + '/assets/tinyeditor';
            
            tinymce.init({
                selector: this.selectors.tinyarea,
                promotion: false,
                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                toolbar_sticky: true,
                paste_as_text: true,
                file_picker_callback: (callback, value, meta) => {
                    /* Provide file and text for the link dialog */
                    if (meta.filetype === 'file') {
                        filemanager(file => {
                            let fl = file[0].replace(/\//, '').split('files/')[1];
                            fl = `%RELEVANT_PATH%${fl}`
                            callback(fl, { text: 'My text' });
                        });
                    }

                    /* Provide image and alt text for the image dialog */
                    if (meta.filetype === 'image') {
                        filemanager(file => {
                            let fl = this.variables.baseurl + file[0];
                            const imageName = decodeURI(fl.split('/').reverse()[0].replace(/\.\w{3,4}/, ''));
                            callback(decodeURI(fl), { alt: imageName });
                        });
                    }

                    /* Provide alternative source and posted for the media dialog */
                    if (meta.filetype === 'media') {
                        filemanager(file => {
                            let fl = file[0].replace(/\//, '').split('files/')[1];
                            fl = `%RELEVANT_PATH%${fl}`
                            callback(fl, {});
                        });
                    }
                }
            });
        }
    }

}