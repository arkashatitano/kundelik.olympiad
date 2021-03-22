//modal close
$('.modal-close').click(function (){
    $('.modal').modal('hide');
})

//hide-show password
$('.pwd-show').click(function () {
    $(this).toggleClass('active');
    var input = $(this).prev($('.pwd-input'));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
})

//open mobile menu
$('.call-menu').click(function (){
    $(this).toggleClass('open');
    $('.mobile-menu').toggleClass('show');
    if($('.mobile-menu').hasClass('show')){
        $('body').addClass('scroll-locked');
    } else {
        $('body').removeClass('scroll-locked');
    }
})

//modal
$('.login-link').click(function (){
    $('.login-modal').modal('show');
})

$('.registration-link').click(function (){
    $('.registration-modal').modal('show');
})

$('.back-to-login').click(function (){
    $('.registration-modal').modal('hide');
    $('.login-modal').modal('show');
})

//alert
$('.olympiad-item-bottom').find('.btn-main').click(function (){
    $('.alert').addClass('active');
})
$('.alert-close').click(function (){
    $('.alert').removeClass('active');
})

//success modal
$('.slider-caption').find('.btn-main').click(function (){
    $('.success-modal').modal('show');
})

//pay modal
$('.success-modal .btn-main').click(function (){
    $('.success-modal').modal('hide');
    $('.pay-modal').modal('show');
})