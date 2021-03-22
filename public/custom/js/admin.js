/**
 * Created by Arman-PC on 21.12.2016.
 */


function showError(message){
    $.gritter.add({
        title: 'Ошибка',
        text: message
    });
    return false;
}

function showMessage(message){
    $.gritter.add({
        title: 'Успех',
        text: message,
        class_name: 'success-gritter'
    });
    return false;
}

/*
 jQuery Masked Input Plugin
 Copyright (c) 2007 - 2015 Josh Bush (digitalbush.com)
 Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license)
 Version: 1.4.1
 */

!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a){var b,c=navigator.userAgent,d=/iphone/i.test(c),e=/chrome/i.test(c),f=/android/i.test(c);a.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},autoclear:!0,dataName:"rawMaskFn",placeholder:"_"},a.fn.extend({caret:function(a,b){var c;if(0!==this.length&&!this.is(":hidden"))return"number"==typeof a?(b="number"==typeof b?b:a,this.each(function(){this.setSelectionRange?this.setSelectionRange(a,b):this.createTextRange&&(c=this.createTextRange(),c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select())})):(this[0].setSelectionRange?(a=this[0].selectionStart,b=this[0].selectionEnd):document.selection&&document.selection.createRange&&(c=document.selection.createRange(),a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length),{begin:a,end:b})},unmask:function(){return this.trigger("unmask")},mask:function(c,g){var h,i,j,k,l,m,n,o;if(!c&&this.length>0){h=a(this[0]);var p=h.data(a.mask.dataName);return p?p():void 0}return g=a.extend({autoclear:a.mask.autoclear,placeholder:a.mask.placeholder,completed:null},g),i=a.mask.definitions,j=[],k=n=c.length,l=null,a.each(c.split(""),function(a,b){"?"==b?(n--,k=a):i[b]?(j.push(new RegExp(i[b])),null===l&&(l=j.length-1),k>a&&(m=j.length-1)):j.push(null)}),this.trigger("unmask").each(function(){function h(){if(g.completed){for(var a=l;m>=a;a++)if(j[a]&&C[a]===p(a))return;g.completed.call(B)}}function p(a){return g.placeholder.charAt(a<g.placeholder.length?a:0)}function q(a){for(;++a<n&&!j[a];);return a}function r(a){for(;--a>=0&&!j[a];);return a}function s(a,b){var c,d;if(!(0>a)){for(c=a,d=q(b);n>c;c++)if(j[c]){if(!(n>d&&j[c].test(C[d])))break;C[c]=C[d],C[d]=p(d),d=q(d)}z(),B.caret(Math.max(l,a))}}function t(a){var b,c,d,e;for(b=a,c=p(a);n>b;b++)if(j[b]){if(d=q(b),e=C[b],C[b]=c,!(n>d&&j[d].test(e)))break;c=e}}function u(){var a=B.val(),b=B.caret();if(o&&o.length&&o.length>a.length){for(A(!0);b.begin>0&&!j[b.begin-1];)b.begin--;if(0===b.begin)for(;b.begin<l&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}else{for(A(!0);b.begin<n&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}h()}function v(){A(),B.val()!=E&&B.change()}function w(a){if(!B.prop("readonly")){var b,c,e,f=a.which||a.keyCode;o=B.val(),8===f||46===f||d&&127===f?(b=B.caret(),c=b.begin,e=b.end,e-c===0&&(c=46!==f?r(c):e=q(c-1),e=46===f?q(e):e),y(c,e),s(c,e-1),a.preventDefault()):13===f?v.call(this,a):27===f&&(B.val(E),B.caret(0,A()),a.preventDefault())}}function x(b){if(!B.prop("readonly")){var c,d,e,g=b.which||b.keyCode,i=B.caret();if(!(b.ctrlKey||b.altKey||b.metaKey||32>g)&&g&&13!==g){if(i.end-i.begin!==0&&(y(i.begin,i.end),s(i.begin,i.end-1)),c=q(i.begin-1),n>c&&(d=String.fromCharCode(g),j[c].test(d))){if(t(c),C[c]=d,z(),e=q(c),f){var k=function(){a.proxy(a.fn.caret,B,e)()};setTimeout(k,0)}else B.caret(e);i.begin<=m&&h()}b.preventDefault()}}}function y(a,b){var c;for(c=a;b>c&&n>c;c++)j[c]&&(C[c]=p(c))}function z(){B.val(C.join(""))}function A(a){var b,c,d,e=B.val(),f=-1;for(b=0,d=0;n>b;b++)if(j[b]){for(C[b]=p(b);d++<e.length;)if(c=e.charAt(d-1),j[b].test(c)){C[b]=c,f=b;break}if(d>e.length){y(b+1,n);break}}else C[b]===e.charAt(d)&&d++,k>b&&(f=b);return a?z():k>f+1?g.autoclear||C.join("")===D?(B.val()&&B.val(""),y(0,n)):z():(z(),B.val(B.val().substring(0,f+1))),k?b:l}var B=a(this),C=a.map(c.split(""),function(a,b){return"?"!=a?i[a]?p(b):a:void 0}),D=C.join(""),E=B.val();B.data(a.mask.dataName,function(){return a.map(C,function(a,b){return j[b]&&a!=p(b)?a:null}).join("")}),B.one("unmask",function(){B.off(".mask").removeData(a.mask.dataName)}).on("focus.mask",function(){if(!B.prop("readonly")){clearTimeout(b);var a;E=B.val(),a=A(),b=setTimeout(function(){B.get(0)===document.activeElement&&(z(),a==c.replace("?","").length?B.caret(0,a):B.caret(a))},10)}}).on("blur.mask",v).on("keydown.mask",w).on("keypress.mask",x).on("input.mask paste.mask",function(){B.prop("readonly")||setTimeout(function(){var a=A(!0);B.caret(a),h()},0)}),e&&f&&B.off("input.mask").on("input.mask",u),A()})}})});


