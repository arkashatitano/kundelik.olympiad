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

    <div class="page-info">
        <div class="container">
            <h1>{{$menu['menu_name_'.$lang]}}</h1>
            <div>
                {!! $menu['menu_text_'.$lang] !!}
            </div>
        </div>
    </div>


@endsection

@section('footer')
    @include('index.layout.footer')
@endsection

@section('js')


@endsection



