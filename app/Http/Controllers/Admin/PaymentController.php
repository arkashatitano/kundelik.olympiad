<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Comment;
use App\Models\News;
use App\Models\Faculty;
use App\Models\Operation;
use App\Models\Review;
use App\Models\Rubric;
use App\Models\Subscription;
use App\Models\UserRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('main_menu', 'operation');
        View::share('menu', 'payment');
    }

    public function index(Request $request)
    {
        $row = UserRequest::leftJoin('users','users.user_id','=','user_request.user_id')
                        ->leftJoin('payment_type','payment_type.payment_type_id','=','user_request.payment_type_id')
                        ->orderBy('user_request.created_at','desc')
                        ->where('user_request.is_pay',1)
                        ->select(
                            'user_request.is_use_bonus',
                            'user_request.used_bonus',
                            'user_request.is_purse',
                            'user_request.is_pay',
                            'user_request.is_success',
                            'user_request.cost',
                            'user_request.transaction_number',
                            'user_request.user_request_id',
                            'payment_type.payment_type_id',
                            'payment_type.payment_type_name_ru',
                            'users.name as user_name',
                            'users.avatar',
                            'users.email',
                            'users.phone',

                            DB::raw('DATE_FORMAT(user_request.created_at,"%d.%m.%Y") as date')
                            );

        if($request->range_from != ''){
            $row->where('user_request.cost','>=',$request->range_from);
        }

        if($request->range_to != ''){
            $row->where('user_request.cost','<=',$request->range_to);
        }

        if(isset($request->user_name) && $request->user_name != ''){
            $row->where(function($query) use ($request){
                $query->where('users.name','like','%' .$request->user_name .'%')
                      ->orWhere('users.email','like','%' .$request->user_name .'%')
                      ->orWhere('users.user_id',$request->user_name)
                      ->orWhere('users.phone','like','%' .Helpers::getPhoneFormat4($request->user_name) .'%');
            });
        }

        if(isset($request->payment_type_name) && $request->payment_type_name != ''){
            $row->where(function($query) use ($request){
                $query->where('payment_type.payment_type_name_ru','like','%' .$request->payment_type_name .'%');
            });
        }


        if(isset($request->user_request_id) && $request->user_request_id != ''){
            $row->where(function($query) use ($request){
                $query->where('user_request.user_request_id',$request->user_request_id);
            });
        }

        if(isset($request->transaction_number) && $request->transaction_number != ''){
            $row->where(function($query) use ($request){
                $query->where('user_request.transaction_number',$request->transaction_number);
            });
        }

        if($request->date_from != ''){
            $row->where('user_request.created_at','>=',date("Y-m-d 00:00", strtotime($request->date_from)));
        }

        if($request->date_to != ''){
            $row->where('user_request.created_at','<=',date("Y-m-d 23:59", strtotime($request->date_to)));
        }

        $total_sum = clone ($row);

        $total_sum->where(function($query) {
            $query->whereIn('user_request.payment_type_id',[2,3,7]);
        });

        $total_sum = $total_sum->sum('user_request.cost');

        $row = $row->paginate(20);

        return  view('admin.operation.payment',[
            'row' => $row,
            'request' => $request,
            'total_sum' => $total_sum
        ]);
    }




}