$(function() {
    $(".phone-mask").mask("+7(999)999-99-99");
});

KindEditor.ready(function(K) {
    K.create('.text_editor', {

        cssPath : [''],
        autoHeightMode : true, // это автоматическая высота блока
        afterCreate : function() {
            this.loadPlugin('autoheight');
        },
        allowFileManager : true,
        items : [// Вот здесь задаем те кнопки которые хотим видеть
            'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
            'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
            'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
            'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
            'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
            'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
            'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons','deliverybreak',
            'anchor', 'link',  'unlink','map', '|', 'about'
        ]
    });
    //Ниже инициализируем доп. например выбор цвета или загрузка файла
    var colorpicker;
    K('#colorpicker').bind('click', function(e) {
        e.stopPropagation();
        if (colorpicker) {
            colorpicker.remove();
            colorpicker = null;
            return;
        }
        var colorpickerPos = K('#colorpicker').pos();
        colorpicker = K.colorpicker({
            x : colorpickerPos.x,
            y : colorpickerPos.y + K('#colorpicker').height(),
            z : 19811214,
            selectedColor : 'default',
            noColor : 'Очистить',
            click : function(color) {
                K('#color').val(color);
                colorpicker.remove();
                colorpicker = null;
            }
        });
    });
    K(document).click(function() {
        if (colorpicker) {
            colorpicker.remove();
            colorpicker = null;
        }
    });

    var editor = K.editor({
        allowFileManager : true
    });
});

/*$('.datetimepicker-input').datetimepicker({
    format: 'DD.MM.YYYY HH:mm'
});*/

/*$('.datetimepicker-input').on('dp.show', function () { // Hack datepicker position
    var datepicker = $(this).siblings('.bootstrap-datetimepicker-widget');
    if (datepicker.hasClass('top')) {
        var top = $(this).offset().top - datepicker.height() - 130;
        datepicker.css({'top': top + 'px', 'bottom': 'auto'});
    }
});*/

