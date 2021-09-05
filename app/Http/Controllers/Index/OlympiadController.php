<?php

namespace App\Http\Controllers\Index;


use App\Classes\SendPulseApiSender;
use App\Http\Helpers;
use App\Mail\DemoEmail;
use App\Models\Book;
use App\Models\Contact;
use App\Models\Idea;
use App\Models\Magazine;
use App\Models\MainPage;
use App\Models\Menu;
use App\Models\OlympiadTest;
use App\Models\OlympiadTestQuestion;
use App\Models\Operation;
use App\Models\Program;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Page;
use App\Models\Review;
use App\Models\Speciality;
use App\Models\Subject;
use App\Models\UserLike;
use App\Models\UserOlympiadTest;
use App\Models\UserOlympiadTestAnswer;
use App\Models\UserRequest;
use Illuminate\Support\Facades\Cache;
use App\Models\Partner;
use App\Models\Policy;
use App\Models\Slider;
use App\Models\Users;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Mockery\CountValidator\Exception;
use Unisender\ApiWrapper\UnisenderApi;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Cookie;
use Lang;



class OlympiadController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = Helpers::getSessionLang();
        $this->middleware('profile')->only(['showTestById']);
    }

    public function payTest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'olympiad_test_id' => 'required',
            'payment_type' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            $result['error'] = $error[0];
            $result['status'] = false;
            return response()->json($result);
        }

        if(!Auth::check()){
            $result['redirect'] = '/auth/login';
            $result['status'] = true;
            return response()->json($result);
        }

        $olympiad_test = OlympiadTest::where('olympiad_test_id',$request->olympiad_test_id)->first();

        if($olympiad_test == null){
            $result['error'] = 'Ондай тест табылмады';
            $result['status'] = false;
            return response()->json($result);
        }

        $user_olympiad_test = UserOlympiadTest::where('user_id',Auth::user()->user_id)
            ->where('created_at','>=',date('Y-m-d H:i', strtotime('-'.$olympiad_test->olympiad_test_duration.' min')))
            ->where('olympiad_test_id',$request->olympiad_test_id)
            ->where('is_success',0)
            ->first();

        if($user_olympiad_test != null){
            $result['redirect'] = '/test/'.$olympiad_test->olympiad_test_id.'/'.$user_olympiad_test->user_olympiad_test_id;
            $result['status'] = true;
            return response()->json($result);
        }

        $operation = new Operation();
        $operation->user_id = Auth::user()->user_id;
        $operation->score = -1 * $olympiad_test->olympiad_test_cost;
        $operation->is_active = 1;
        $operation->operation_type_id = 1;
        $operation->save();

        $user_request = new UserRequest();
        $user_request->user_id = Auth::user()->user_id;
        $user_request->hash = md5(uniqid(time(), true));
        $user_request->cost = $olympiad_test->olympiad_test_cost;
        $user_request->payment_type_id = $request->payment_type_id;
        $user_request->is_success = 1;
        $user_request->is_pay = 1;
        $user_request->save();

        $user_olympiad_test = new UserOlympiadTest();
        $user_olympiad_test->user_request_id = isset($user_request->user_request_id)?$user_request->user_request_id:null;
        $user_olympiad_test->olympiad_test_id = $request->olympiad_test_id;
        $user_olympiad_test->user_id = Auth::user()->user_id;
        $user_olympiad_test->save();

        $result['redirect'] = '/test/'.$olympiad_test->olympiad_test_id.'/'.$user_olympiad_test->user_olympiad_test_id;
        $result['status'] = true;
        return response()->json($result);
    }

    public function showTestById(Request $request,$olympiad_test_id,$user_olympiad_test_id)
    {
        $olympiad = OlympiadTest::orderBy('sort_num','asc')
            ->where('olympiad_test_id',$olympiad_test_id)
            ->select(
                'olympiad_test.*'
            );

        if(!Auth::check() || Auth::user()->role_id != 1) $olympiad->where('is_show',1);

        $olympiad = $olympiad->first();

        if ($olympiad == null) abort(404);

        $user_olympiad_test = UserOlympiadTest::where('user_id',Auth::user()->user_id)
            ->where('user_olympiad_test_id',$user_olympiad_test_id)
            ->first();

        if($user_olympiad_test == null) abort(404);
        elseif($user_olympiad_test->is_success == 1){
            return redirect('/olympiad/result/'.$user_olympiad_test->user_olympiad_test_id);
        }

        if($olympiad->is_show_level == 1){
            if($olympiad->olympiad_test_question_count == 0) $olympiad->olympiad_test_question_count = 3;

            $olympiad_test_question_count = (int) ($olympiad->olympiad_test_question_count / 3);
            $a_question_count = $olympiad_test_question_count;
            $b_question_count = $olympiad_test_question_count;
            $c_question_count = $olympiad_test_question_count;

            if($olympiad->olympiad_test_question_count != ($a_question_count + $b_question_count + $c_question_count)){
                $a_question_count = $olympiad->olympiad_test_question_count - ($b_question_count + $c_question_count);
            }

            $a_question_list = OlympiadTestQuestion::where('is_show',1)
                ->orderByRaw('RAND()')
                ->where('olympiad_test_question_level','a')
                ->where('olympiad_test_id',$olympiad->olympiad_test_id)
                ->take($a_question_count)
                ->get();

            $b_question_list = OlympiadTestQuestion::where('is_show',1)
                ->orderByRaw('RAND()')
                ->where('olympiad_test_question_level','b')
                ->where('olympiad_test_id',$olympiad->olympiad_test_id)
                ->take($b_question_count)
                ->get();

            $question_list = $a_question_list->merge($b_question_list); // Contains foo and bar.

            $c_question_list = OlympiadTestQuestion::where('is_show',1)
                ->orderByRaw('RAND()')
                ->where('olympiad_test_question_level','c')
                ->where('olympiad_test_id',$olympiad->olympiad_test_id)
                ->take($c_question_count)
                ->get();

            $question_list = $question_list->merge($c_question_list); // Contains foo and bar.

            $question_list = $question_list->shuffle();
        }
        else {
            $question_list = OlympiadTestQuestion::where('is_show',1)
                ->orderByRaw('RAND()')
                ->where('olympiad_test_id',$olympiad->olympiad_test_id)
                ->take($olympiad->olympiad_test_question_count)
                ->get();
        }

        $special_question_list = OlympiadTestQuestion::where('is_show',1)
            ->orderByRaw('RAND()')
            ->whereNull('olympiad_test_id')
            ->take($olympiad->special_question_count)
            ->get();

        $question_list = $question_list->merge($special_question_list); // Contains foo and bar.

        $question_list = $question_list->shuffle();

        $deadline_time = date('Y-m-d H:i:s', strtotime('+'.$olympiad->olympiad_test_duration.' minutes', strtotime($user_olympiad_test->created_at)));
        $now_date = date('Y-m-d H:i:s');

        return  view('index.olympiad.olympiad',
            [
                'olympiad' => $olympiad,
                'special_question_list' => $special_question_list,
                'question_list' => $question_list,
                'user_olympiad_test_id' => $user_olympiad_test_id,
                'date' => $deadline_time,
                'now_date' => $now_date,
                'row' => $request
            ]);
    }

    public function showTestRule(Request $request,$olympiad_test_id){

        $olympiad = OlympiadTest::orderBy('sort_num','asc')
            ->where('olympiad_test_id',$olympiad_test_id)
            ->select(
                'olympiad_test.*'
            );

        if(!Auth::check() || Auth::user()->role_id != 1) $olympiad->where('is_show',1);

        $olympiad = $olympiad->first();

        if($olympiad == null) abort(404);
        
        return view('index.olympiad.rule',
            [
                'olympiad' => $olympiad
            ]);

    }
    public function submitTest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_olympiad_test_id' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            $result['error'] = $error[0];
            $result['status'] = false;
            return response()->json($result);
        }

        if(!Auth::check()){
            $result['error'] = Lang::get('app.must_login_done_test');
            $result['status'] = false;
            return response()->json($result);
        }

       /* foreach($request->questions as $key => $item){
            if(!isset($request['answers'][$key]) || $request['answers'][$key] == ''){
                $result['error'] = Lang::get('app.must_done_all_question');
                $result['status'] = false;
                return response()->json($result);
            }
        }*/

        $correct_answer = 0;

        $user_olympiad_test = UserOlympiadTest::where('user_id',Auth::user()->user_id)
            ->where('user_olympiad_test_id',$request->user_olympiad_test_id)
            ->first();

        if($user_olympiad_test == null) {
            $result['error'] = 'Такого теста не существует (код 1)';
            $result['status'] = false;
            return response()->json($result);
        }
        elseif($user_olympiad_test->is_success == 1){
            $result['redirect'] = '/profile/test';
            $result['status'] = true;
            return response()->json($result);
        }

        $olympiad = OlympiadTest::orderBy('sort_num','asc')
            ->where('olympiad_test_id',$user_olympiad_test->olympiad_test_id)
            ->select('olympiad_test.*')
            ->first();

        if ($olympiad == null) {
            $result['error'] = 'Такого теста не существует';
            $result['status'] = false;
            return response()->json($result);
        }

        if(isset($request->questions[0])){
            foreach($request->questions as $key => $item){
                if(isset($request['answers'][$key])){
                    $check_answer = OlympiadTestQuestion::where('olympiad_test_question_id',$item)->where('correct_variant',$request['answers'][$key])->count();

                    $user_olympiad_test_answer = new UserOlympiadTestAnswer();
                    $user_olympiad_test_answer->olympiad_test_question_id = $item;
                    $user_olympiad_test_answer->user_olympiad_test_id = $user_olympiad_test->user_olympiad_test_id;
                    $user_olympiad_test_answer->user_id = Auth::user()->user_id;
                    $user_olympiad_test_answer->user_variant = $request['answers'][$key];

                    if($check_answer > 0){
                        $correct_answer++;
                        $user_olympiad_test_answer->is_correct = 1;
                    }
                    $user_olympiad_test_answer->save();
                }

            }
        }

        if($correct_answer >= $olympiad->min_point_to_first_place){
            $user_olympiad_test->is_has_diploma = 1;
        }
        elseif($correct_answer >= $olympiad->min_point_to_second_place){
            $user_olympiad_test->is_has_diploma = 2;
        }
        elseif($correct_answer >= $olympiad->min_point_to_diploma){
            $user_olympiad_test->is_has_diploma = 1;
        }

        $user_olympiad_test->is_success = 1;
        $user_olympiad_test->score = $correct_answer;

        $seconds = abs(strtotime($user_olympiad_test->updated_at) - strtotime($user_olympiad_test->created_at));
        $user_olympiad_test->spent_second = $seconds;
        $user_olympiad_test->save();


        $result['redirect'] = '/profile/test';
        $result['status'] = true;
        return response()->json($result);
    }

}
