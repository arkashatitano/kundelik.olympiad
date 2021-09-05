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

    <article class="slider">
        <div class="container">
            <div class="slider-content">
                <div class="slider-caption">
                    <h1>{!!\App\Http\Helpers::getInfoText(51)!!}</h1>
                    {{--<a class="btn-main" href="#">Участвовать</a>--}}
                </div>
                <div class="slider-img">
                    <img src="/img/main/slider-img.png">
                </div>
            </div>
        </div>
    </article>
    <article class="intro">
        <div class="container">
            <section class="olympiad">
                <h2 class="olympiad-title">@lang('messages.olympiads')</h2>
                {{--<div class="olympiad-tab">
                    <button class="btn-plain olympiad-tablink active" onclick="showMainTestList(this,2)">Все</button>
                    <button class="btn-plain olympiad-tablink" onclick="showMainTestList(this,1)">Для школьников</button>
                    <button class="btn-plain olympiad-tablink" onclick="showMainTestList(this,0)">Для преподавателей</button>
                </div>--}}
                <div class="olympiad-item-wrapper">
                    @include('index.index.test-list-loop')
                </div>
            </section>
            <section class="counter">
                <div class="counter-item">
                    <h4 class="counter-stat">241</h4>
                    <p>@lang('messages.get_certificate')</p>
                </div>
                <div class="counter-item">
                    <h4 class="counter-stat">48</h4>
                    <p>@lang('messages.do_olympiads')</p>
                </div>
                <div class="counter-item">
                    <h4 class="counter-stat">1092</h4>
                    <p>@lang('messages.did_olympiads')</p>
                </div>
                <div class="counter-item">
                    <h4 class="counter-stat">2491</h4>
                    <p>@lang('messages.all_users')</p>
                </div>
            </section>
        </div>
    </article>

    <div class="modal test-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h6 id="modal_title"></h6>
                <button class="btn-plain modal-close">
                    <i class="icon close-grey"></i>
                </button>
            </div>
            <div class="modal-body">
                <p></p>
                <a id="modal_rule" href="/test/desc" target="_blank">
                    <button class="btn-plain btn-main">@lang('messages.how_test')</button>
                </a>
                <button style="margin-top: 10px" class="btn-plain btn-main" onclick="buyOlympiadTest()">@lang('messages.do_it')</button>
            </div>
        </div>
    </div>

@endsection

@section('footer')

    @include('index.layout.footer')

@endsection


