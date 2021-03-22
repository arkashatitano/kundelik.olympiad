@extends('index.layout.layout')

@section('meta-tags')

    <title>Ничего не найдено</title>

@endsection


@section('content')

    <div class="container">
        <div class="content-page page-error">
            <div class="video-page page-error">
                <div class="page-error-middle">
                    <div class="page-error-number">4<span>0</span>4</div>
                    <div class="page-error__text">
                        Ничего не найдено :(
                    </div>
                    <a href="/" class="btn small-btn">
                        Вернуться на главную страницу
                    </a>
                </div>

            </div>
        </div>
    </div>

@endsection