$("#image_form").submit(function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url:'/image/upload',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $('.ajax-loader').css('display','none');
            if(data.success == 0){
                showError(data.error);
                return;
            }
            $('.image-name').val(data.file_name);
            $('.image-src').attr('src',data.file_name + '?v=1');

            $('#social_href').click();
            showCropImage();
        }
    });
});

function uploadImage(){
    $('.ajax-loader').css('display','block');
    $("#image_form").submit();
}

function uploadNewsImage(){
    $('.ajax-loader').css('display','block');
    $("#image2_form").submit();
}

$("#image2_form").submit(function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url:'/image/upload',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $('.ajax-loader').css('display','none');
            if(data.success == 0){
                showError(data.error);
                return;
            }
            $('.image-name2').val(data.file_name);
            $('.image-src2').attr('src',data.file_name + '?v=1');
        }
    });
});


function searchBySort() {
    href = '?search=' + $('#search_word').val();
    window.location.href = href;
}

$( "#search_word" ).keyup(function(event) {
    if (!event.ctrlKey && event.which == 13) {
        searchBySort();
    }
});

function isShowDisabledAll(model) {
    if(confirm('Действительно хотите сделать неактивным?')){
        $('.ajax-loader').fadeIn(100);
        $('.select-all').each(function(){
            if ($(this).is(':checked')) {
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data :{
                        is_show: 0,
                        id: $(this).val()
                    },
                    url: "/admin/" + model + "/is_show",
                    success: function(data){
                        if(model == 'comment' || model == 'contact'){
                            getNewOrderCount();
                        }
                    }
                });
                $(this).closest('tr').remove();
            }
        });
        $('.ajax-loader').fadeOut(100);
    }
}

function isShowEnabledAll(model) {
    if(confirm('Действительно хотите сделать активным?')){
        $('.ajax-loader').fadeIn(100);
        $('.select-all').each(function(){
            if ($(this).is(':checked')) {
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data :{
                        is_show: 1,
                        id: $(this).val()
                    },
                    url: "/admin/" + model + "/is_show",
                    success: function(data){
                        if(model == 'comment' || model == 'contact'){
                            getNewOrderCount();
                        }
                    }
                });
                $(this).closest('tr').remove();
            }
        });
        $('.ajax-loader').fadeOut(100);
    }
}

function deleteAll(model) {
    if(confirm('Действительно хотите удалить?')){
        $('.ajax-loader').fadeIn(100);
        $('.select-all').each(function(){
            if ($(this).is(':checked')) {
                $.ajax({
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/admin/" + model + "/" + $(this).val(),
                    success: function(){
                        if(model == 'comment' || model == 'contact'){
                            getNewOrderCount();
                        }
                    }
                });
                $(this).closest('tr').remove();
            }
        });
        $('.ajax-loader').fadeOut(100);
    }
}

function selectAllCheckbox(ob) {
    if ($(ob).is(':checked')) {
        $('.select-all').prop('checked', true);
    }
    else {
        $('.select-all').prop('checked', false);
    }
}

function delItem(ob,id,model){
    if(confirm('Действительно хотите удалить?')){
        $(ob).closest('tr').remove();
        $.ajax({
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/admin/" + model + "/" + id,
            success: function(data){
                if(model == 'comment' || model == 'contact'){
                    getNewOrderCount();
                }
            }
        });
    }
}

function isShow(ob,id,model){
    var is_show = 0;
    if($(ob).is(':checked')) {
        is_show = 1;
    }
    $.ajax({
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data :{
            is_show: is_show,
            id: id
        },
        url: "/admin/" + model + "/is_show",
        success: function(data){

        }
    });
}

var cw = $('#avatar_img').width();
$('#avatar_img').css('height',cw);

