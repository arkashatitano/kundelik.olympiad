
    @extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0" >
                    Сменить пароль
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-block">
                        @if (isset($error))
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif
                                    <form action="/admin/password" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Старый пароль</label>
                                                <input value="" type="password" class="form-control" name="old_password" placeholder="Введите">
                                            </div>
                                            <div class="form-group">
                                                <label>Новый пароль</label>
                                                <input value="" type="password" class="form-control" name="new_password" placeholder="Введите">
                                            </div>
                                            <div class="form-group">
                                                <label>Подтвердите пароль</label>
                                                <input value="" type="password" class="form-control" name="confirm_password" placeholder="Введите">
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






