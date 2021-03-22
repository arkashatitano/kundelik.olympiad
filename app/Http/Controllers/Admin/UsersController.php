<?php

namespace App\Http\Controllers\Admin;

use App\Models\Actions;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use DB;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('admin')->except(['password']);
        View::share('menu', 'admin');
    }

    public function index(Request $request)
    {
        $row = Users::orderBy('users.user_id','desc')
                    ->where('role_id',1)
                    ->select('*',
                             DB::raw('DATE_FORMAT(users.created_at,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('users.is_ban',$request->active);
        else $row->where('users.is_ban','0');

        if(isset($request->name) && $request->name != ''){
            $row->where(function($query) use ($request){
                $query->where('name','like','%' .$request->name .'%');
            });
        }

        if(isset($request->login) && $request->login != ''){
            $row->where(function($query) use ($request){
                $query->where('email','like','%' .$request->login .'%');
            });
        }

        $row = $row->paginate(20);

        return  view('admin.users.users',[
            'row' => $row,
            'title' => 'Администратор',
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Users();
        $row->avatar = '/admin/img/avatar.jpg';


        return  view('admin.users.users-edit', [
                'title' => 'Новый администратор',
                'row' => $row
            ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,NULL,user_id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.users.users-edit', [
                'title' => 'Добавить преподавателя',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $user = new Users();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar = $request->avatar;
        $user->sort_num = is_numeric($request->sort_num)?$request->sort_num:1000;
        $user->password = Hash::make('12345');
        $user->role_id = 1;
        $user->save();


        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'users';
        $action->action_text_ru = 'добавил(а) администратора "' .$user->name .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $user->user_id;
        $action->save();

        return redirect('/admin/user');
    }

    public function edit($id)
    {
        $row = Users::find($id);
        return  view('admin.users.users-edit', [
            'title' => 'Изменить пользователя',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' .$id .',user_id',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.users.users-edit', [
                'title' => 'Редактировать данные администратора',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $user = Users::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar = $request->avatar;
        $user->sort_num = is_numeric($request->sort_num)?$request->sort_num:1000;
        $user->save();

        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'users';
        $action->action_text_ru = 'редактировал(а) данные администратора "' .$user->name .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $user->user_id;
        $action->save();

        return redirect('/admin/user');

    }

    public function destroy($id)
    {
        $user = Users::find($id);
        $user->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'users';
        $action->action_text_ru = 'удалил(а) администратора "' .$user->name .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function resetPassword(Request $request,$user_id){
        $user = Users::find($user_id);
        $user->password = Hash::make('12345');
        $user->save();

        $action = new Actions();
        $action->action_comment = 'user';
        $action->action_text_ru = 'сбросил пароль администратора "' .$user->name .'"';
        $action->action_code_id = 8;
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $user->user_id;
        $action->save();

        $url = '';
        if($request->page > 0) $url = '?page='.$request->page;
        return redirect('/admin/user'.$url);
    }

    public function password(Request $request){
        View::share('menu', 'password');
        if(isset($request->old_password)){
            $user = Users::where('user_id','=',Auth::user()->user_id)->first();
            $count = Hash::check($request->old_password, $user->password);
            if($count == false){
                return  view('admin.users.password-edit',[
                    'error' => 'Неправильный старый пароль'
                ]);
            }

            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|different:old_password',
                'confirm_password' => 'required|same:new_password',
            ]);

            if ($validator->fails()) {
                $messages = $validator->errors();
                $error = $messages->all();
                return  view('admin.users.password-edit', [
                    'error' => $error[0]
                ]);
            }

            $user = Users::where('user_id','=',Auth::user()->user_id)->first();
            $user->password = Hash::make($request->new_password);
            $user->save();

            return  view('admin.users.password-edit', [
                'error' => 'Успешно изменен'
            ]);
        }
        return  view('admin.users.password-edit');
    }

    public function changeIsBan(Request $request){
        $review = Users::find($request->id);
        $review->is_ban = $request->is_show;
        $review->save();
    }
}