$('.news-lang').change(function () {
    $('.lang-item').fadeOut(100);
    $('.add-lang-item').fadeIn(100);
    $('#lang_' + this.value).fadeIn(100);
    $('#add_lang_' + this.value).fadeOut(100);
    $('.ke-container').css('width','100%');
});

function showLang(lang) {
    $('#add_lang_' + lang).fadeOut(100);
    $('#lang_' + lang).fadeIn(100);
    $('.ke-container').css('width','100%');
}

/*$('a.fancybox').fancybox({
    padding: 10
});*/

/*$(function() {
    $(".phone-mask").mask("+7(999)999-99-99");
});*/

/*$('.date-mask').datetimepicker({
    format: 'DD.MM.YYYY'
});*/


function changeUrl(ob,id) {
    $.ajax({
        type: 'GET',
        url: "/admin/url",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data :{
            word: $(ob).val()
        },
        success: function(data){
            $('#' + id).val(data.result);
        }
    });
}

function uploadAudio(lang){

}

function confirmDeleteImage(ob) {
    if(confirm('Действительно хотите сделать удалить?')){
        $(ob).closest('.image-item').remove();
    }
}


function getImageList(image_url){
    $.ajax({
        type: 'GET',
        url: "/admin/news/image",
        data:{
            image_url: image_url
        },
        success: function(data){
            $('#photo_content').prepend(data);
        }
    });
}



function getRegionListByParent(ob) {
    $.ajax({
        type: 'GET',
        url: "/admin/ajax/region",
        data:{
            region_id: $(ob).val()
        },
        success: function(data){
            $('#city_content').html(data);
        }
    });
}


function getChapterListBySubject(ob) {
    $.ajax({
        type: 'GET',
        url: "/admin/ajax/chapter",
        data:{
            subject_id: $(ob).val()
        },
        success: function(data){
            $('#chapter_content').html(data);
        }
    });
}

function getSubjectListBySpecialTest(ob) {
    $.ajax({
        type: 'GET',
        url: "/admin/ajax/special-test",
        data:{
            special_test_id: $(ob).val()
        },
        success: function(data){
            $('#subject_content').html(data);
        }
    });
}

function getLessonListBySubject(ob) {
    $.ajax({
        type: 'GET',
        url: "/admin/ajax/lesson",
        data:{
            subject_id: $(ob).val()
        },
        success: function(data){
            $('#lesson_content').html(data);
        }
    });
}

function saveCropImage(){
    if($('#crop_image').attr('src') == '/img/default.png'){
        showError('Загрузите фото');
        return;
    }

    var image_url = $('#product_image').val() + '?x=' + $('#dataX').val() + '&y=' + $('#dataY').val() + '&width=' + $('#dataWidth').val() + '&height=' + $('#dataHeight').val();
    $('#image_crop').val(image_url);
    showMessage('Успешно сохранено');
}

function addTaskAnswer(){
    $('#task_answer_content').append('<input value="" type="text" class="form-control" name="task_answer[]" placeholder="Введите">');
}


function getInfoByRole(role_id){
    $('.section-info').css('display','none');
    $('.section_role_' + role_id).css('display','block');
}


function getClientInfoByPhone(ob) {
    $.ajax({
        type: 'GET',
        url: "/admin/ajax/client",
        data:{
            phone: $(ob).val()
        },
        success: function(data){
            if(data.status == false){
                $('#user_name').html('Никого не найдено');
            }
            else {
                $('#user_name').html(data.data.name);
            }
        }
    });
}


function getClientInfoByEmail(ob) {
    $.ajax({
        type: 'GET',
        url: "/admin/ajax/client",
        data:{
            email: $(ob).val()
        },
        success: function(data){
            if(data.status == false){
                $('#user_name').html('Никого не найдено');
            }
            else {
                $('#user_name').html(data.data.name);
            }
        }
    });
}

