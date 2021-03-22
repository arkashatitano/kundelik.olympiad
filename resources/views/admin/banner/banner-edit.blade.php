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
                <a href="/admin/banner" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Назад</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-block">
                        @if (isset($error))
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif
                        @if($row->banner_id > 0)
                            <form action="/admin/banner/{{$row->banner_id}}" method="POST">
                                <input type="hidden" name="_method" value="PUT">
                                @else
                            <form action="/admin/banner" method="POST">
                                @endif
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="banner_id" value="{{ $row->banner_id }}">
                                <input type="hidden" class="image-name" id="banner_image" name="banner_image" value="{{ $row->banner_image }}"/>

                                <div class="box-body">
                                    <div class="card-block">
                                        <div class="form-group">
                                            <label>Название</label>
                                            <input value="{{ $row->banner_name_ru }}" type="text" class="form-control" name="banner_name_ru" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label>Ссылка</label>
                                            <input value="{{ $row->banner_website }}" type="text" class="form-control" name="banner_website" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label>Позиция</label>
                                            <select name="section_id" data-placeholder="Выберите" class="form-control select2">
                                                <option></option>
                                                @foreach($sections as $item)
                                                    <option @if($item->section_id == $row->section_id) selected @endif value="{{$item->section_id}}">{{$item->section_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer" style="padding-top: 20px">
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="box box-primary" style="padding: 30px; text-align: center">
                            <p>главная картинка</p>
                            <div style="padding: 20px; border: 1px solid #c2e2f0">
                                <img class="image-src" src="{{ $row->banner_image }}" style="width: 100%; "/>
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
    <script src="/admin/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/admin/assets/plugins/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js" type="text/javascript"></script>
    <script src="/admin/assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <script>

        $('#date-format').bootstrapMaterialDatePicker({ format: 'DD.MM.YYYY HH:mm' });

        $(".select2").select2();

    </script>

@endsection



