@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0" >
                    {{ $title }}
                </h3>
            </div>
            <div class="col-md-4 col-4 align-self-center text-right">
                <a href="/admin/question" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Назад</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-block">
                        @if (isset($error))
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif
                        @if($row->olympiad_test_question_id > 0)
                            <form action="/admin/olympiad-test-question/{{$row->olympiad_test_question_id}}" method="POST">
                                <input type="hidden" name="_method" value="PUT">
                                @else
                                    <form action="/admin/olympiad-test-question" method="POST">
                                        @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="olympiad_test_question_id" value="{{ $row->olympiad_test_question_id }}">
                                        <input type="hidden" value="@if(isset($_GET['parent_id'])){{$_GET['parent_id']}}@endif" name="parent_id">

                                        <input type="hidden" class="image-name" id="olympiad_test_question_image" name="olympiad_test_question_image" value="{{ $row->olympiad_test_question_image }}"/>
                                        <input type="hidden" class="image-name2" id="olympiad_test_question_image2" name="olympiad_test_question_icon" value="{{ $row->olympiad_test_question_icon }}"/>

                                        <div class="box-body">

                                                <div class="tab-pane active" id="info" role="tabpanel">
                                                    <div class="card-block">
                                                        <div class="form-group">
                                                            <label>Тест</label>
                                                            <select name="olympiad_test_id" data-placeholder="Выберите" class="form-control select2">
                                                                <option></option>
                                                                @foreach($tests as $item)
                                                                    <option @if((isset($_GET['olympiad_test_id']) && $_GET['olympiad_test_id'] == $item->olympiad_test_id) || $item->olympiad_test_id == $row->olympiad_test_id) selected @endif value="{{$item->olympiad_test_id}}">{{$item->olympiad_test_name_ru}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Язык (необязательно)</label>
                                                            <select name="olympiad_test_question_lang" data-placeholder="Выберите" class="form-control">
                                                                <option @if($row->olympiad_test_question_lang == '') selected @endif value="">Не выбран</option>
                                                                <option @if($row->olympiad_test_question_lang == 'kz') selected @endif value="kz">Казахский</option>
                                                                <option @if($row->olympiad_test_question_lang == 'ru') selected @endif value="ru">Русский</option>
                                                                <option @if($row->olympiad_test_question_lang == 'en') selected @endif value="en">Английский</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Вопрос</label>
                                                            <textarea name="olympiad_test_question_name_ru" class=" form-control ckeditor"><?=$row->olympiad_test_question_name_ru?></textarea>
                                                        </div>
                                                        {{--<div class="form-group">
                                                            <label>Уровень</label>
                                                            <input value="{{ $row->olympiad_test_question_level }}" type="text" class="form-control" name="olympiad_test_question_level" placeholder="">
                                                        </div>--}}
                                                        <div class="form-group">
                                                            <label>1 вариант</label>
                                                            <textarea name="variant1" class=" form-control ckeditor"><?=$row->variant1?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>2 вариант</label>
                                                            <textarea name="variant2" class=" form-control ckeditor"><?=$row->variant2?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>3 вариант</label>
                                                            <textarea name="variant3" class=" form-control ckeditor"><?=$row->variant3?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>4 вариант</label>
                                                            <textarea name="variant4" class=" form-control ckeditor"><?=$row->variant4?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>5 вариант</label>
                                                            <textarea name="variant5" class=" form-control ckeditor"><?=$row->variant5?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Правильный вариант</label>
                                                            <select name="correct_variant" class="form-control" >

                                                                @for($i = 1; $i <= 5; $i++)

                                                                    <option @if($row->correct_variant == $i) selected="selected" @endif value="{{$i}}">{{$i}}</option>

                                                                @endfor

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary">Сохранить</button>
                                        </div>
                                    </form>
                    </div>
                </div>
            </div>






        </div>

    </div>

@endsection

@section('js')

    <script src="/admin/assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <script>

        $(".select2").select2();

    </script>

@endsection


