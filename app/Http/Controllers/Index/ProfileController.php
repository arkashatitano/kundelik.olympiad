<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Mail\RegistrationEmail;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Contact;
use App\Models\Menu;
use App\Models\Page;


use App\Models\Region;
use App\Models\School;
use App\Models\Subject;
use App\Models\Subscription;
use App\Models\UserOlympiadTest;
use App\Models\UserRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Cookie;
use Auth;
use Illuminate\Support\Str;
use Mockery\CountValidator\Exception;


class ProfileController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->middleware('profile');
    }

    public function showProfile(Request $request)
    {
        return  view('index.profile.profile',
            [
                'row' => $request,
                'sidebar' => 'profile'
            ]);
    }

    public function showTestList(Request $request)
    {
        $test_list = UserOlympiadTest::leftJoin('olympiad_test','olympiad_test.olympiad_test_id','=','user_olympiad_test.olympiad_test_id')
            ->where('user_olympiad_test.user_id',Auth::user()->user_id)
            ->orderBy('user_olympiad_test_id','desc')
            ->select('user_olympiad_test.*',
                   'olympiad_test.olympiad_test_name_ru'
                )
            ->get();

        return  view('index.profile.test.test-list',
            [
                'row' => $request,
                'test_list' => $test_list,
                'sidebar' => 'olympiad'
            ]);
    }

    public function showHistory(Request $request)
    {
        $payment_list = UserRequest::leftJoin('user_olympiad_test','user_olympiad_test.user_request_id','=','user_request.user_request_id')
            ->leftJoin('olympiad_test','olympiad_test.olympiad_test_id','=','user_olympiad_test.olympiad_test_id')
            ->where('user_request.user_id',Auth::user()->user_id)
            ->orderBy('user_request_id','desc')
            ->select('user_request.*',
                'olympiad_test.olympiad_test_name_ru'
                )
            ->get();

        return  view('index.profile.history.history',
            [
                'row' => $request,
                'payment_list' => $payment_list,
                'sidebar' => 'history'
            ]);
    }

    public function editProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::user()->user_id .',user_id,deleted_at,NULL',
            'user_name' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['status'] = false;
            $result['error'] = $error[0];
            return response()->json($result);
        }


        try {

            $users = Users::where('user_id',Auth::user()->user_id)->first();
            $users->email = $request->email;
            $users->phone = $request->phone;
            $users->name = $request->user_name;
            $users->save();

            $result['status'] = true;
            $result['message'] = "Успешно сохранено";
            return response()->json($result);

        } catch (Exception $ex) {
            $result['status'] = false;
            $result['error'] = "Ошибка база данных";
            return response()->json($result);
        }
    }

    public function showPasswordEdit(Request $request)
    {
        return  view('index.profile.password-edit',
            [
                'row' => $request,
                'sidebar' => 'password'
            ]);
    }

    public function editPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required|different:password',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['status'] = false;
            $result['error'] = $error[0];
            return response()->json($result);
        }

        try {

            $user = Users::where('user_id','=',Auth::user()->user_id)->first();
            $count = Hash::check($request->password, $user->password);
            if($count == false){
                $result['status'] = false;
                $result['error'] = 'Неправильный старый пароль';
                return response()->json($result);
            }

            $user = Users::where('user_id','=',Auth::user()->user_id)->first();
            $user->password = Hash::make($request->new_password);
            $user->save();

            $result['status'] = true;
            return response()->json($result);

        } catch (Exception $ex) {
            $result['status'] = false;
            $result['error'] = "Ошибка база данных";
            return response()->json($result);
        }
    }

    public function showReferral(Request $request)
    {
        $menu = Cache::remember('menu_referral_'.$this->lang, 1440, function () {
            return Menu::where('is_show',1)
                ->where('menu_redirect','/referral')
                ->select(
                    'menu_name_'.$this->lang,
                    'menu_text_'.$this->lang,
                    'menu_meta_title_'.$this->lang,
                    'menu_meta_description_'.$this->lang,
                    'menu_meta_keywords_'.$this->lang
                )
                ->first();
        });

        if($menu == null) abort(404);


        return  view('new.profile.referral.referral',
            [
                'row' => $request,
                'menu' => $menu
            ]);
    }

}
