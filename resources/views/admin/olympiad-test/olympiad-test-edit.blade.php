@extends('admin.layout.layout')

@section('css')
    <link href="/admin/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0" >
                    {{ $title }}
                </h3>
            </div>
            <div class="col-md-4 col-4 align-self-center text-right">
                <a href="/admin/olympiad-test" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Назад</a>
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
                        @if($row->olympiad_test_id > 0)
                            <form action="/admin/olympiad-test/{{$row->olympiad_test_id}}" method="POST">
                                <input type="hidden" name="_method" value="PUT">
                                @else
                                    <form action="/admin/olympiad-test" method="POST">
                                        @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="olympiad_test_id" value="{{ $row->olympiad_test_id }}">
                                        <input type="hidden" value="@if(isset($_GET['parent_id'])){{$_GET['parent_id']}}@endif" name="parent_id">

                                        <input type="hidden" class="image-name" id="olympiad_test_image" name="olympiad_test_image" value="{{ $row->olympiad_test_image }}"/>
                                        <input type="hidden" class="image-name2" id="olympiad_test_image2" name="olympiad_test_icon" value="{{ $row->olympiad_test_icon }}"/>

                                        <div class="box-body">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#info" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Информация</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#certificate" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Сертификат</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#rule" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Правила</span></a> </li>
                                            </ul>
                                            <div class="tab-content tabcontent-border">
                                                <div class="tab-pane active" id="info" role="tabpanel">
                                                    <div class="card-block">
                                                        <div class="form-group">
                                                            <label>Название теста</label>
                                                            <input value="{{ $row->olympiad_test_name_ru }}" type="text" class="form-control" name="olympiad_test_name_ru" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Стоимость</label>
                                                            <input value="{{ $row->olympiad_test_cost }}" type="number" class="form-control" name="olympiad_test_cost" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Количество обычных вопросов</label>
                                                            <input value="{{ $row->olympiad_test_question_count }}" type="number" class="form-control" name="olympiad_test_question_count" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Количество общих вопросов (педагогика)</label>
                                                            <input value="{{ $row->special_question_count }}" type="number" class="form-control" name="special_question_count" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Разделять вопросы по сложности</label>
                                                            <select name="is_show_level" data-placeholder="Выберите" class="form-control">
                                                                <option @if($row->is_show_level == 0) selected @endif value="0">Нет</option>
                                                                <option @if($row->is_show_level == 1) selected @endif value="1">Да</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Минимальный балл для 3 место</label>
                                                            <input value="{{ $row->min_point_to_diploma }}" type="number" class="form-control" name="min_point_to_diploma" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Минимальный балл для 2 место</label>
                                                            <input value="{{ $row->min_point_to_second_place }}" type="number" class="form-control" name="min_point_to_second_place" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Минимальный балл для 1 место</label>
                                                            <input value="{{ $row->min_point_to_first_place }}" type="number" class="form-control" name="min_point_to_first_place" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Длительность теста (минута)</label>
                                                            <div>
                                                                <input value="{{ $row->olympiad_test_duration }}" type="number" class="form-control" name="olympiad_test_duration" placeholder="Введите">
                                                            </div>
                                                        </div>
                                                        {{--<div class="form-group">
                                                            <label>Тип сертификата</label>
                                                            <select name="certificate_type_id" data-placeholder="Выберите" class="form-control">
                                                                <option @if($row->certificate_type_id == 2) selected @endif value="2">Дизайн 2</option>
                                                                <option @if($row->certificate_type_id == 1) selected @endif value="1">Дизайн 1</option>
                                                                <option @if($row->certificate_type_id == 3) selected @endif value="3">Дизайн 3</option>
                                                                <option @if($row->certificate_type_id == 4) selected @endif value="4">Дизайн 4</option>
                                                                <option @if($row->certificate_type_id == 5) selected @endif value="5">Дизайн 5</option>
                                                                <option @if($row->certificate_type_id == 6) selected @endif value="6">Дизайн 6</option>
                                                                <option @if($row->certificate_type_id == 7) selected @endif value="7">Дизайн 7</option>
                                                                <option @if($row->certificate_type_id == 8) selected @endif value="8">Дизайн 8</option>
                                                                <option @if($row->certificate_type_id == 9) selected @endif value="9">Дизайн 9</option>
                                                                <option @if($row->certificate_type_id == 10) selected @endif value="10">Дизайн 10</option>
                                                                <option @if($row->certificate_type_id == 11) selected @endif value="11">Дизайн 11</option>
                                                                <option @if($row->certificate_type_id == 12) selected @endif value="12">Дизайн 12</option>
                                                            </select>
                                                        </div>

                                                        {{--<div class="form-group">
                                                            <label>Класс (необязательно)</label>
                                                            <select name="olympiad_test_grade" class="form-control" >
                                                                <option @if($row->olympiad_test_grade == 0) selected="selected" @endif value="0">Все</option>
                                                                @for($i = 1; $i <= 11; $i++)

                                                                    <option @if($row->olympiad_test_grade == $i) selected="selected" @endif value="{{$i}}">{{$i}}</option>

                                                                @endfor

                                                            </select>
                                                        </div>--}}
                                                        {{--<div class="form-group">
                                                            <label>Тип</label>
                                                            <select name="olympiad_type_id" class="form-control" >
                                                                <option @if($row->olympiad_type_id == 1) selected="selected" @endif value="1">20 вопросов (4 вариант)</option>
                                                                <option @if($row->olympiad_type_id == 3) selected="selected" @endif value="3">20 вопросов (5 вариант)</option>
                                                                <option @if($row->olympiad_type_id == 4) selected="selected" @endif value="4">25 вопросов (5 вариант) 4 блока</option>
                                                                <option @if($row->olympiad_type_id == 2) selected="selected" @endif value="2">Полиглот - 30 вопросов</option>
                                                            </select>
                                                        </div>--}}
                                                        <div class="form-group">
                                                            <label>Для кого (необязательно)</label>
                                                            <select name="olympiad_test_is_childhood" data-placeholder="Выберите" class="form-control">
                                                                <option @if($row->olympiad_test_is_childhood == '' && $row->olympiad_test_is_childhood != 0) selected @endif value="">Для всех</option>
                                                                <option @if($row->olympiad_test_is_childhood == 1) selected @endif value="1">Для школьников</option>
                                                                <option @if($row->olympiad_test_is_childhood != '' && $row->olympiad_test_is_childhood == 0) selected @endif value="0">Для преподавателей</option>

                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Дата начала</label>
                                                            <input value="{{ $row->olympiad_test_date_start }}" type="text" class="form-control mydatepicker" name="olympiad_test_date_start" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Дата окончания</label>
                                                            <input value="{{ $row->olympiad_test_date_end }}" type="text" class="form-control mydatepicker" name="olympiad_test_date_end" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Порядковый номер сортировки</label>
                                                            <input value="{{ $row->sort_num }}" type="text" class="form-control" name="sort_num" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст сертификата (Первое место)</label>
                                                            <textarea id="" name="certificate_text_1" class="ckeditor form-control text_editor"><?=$row->certificate_text_1?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст сертификата (Второе место)</label>
                                                            <textarea id="" name="certificate_text_2" class="ckeditor form-control text_editor"><?=$row->certificate_text_2?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст сертификата (Третье место)</label>
                                                            <textarea id="" name="certificate_text_3" class="ckeditor form-control text_editor"><?=$row->certificate_text_3?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="certificate" role="tabpanel">
                                                    <div class="card-block">
                                                        <div class="form-group">
                                                            <label>Текст сертификата (Первое место)</label>
                                                            <textarea id="" name="certificate_text_1" class="ckeditor form-control text_editor"><?=$row->certificate_text_1?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст сертификата (Второе место)</label>
                                                            <textarea id="" name="certificate_text_2" class="ckeditor form-control text_editor"><?=$row->certificate_text_2?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Текст сертификата (Третье место)</label>
                                                            <textarea id="" name="certificate_text_3" class="ckeditor form-control text_editor"><?=$row->certificate_text_3?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="rule" role="tabpanel">
                                                    <div class="form-group">
                                                        <label>Текст правилы</label>
                                                        <textarea name="olympiad_rule" class="ckeditor form-control text_editor"><?=$row->olympiad_rule?></textarea>
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

            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="box box-primary" style="padding: 30px; text-align: center">
                            <p>главная картинка</p>
                            <div style="padding: 20px; border: 1px solid #c2e2f0">
                                <img class="image-src" src="{{ $row->olympiad_test_image }}" style="width: 100%; "/>
                            </div>
                            <div style="background-color: #c2e2f0;height: 40px;margin: 0 auto;width: 2px;"></div>
                            <form id="image_form" enctype="multipart/form-data" method="post" class="image-form">
                                <i class="fa fa-plus"></i>
                                <input id="avatar-file" type="file" onchange="uploadImage()" name="image"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




        </div>

    </div>

@endsection

@section('js')


    <script src="/admin/assets/plugins/moment/moment.js"></script>
    <script src="/admin/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>


    <script>
        $('.mydatepicker').datepicker({
            format: 'dd-mm-yyyy'
        });
    </script>

    <script>

        $(".select2").select2();

    </script>

@endsection

