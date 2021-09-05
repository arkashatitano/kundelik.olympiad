@extends('index.layout.layout')

@section('meta-tags')

    <title>Олимпиада</title>

@endsection


@section('content')

    <div class="wrapper">

        @include('index.profile.left-side')

        <article class="right-content">
            <div class="right-content-inner">
                <h2 class="right-content-title">Профиль</h2>
                <div class="olympiad-tab">
                    <button class="btn-plain olympiad-tablink " onclick="showTestList(this,1)">@lang('messages.unfinish')</button>
                    <button class="btn-plain olympiad-tablink active" onclick="showTestList(this,0)">@lang('messages.finish')</button>
                </div>
                <div class="olympiad-card-wrapper">
                    @include('index.profile.test.test-list-loop')
                </div>
            </div>
        </article>
    </div>

@endsection



