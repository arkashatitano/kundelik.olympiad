@extends('index.layout.layout')

@section('meta-tags')

    <title>История</title>

@endsection


@section('content')

    <div class="wrapper">

        @include('index.profile.left-side')

        <article class="right-content">
            <div class="right-content-inner">
                <h2 class="right-content-title">Профиль</h2>
                <div class="history-list">
                    <div class="history-head">
                        <div class="history-date">
                            <p>Дата и время</p>
                        </div>
                        <div class="history-name">
                            <p>Название</p>
                        </div>
                        <div class="history-status">
                            <p>Статус</p>
                        </div>
                    </div>
                    <div class="history-wrapper">
                        @include('index.profile.history.payment-list-loop')
                    </div>
                </div>
            </div>
        </article>
    </div>

@endsection



