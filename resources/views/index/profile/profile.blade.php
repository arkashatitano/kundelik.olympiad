@extends('index.layout.layout')

@section('meta-tags')

    <title>Профиль</title>

@endsection


@section('content')

    <div class="wrapper">

        @include('index.profile.left-side')

        <article class="right-content">
            <div class="right-content-inner">
                <h2 class="right-content-title">Профиль</h2>
                <div class="profileSet-content">
                    <div class="input-form-box">
                        <span>@lang('messages.name')</span>
                        <div class="input-form">
                            <input type="text" id="user_name" value="{{Auth::user()->name}}">
                        </div>
                    </div>
                    <div class="input-form-box">
                        <span>@lang('messages.phone')</span>
                        <div class="input-form">
                            <i class="icon icon-kaz"></i>
                            <input class="phone-mask" id="phone" type="text" value="{{Auth::user()->phone}}">
                        </div>
                    </div>
                    <div class="input-form-box">
                        <span>Email</span>
                        <div class="input-form">
                            <input type="email" id="email" value="{{Auth::user()->email}}">
                        </div>
                    </div>
                    <button class="btn-plain btn-main" onclick="saveProfile()">@lang('messages.save')</button>
                </div>
            </div>
        </article>
    </div>

@endsection



