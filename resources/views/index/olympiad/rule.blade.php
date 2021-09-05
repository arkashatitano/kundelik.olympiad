@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$olympiad['olympiad_test_name_ru']}}</title>

@endsection

@section('header')
    @include('index.layout.header')
@endsection


@section('content')

    <div class="page-info">
        <div class="container">
            <h1>{{$olympiad['olympiad_test_name_ru']}}</h1>
            <div>
                {!! $olympiad['olympiad_rule'] !!}
            </div>
        </div>
    </div>


@endsection

@section('footer')
    @include('index.layout.footer')
@endsection

@section('js')


@endsection



