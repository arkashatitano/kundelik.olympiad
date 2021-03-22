<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Chapter;
use App\Models\Lesson;
use App\Models\Test;
use App\Models\Subject;
use App\Models\UserENTTest;
use App\Models\UserEntTestAnswer;
use App\Models\UserOlympiadTest;
use App\Models\UserOlympiadTestAnswer;
use App\Models\UserSpecialTest;
use App\Models\UserSpecialTestAnswer;
use App\Models\UserTest;
use App\Models\UserTestAnswer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class AnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('main_menu', 'answer');

    }



    public function showUserOlympiadTest(Request $request)
    {
        View::share('menu', 'answer-olympiad-test');

        $row = UserOlympiadTest::leftJoin('olympiad_test','olympiad_test.olympiad_test_id','=','user_olympiad_test.olympiad_test_id')
            ->leftJoin('users','users.user_id','=','user_olympiad_test.user_id')
            ->orderBy('user_olympiad_test.created_at','desc')
            ->select(
                'users.name',
                'users.email',
                'users.phone',
                'olympiad_test.olympiad_test_name_ru',
                'user_olympiad_test.user_olympiad_test_id',
                'user_olympiad_test.is_success',
                'user_olympiad_test.score',
                'user_olympiad_test.created_at'
            );

        if(isset($request->test_name) && $request->test_name != ''){
            $row->where(function($query) use ($request){
                $query->where('olympiad_test_name_ru','like','%' .$request->test_name .'%');
            });
        }

        if(isset($request->user_name) && $request->user_name != ''){
            $row->where(function($query) use ($request){
                $query->where('users.name','like','%' .$request->user_name .'%')
                    ->orWhere('users.email','like','%' .$request->user_name .'%')
                    ->orWhere('users.phone','like','%' .Helpers::getPhoneFormat4($request->user_name) .'%');
            });
        }

        $row = $row->paginate(50);

        return  view('admin.answer-user.olympiad-test',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function showUserOlympiadTestById(Request $request,$id)
    {
        View::share('menu', 'answer-olympiad-test');

        $row = UserOlympiadTestAnswer::leftJoin('olympiad_test_question','olympiad_test_question.olympiad_test_question_id','=','user_olympiad_test_answer.olympiad_test_question_id')
            ->leftJoin('user_olympiad_test','user_olympiad_test.user_olympiad_test_id','=','user_olympiad_test_answer.user_olympiad_test_id')
            ->leftJoin('users','users.user_id','=','user_olympiad_test.user_id')
            ->where('user_olympiad_test.user_olympiad_test_id',$id)
            ->orderBy('user_olympiad_test_answer.created_at','asc')
            ->select(
                'users.name',
                'olympiad_test_question.*',
                'user_olympiad_test_answer.user_variant',
                'user_olympiad_test_answer.created_at',
                'user_olympiad_test_answer.is_correct'
            );

        $row = $row->paginate(100);

        return  view('admin.answer-user.olympiad-test-answer',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function showUserSpecialTest(Request $request)
    {
        View::share('menu', 'answer-special-test');

        $row = UserSpecialTest::leftJoin('special_test','special_test.special_test_id','=','user_special_test.special_test_id')
            ->leftJoin('users','users.user_id','=','user_special_test.user_id')
            ->orderBy('user_special_test.created_at','desc')
            ->select(
                'users.name',
                'users.email',
                'users.phone',
                'special_test.special_test_name_ru',
                'user_special_test.user_special_test_id',
                'user_special_test.is_success',
                'user_special_test.score',
                'user_special_test.created_at'
            );

        if(isset($request->test_name) && $request->test_name != ''){
            $row->where(function($query) use ($request){
                $query->where('special_test_name_ru','like','%' .$request->test_name .'%');
            });
        }

        if(isset($request->user_name) && $request->user_name != ''){
            $row->where(function($query) use ($request){
                $query->where('users.name','like','%' .$request->user_name .'%')
                    ->orWhere('users.email','like','%' .$request->user_name .'%')
                    ->orWhere('users.phone','like','%' .Helpers::getPhoneFormat4($request->user_name) .'%');
            });
        }

        $row = $row->paginate(50);

        return  view('admin.answer-user.special-test',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function showUserSpecialTestById(Request $request,$id)
    {
        View::share('menu', 'answer-special-test');

        $row = UserSpecialTestAnswer::leftJoin('special_test_question','special_test_question.special_test_question_id','=','user_special_test_answer.special_test_question_id')
            ->leftJoin('user_special_test','user_special_test.user_special_test_id','=','user_special_test_answer.user_special_test_id')
            ->leftJoin('users','users.user_id','=','user_special_test.user_id')
            ->where('user_special_test.user_special_test_id',$id)
            ->orderBy('user_special_test_answer.created_at','asc')
            ->select(
                'users.name',
                'special_test_question.*',
                'user_special_test_answer.user_variant',
                'user_special_test_answer.created_at',
                'user_special_test_answer.is_correct'
            );

        $row = $row->paginate(100);

        return  view('admin.answer-user.special-test-answer',[
            'row' => $row,
            'request' => $request
        ]);
    }
}
