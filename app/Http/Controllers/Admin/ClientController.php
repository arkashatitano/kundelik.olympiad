<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Cathedra;
use App\Models\Operation;
use App\Models\Region;
use App\Models\Role;
use App\Models\UserRegion;
use App\Models\UserRequest;
use App\Models\Users;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Mockery\CountValidator\Exception;
use View;
use DB;
use Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'client');

        $roles = Role::orderBy('role_id','asc')->get();
        View::share('roles', $roles);

        $users = Cache::remember('user_list_5', 1440, function () {
            return Users::where('role_id',5)->select('user_id','name')->get();
        });

        View::share('users', $users);

    }

    public function index(Request $request)
    {
        $row = Users::leftJoin('region','region.region_id','=','users.region_id')
            ->leftJoin('region as parent_region','parent_region.region_id','=','region.parent_id')
            ->leftJoin('role','role.role_id','=','users.role_id')
            ->orderBy('users.user_id','desc')
            ->select(
                'users.user_id',
                'users.name',
                'users.email',
                'users.phone',
                'users.avatar',
                'users.role_id',
                'users.money',
                'users.bonus',
                'users.is_confirm_email',
                'role.role_name_ru',
                'region.region_name_ru',
                'parent_region.region_name_ru as parent_region_name_ru',
                DB::raw('DATE_FORMAT(users.created_at,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('users.is_ban',$request->active);
        else $row->where('users.is_ban','0');

        if(isset($request->client_id) && $request->client_id != ''){
            $row->where(function($query) use ($request){
                $query->where('users.user_id',$request->client_id);
            });
        }

        if(isset($request->client_name) && $request->client_name != ''){
            $row->where(function($query) use ($request){
                $query->where('name','like','%' .$request->client_name .'%');
            });
        }

        if(isset($request->region_name) && $request->region_name != ''){
            $row->where(function($query) use ($request){
                $query->where('region_name_ru','like','%' .$request->region_name .'%');
            });
        }

        if(isset($request->email) && $request->email != ''){
            $row->where(function($query) use ($request){
                $query->where('email','like','%' .$request->email .'%');
            });
        }

        if(isset($request->phone) && $request->phone != ''){
            $row->where(function($query) use ($request){
                $query->where('phone','like','%' .Helpers::getPhoneFormat4($request->phone) .'%');
            });
        }

        if(isset($request->role) && $request->role != ''){
            $row->where(function($query) use ($request){
                $query->where('role_name_ru','like','%' .$request->role .'%');
            });
        }

        $row = $row->paginate(100);


        return  view('admin.client.client',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Users();
        $row->avatar = '/admin/img/avatar.jpg';
        $row->region_id = array();

        return  view('admin.client.client-edit', [
            'title' => 'Добавить пользователя',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,NULL,user_id,deleted_at,NULL',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.client.client-edit', [
                'title' => 'Добавить пользователя',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $client = new Users();
        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->user_desc = $request->user_desc;
        $client->avatar = $request->avatar;
        $client->email = $request->email;
        $client->password = Hash::make('12345');
        $client->role_id = $request->role_id;
        $client->save();



        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'users';
        $action->action_text_ru = 'добавил(а) пользователя "' .$client->name .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $client->user_id;
        $action->save();

        Helpers::setInfoText();


        if($client->role_id == 8 || $client->role_id == 9)
            return redirect('/admin/kindergarten');
        elseif($client->role_id == 5 || $client->role_id == 7)
            return redirect('/admin/partner');

        return redirect('/admin/client');
    }

    public function edit($id)
    {
        $row = Users::find($id);

        return  view('admin.client.client-edit', [
            'title' => 'Редактировать данные пользователя',
            'row' => $row
        ]);
    }


    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' .$id .',user_id,deleted_at,NULL',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.client.client-edit', [
                'title' => 'Редактировать данные пользователя',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $client = Users::find($id);
        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->user_desc = $request->user_desc;
        $client->avatar = $request->avatar;
        $client->email = $request->email;
        $client->role_id = $request->role_id;
        $client->save();


        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'users';
        $action->action_text_ru = 'редактировал(а) данные пользователя "' .$client->name .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $client->user_id;
        $action->save();



        if($client->role_id == 8 || $client->role_id == 9)
             return redirect('/admin/kindergarten');
        elseif($client->role_id == 5 || $client->role_id == 7)
             return redirect('/admin/partner');

        return redirect('/admin/client');
    }

    public function destroy($id)
    {
        $client = Users::find($id);
        $client->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'users';
        $action->action_text_ru = 'удалил(а) пользователя "' .$client->name .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();



    }

    public function resetPassword(Request $request,$user_id){
        $client = Users::find($user_id);
        $client->password = Hash::make('12345');
        $client->save();

        $action = new Actions();
        $action->action_comment = 'user';
        $action->action_text_ru = 'сбросил пароль пользователя "' .$client->name .'"';
        $action->action_code_id = 8;
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $client->user_id;
        $action->save();

        $url = '';
        if($request->page > 0) $url = '?page='.$request->page;
        return redirect('/admin/client'.$url);
    }

    public function getClientPhoneById(Request $request){
        $client = Users::where('user_id',$request->user_id)->select('user_id','is_confirm_phone')->first();

        if($client == null){
            $result['status'] = false;
            return response()->json($result);
        }

        return  view('admin.client.modal', [
            'row' => $client
        ]);
    }


}