function sendDaryn() {
    if(confirm('Действительно хотите отправить?')) {
        $('.ajax-loader').fadeIn(100);

        $.ajax({
            type: 'POST',
            url: "/admin/send-score",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                email: $('#email').val(),
                partner_id: $('#partner_id').val(),
                score: $('#score').val()
            },
            success: function(data){
                $('.ajax-loader').fadeOut(100);

                if(data.status == 0){
                    showError(data.error);
                    return;
                }
                showMessage(data.message);
                window.location.href = '/admin/operation';
            }
        });

    }

}



function getClientPhoneById(id) {
    $.ajax({
        type: 'GET',
        url: "/admin/ajax/client-phone",
        data:{
            user_id: id
        },
        success: function(data){
            $('.ajax-loader').fadeOut(100);
            if(data.status == 0){
                showError(data.error);
                return;
            }
            $('#modal_list').html(data);
            $('#responsive-modal').modal('show');
        }
    });
}


function savePhoneStatus(user_id) {
    $('.ajax-loader').fadeIn(100);
    $.ajax({
        type: 'POST',
        url: "/admin/ajax/phone-status",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            user_id: user_id,
            is_confirm_phone: $('#is_confirm_phone').val()
        },
        success: function(data){
            $('.ajax-loader').fadeOut(100);

            if(data.status == 0){
                showError(data.error);
                return;
            }
            showMessage(data.message);
            $('#responsive-modal').modal('hide');
            $('#status_label_' + user_id).html($('#is_confirm_phone').find('option:selected').html());
        }
    });
}

function deleteItem(ob) {
    $(ob).closest('.list-item').remove();
}

function addPersonage(){
    $.ajax({
        url:'/admin/book/personage',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            personage_name: '',
            personage_is_change: ''
        },
        success: function (data) {
            $('#personage_list').append(data);
            $('.ajax-loader').css('display','none');
        }
    });
}

function getClientInfoByPhone(ob) {
    $.ajax({
        type: 'GET',
        url: "/admin/ajax/client",
        data:{
            phone: $(ob).val()
        },
        success: function(data){
            if(data.status == false){
                $('#user_name').html('Никого не найдено');
            }
            else {
                $('#user_name').html(data.data.name);
            }
        }
    });
}


function getClientInfoByEmail(ob) {
    $.ajax({
        type: 'GET',
        url: "/admin/ajax/client",
        data:{
            email: $(ob).val()
        },
        success: function(data){
            if(data.status == false){
                $('#user_name').html('Никого не найдено');
            }
            else {
                $('#user_name').html(data.data.name);
                $('#user_id').val(data.data.user_id);
            }
        }
    });
}

function getClientInfoByID(ob) {
    $.ajax({
        type: 'GET',
        url: "/admin/ajax/client",
        data:{
            id: $(ob).val()
        },
        success: function(data){
            if(data.status == false){
                $('#user_name_by_id').html('Никого не найдено');
            }
            else {
                $('#user_name_by_id').html(data.data.name);
                $('#user_id').val(data.data.user_id);
                $('#email').val(data.data.email);
            }
        }
    });
}

function sendDaryn() {
    if(confirm('Действительно хотите отправить?')) {
        $('.ajax-loader').fadeIn(100);

        $.ajax({
            type: 'POST',
            url: "/admin/send-orda",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                email: $('#email').val(),
                partner_id: $('#partner_id').val(),
                orda: $('#orda').val()
            },
            success: function(data){
                $('.ajax-loader').fadeOut(100);

                if(data.status == 0){
                    showError(data.error);
                    return;
                }
                showMessage(data.message);
               // window.location.href = '/admin/operation';
            }
        });

    }

}



function getClientPhoneById(id) {
    $.ajax({
        type: 'GET',
        url: "/admin/ajax/client-phone",
        data:{
            user_id: id
        },
        success: function(data){
            $('.ajax-loader').fadeOut(100);
            if(data.status == 0){
                showError(data.error);
                return;
            }
            $('#modal_list').html(data);
            $('#responsive-modal').modal('show');
        }
    });
}
