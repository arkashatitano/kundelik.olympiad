@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab">
                    <a href="/admin/olympiad-test-question<?php if(isset($_GET['olympiad_test_id']))echo '?olympiad_test_id='.$_GET['olympiad_test_id'];?>" class="@if(!isset($request->active) || $request->active == '1') active-page @endif">Активные вопросы теста</a>
                </h3>
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab second-tab" >
                    <a href="/admin/olympiad-test-question?active=0<?php if(isset($_GET['olympiad_test_id']))echo '&olympiad_test_id='.$_GET['olympiad_test_id'];?>" class="@if($request->active == '0') active-page @endif">Неактивные вопросы теста</a>
                </h3>
                <div class="clear-float"></div>
            </div>
            <div class="col-md-4 col-4 align-self-center text-right">
                <a href="/admin/olympiad-test-question/create<?php if(isset($_GET['olympiad_test_id']))echo '?olympiad_test_id='.$_GET['olympiad_test_id'];?>" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Добавить</a>
                <div style="float: right; margin-right: 10px">
                    <form id="import_excel" enctype="multipart/form-data" method="post" class="avatar-form" style="font-size:0px; height:auto; width: auto; padding: 0; margin: 0px; width: 220px">
                        <input style="width: 220px;position: absolute;height: 100%;opacity: 0;" id="avatar-file" type="file" onchange="importExcel()" name="image"/>
                        <button class="btn btn-primary">Импортировать вопросы</button>
                        <input type="hidden" value="@if(isset($_GET['olympiad_test_id'])){{$_GET['olympiad_test_id']}}@endif" name="olympiad_test_id"/>
                    </form>
                </div>
            </div>
        </div>

        <div class="row white-bg">
            <div style="text-align: left" class="form-group col-md-6" >

                @if($request->active == '0')

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowEnabledAll('olympiad-test-question')">Сделать активным отмеченные</a>
                    </h4>

                @else

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowDisabledAll('olympiad-test-question')">Сделать неактивным отмеченные</a>
                    </h4>

                @endif

            </div>
            <div style="text-align: right" class="form-group col-md-6" >
                <h4 class="box-title box-delete-click">
                    <a href="javascript:void(0)" onclick="deleteAll('olympiad-test-question')">Удалить отмеченные</a>
                </h4>
            </div>

            <div class="col-md-12">
                <div class="box-body">
                    <table id="olympiad_test_question_datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="border: 1px">
                            <th style="width: 30px">№</th>
                            <th>Вопрос</th>
                            <th>Тест олимпиады</th>
                            <th style="width: 15px"></th>
                            <th style="width: 15px"></th>
                            <th class="no-sort" style="width: 0px; text-align: center; padding-right: 16px; padding-left: 14px;" >
                                <input onclick="selectAllCheckbox(this)" style="font-size: 15px" type="checkbox" value="1"/>
                            </th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr>
                            <td></td>
                            <td>
                                <form>
                                    <input value="{{$request->olympiad_test_question_name}}" type="text" class="form-control" name="olympiad_test_question_name" placeholder="">
                                    <input value="{{$request->olympiad_test_question_level}}" type="hidden" class="form-control" name="olympiad_test_question_level" placeholder="">
                                    <input value="{{$request->olympiad_test_id}}" type="hidden" class="form-control" name="olympiad_test_id" placeholder="">
                                    <input value="{{$request->olympiad_test_name}}" type="hidden" class="form-control" name="olympiad_test_name" placeholder="">
                                     <input type="hidden" value="@if(!isset($request->active)){{'1'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->olympiad_test_question_name}}" type="hidden" class="form-control" name="olympiad_test_question_name" placeholder="">
                                    <input value="{{$request->olympiad_test_question_level}}" type="hidden" class="form-control" name="olympiad_test_question_level" placeholder="">
                                    <input value="{{$request->olympiad_test_id}}" type="hidden" class="form-control" name="olympiad_test_id" placeholder="">
                                    <input value="{{$request->olympiad_test_name}}" type="text" class="form-control" name="olympiad_test_name" placeholder="">
                                     <input type="hidden" value="@if(!isset($request->active)){{'1'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        @foreach($row as $key => $val)

                            <tr>
                                <td> {{ $key + 1 }}</td>
                                <td>
                                    {!! $val['olympiad_test_question_name_ru']!!}
                                </td>
                                <td>
                                    {{ $val['olympiad_test_name_ru']}}
                                </td>
                                <td style="text-align: center">
                                    <a href="javascript:void(0)" onclick="delItem(this,'{{ $val->olympiad_test_question_id }}','olympiad-test-question')">
                                        <i class="mdi mdi-delete" style="font-size: 20px; color: red;"></i>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="/admin/olympiad-test-question/{{ $val->olympiad_test_question_id }}/edit<?php if(isset($_GET['olympiad_test_id']))echo '?olympiad_test_id='.$_GET['olympiad_test_id'];?>"">
                                    <i class="mdi mdi-grease-pencil" style="font-size: 20px;"></i>
                                    </a>
                                </td>
                                <td style="text-align: center;">
                                    <input class="select-all" style="font-size: 15px" type="checkbox" value="{{$val->olympiad_test_question_id}}"/>
                                </td>
                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                    <div style="text-align: center">
                        {{ $row->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection


@section('css')

    <style>
        .table-bordered > tbody > tr > td,.table-bordered > tbody > tr > th {
            font-size: 14px !important;
            font-weight: 400 !important;
            color: #4B4B4B !important;
            font-family: Calibri;
        }
        .table-bordered > thead > tr > th {
            font-size: 14px !important;
            font-family: Calibri;
        }
        .f-15 {
            font-size: 13px;
        }
        .table img {
            display: none !important;
        }
    </style>

@endsection

@section('js')

    <script type="text/x-mathjax-config">
        MathJax.Hub.Config({
          tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
        });
    </script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML"></script>

   {{-- <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>
       --}}
    <script>
        function importExcel(){
            $('.ajax-loader').css('display','block');
            $("#import_excel").submit();
        }

        $("#import_excel").submit(function(event) {
            $('.ajax-loader').css('display','block');
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url:'/admin/olympiad-test-question/excel',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('.ajax-loader').css('display','none');
                    if(data.success == 0){
                        alert(data.error);
                        return;
                    }
                    location.reload();
                }
            });
        });
    </script>
@endsection
