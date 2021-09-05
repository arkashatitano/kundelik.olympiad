<?php

namespace App\Http\Controllers\Index;

use App\Classes\SendPulseApiSender;
use App\Http\Helpers;

use App\Mail\Registration;
use App\Mail\RegistrationEmail;
use App\Mail\ResetPasswordEmail;
use App\Mail\SendNewPasswordEmail;
use App\Models\Banner;
use App\Models\EmailHistory;
use App\Models\Info;
use App\Models\Menu;
use App\Models\Region;
use App\Models\School;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Cookie;
use Hash;
use Auth;
use View;
use Illuminate\Support\Str;
use Mockery\CountValidator\Exception;


class AuthController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {

    }

    public function showLogin(Request $request)
    {
        if (Auth::check()) return redirect('/profile');

        $menu = Cache::remember('menu_login_'.$this->lang, 1440, function () {
            return Menu::where('is_show',1)
                ->where('menu_redirect','/auth/login')
                ->select(
                         'menu_name_'.$this->lang,
                         'menu_meta_title_'.$this->lang,
                         'menu_meta_description_'.$this->lang,
                         'menu_meta_keywords_'.$this->lang
                    )
                ->first();
        });

        if($menu == null) abort(404);

        return  view('index.auth.login',
            [
                'row' => $request,
                'menu' => $menu
            ]);
    }

    public function showRegister(Request $request)
    {
        if (Auth::check()) return redirect('/profile');

        $menu = Cache::remember('menu_register_'.$this->lang, 1440, function () {
            return Menu::where('is_show',1)
                ->where('menu_redirect','/auth/register')
                ->select(
                    'menu_name_'.$this->lang,
                    'menu_meta_title_'.$this->lang,
                    'menu_meta_description_'.$this->lang,
                    'menu_meta_keywords_'.$this->lang
                )
                ->first();
        });

        if($menu == null) abort(404);

        return  view('index.auth.register',
            [
                'row' => $request,
                'menu' => $menu
            ]);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,NULL,user_id,deleted_at,NULL',
            'user_name' => 'required',
            'password' => 'required|min:5',
            'confirm_password' => 'required|min:5|same:password',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['status'] = false;
            $result['error'] = $error[0];
            return response()->json($result);
        }

        try {

            $users = new Users();
            $users->email = $request->email;
            $users->name = $request->user_name;
            $users->role_id = 3;
            $users->password = Hash::make($request->password);
            $users->save();

            $userdata = array(
                'email' => $request->email,
                'password' => $request->password
            );

            if (!Auth::attempt($userdata))
            {
                $result['status'] = false;
                $result['error'] = "Ошибка";
                return response()->json($result);
            }

        } catch (Exception $ex) {
            $result['status'] = false;
            $result['error'] = "Ошибка база данных";
            return response()->json($result);
        }
    }

    public function login(Request $request){
        $menu = Cache::remember('menu_login_'.$this->lang, 1440, function () {
            return Menu::where('is_show',1)
                ->where('menu_redirect','/auth/login')
                ->select(
                    'menu_name_'.$this->lang,
                    'menu_meta_title_'.$this->lang,
                    'menu_meta_description_'.$this->lang,
                    'menu_meta_keywords_'.$this->lang
                )
                ->first();
        });

        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            return  view('index.auth.login', [
                'error' => "Керекті деректерді толтырыңыз",
                'menu' => $menu,
            ]);
        }

        try {
            $userdata = array(
                'email' => trim($request->login),
                'password' => trim($request->password)
            );

            if (!Auth::attempt($userdata))
            {
                $error = 'Неправильный логин или пароль';

                return  view('index.auth.login', [
                    'error' => $error,
                    'menu' => $menu
                ]);
            }

            if(Auth::user()->role_id == 1)
                return redirect('/admin/menu');

            return redirect('/');
        }
        catch(Exception $ex){
            return  view('index.auth.login', [
                'error' => 'Ошибка'
            ]);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }


    public function loginAjax(Request $request){
        if(Auth::check()){
            $result['redirect'] = '/profile';
            $result['status'] = true;
            return response()->json($result);
        }

        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['error'] = $error[0];
            $result['status'] = false;
            return response()->json($result);
        }

        try {
            $userdata = array(
                'email' => trim($request->login),
                'password' => trim($request->password)
            );

            if (!Auth::attempt($userdata))
            {
                $error = 'Логиныңыз немесе құпия сөзіңізде қате бар';

                $result['error'] = $error;
                $result['status'] = false;
                return response()->json($result);
            }

            if(Auth::user()->is_ban == 1){
                Auth::logout();

                $result['error'] = 'Вас заблокировали';
                $result['status'] = false;
                return response()->json($result);
            }

            $result['redirect'] = '/';
            $result['status'] = true;
            return response()->json($result);
        }
        catch(Exception $ex){
            return  view('new.index.auth.login', [
                'error' => 'Ошибка'
            ]);
        }
    }
}
