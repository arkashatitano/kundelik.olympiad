@extends('index.layout.layout')

@section('meta-tags')

    <title>Ничего не найдено</title>

@endsection



@section('content')

    <div class="layout__main">
        <div class="not-found">
            <div class="not-found__title">503</div>
            <div class="not-found__text">Страница не найдена :(</div>
            <a href="/" class="button -green -md">Перейти на главную</a>
        </div>
    </div>

@endsection