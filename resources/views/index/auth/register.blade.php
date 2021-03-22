@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$menu['menu_meta_title_'.$lang]}}</title>
    <meta name="description" content="{{$menu['menu_meta_description_'.$lang]}}"/>
    <meta name="keywords" content="{{$menu['menu_meta_keywords_'.$lang]}}"/>

@endsection

@section('header')
    @include('index.layout.header')
@endsection


@section('content')

    <div class="authorize-page">
        <div class="authorize-modal login-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Регистрация</h6>
                    <a href="/">
                        <button class="btn-plain modal-close">
                            <i class="icon close-grey"></i>
                        </button>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <div class="input-form">
                            <input id="user_name" type="text" name="login" placeholder="Ваше имя" required>
                        </div>
                        <div class="input-form">
                            <input id="email" type="email" name="login" placeholder="Электронная почта" required>
                        </div>
                        <div class="input-form">
                            <input class="pwd-input" id="password" type="password" placeholder="Введите пароль">
                            <button class="btn-plain pwd-show" type="button">
                                <svg width="22" height="9" viewBox="0 0 22 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.7351 0.826172C15.6692 7.33821 6.12175 7.33821 2.05581 0.826172L1.26188 1.44214C1.4476 1.73417 1.64347 2.01407 1.84863 2.28183L0.54187 3.58859L1.24898 4.29569L2.49348 3.05119C3.34498 3.98065 4.31973 4.73304 5.37076 5.30835L3.99542 7.14214L4.79542 7.74214L6.28487 5.75621C7.59164 6.32486 8.98875 6.63929 10.3954 6.69951V8.94214H11.3954V6.69951C12.7984 6.63946 14.1919 6.32653 15.4957 5.76071L16.4482 7.66575L17.3426 7.21853L16.3945 5.32233C17.4623 4.74148 18.4519 3.97831 19.3142 3.03282L20.8043 4.32045L21.4581 3.56383L19.9552 2.26501C20.1556 2.00236 20.3472 1.72807 20.529 1.44214L19.7351 0.826172Z" fill="#2B2D38"/>
                                </svg>
                            </button>
                        </div>
                        <div class="input-form">
                            <input class="pwd-input" id="confirm_password" type="password" placeholder="Подтверждение пароля">
                            <button class="btn-plain pwd-show" type="button">
                                <svg width="22" height="9" viewBox="0 0 22 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.7351 0.826172C15.6692 7.33821 6.12175 7.33821 2.05581 0.826172L1.26188 1.44214C1.4476 1.73417 1.64347 2.01407 1.84863 2.28183L0.54187 3.58859L1.24898 4.29569L2.49348 3.05119C3.34498 3.98065 4.31973 4.73304 5.37076 5.30835L3.99542 7.14214L4.79542 7.74214L6.28487 5.75621C7.59164 6.32486 8.98875 6.63929 10.3954 6.69951V8.94214H11.3954V6.69951C12.7984 6.63946 14.1919 6.32653 15.4957 5.76071L16.4482 7.66575L17.3426 7.21853L16.3945 5.32233C17.4623 4.74148 18.4519 3.97831 19.3142 3.03282L20.8043 4.32045L21.4581 3.56383L19.9552 2.26501C20.1556 2.00236 20.3472 1.72807 20.529 1.44214L19.7351 0.826172Z" fill="#2B2D38"/>
                                </svg>
                            </button>
                        </div>
                        <button class="btn-plain btn-main" onclick="registerAjax()">Продолжить</button>

                        <p class="authorize-modal-text">У вас нет аккаунта? <a href="/auth/register">Зарегистрироваться</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection




