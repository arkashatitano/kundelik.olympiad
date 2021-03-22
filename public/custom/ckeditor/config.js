/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.replaceClass = 'ckeditor';

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.extraPlugins = 'base64image';
    //config.extraPlugins = 'mathjax';
    //config.mathJaxLib = '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML';
    config.mathJaxLib = '/custom/js/MathJax.js?config=TeX-AMS_HTML';

    config.toolbar = 'MyToolbar';
    //config.removePlugins = 'easyimage, cloudservices';
    config.toolbar_MyToolbar =
        [
            ['Source','Maximize','Preview','-','NewPage','Undo', 'Redo','-',
            'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-'],
            [ '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat','CopyFormatting'],
            [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript',  'TextColor', 'BGColor', '-',
            'NumberedList', 'BulletedList', 'Outdent', 'Indent', '-','Blockquote', 'CreateDiv', 'HorizontalRule', 'PageBreak', '-'],
            'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-','BidiLtr', 'BidiRtl', '-',
            [  'Link', 'UnLink', 'base64image',  'Mathjax', 'Table',  'Smiley', 'Iframe','-',
                 'InlineLabel','Format', 'Styles', 'Font', 'FontSize'
            ]
        ];
};

/*
CKEDITOR.replace('editor1', {
    extraPlugins: 'mathjax',
    mathJaxLib: 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML',
    height: 320
});*/
