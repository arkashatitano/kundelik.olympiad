<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Operation;
use App\Models\Review;
use App\Models\Subject;
use App\Models\UserRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;
use View;
use DB;
use Auth;

class OperationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('main_menu', 'operation');
        View::share('menu', 'operation');
    }

    public function index(Request $request)
    {
        $row = Operation::leftJoin('users','users.user_id','=','operation.user_id')
                        ->leftJoin('region','region.region_id','=','users.region_id')
                        ->leftJoin('operation_type','operation_type.operation_type_id','=','operation.operation_type_id')
                        ->leftJoin('users as sender','sender.user_id','=','operation.sender_user_id')
                        ->leftJoin('users as recipient','recipient.user_id','=','operation.recipient_user_id')
                        ->orderBy('operation.updated_at','desc')
                        ->where('operation.is_active','1')
                        ->select(
                            'operation.score',
                            'operation.percent',
                            'operation.comment',
                            'operation_type.operation_type_name_ru',
                            'sender.name as sender_user_name',
                            'recipient.name as recipient_user_name',
                            'users.name as user_name',
                            'users.avatar',
                            'users.email',
                            'users.phone',
                            'region.region_id',
                            'region.region_name_ru',
                            DB::raw('DATE_FORMAT(operation.updated_at,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->user_name) && $request->user_name != ''){
            $row->where(function($query) use ($request){
                $query->where('users.name','like','%' .$request->user_name .'%')
                    ->orWhere('users.email','like','%' .$request->user_name .'%')
                    ->orWhere('users.phone','like','%' .Helpers::getPhoneFormat4($request->user_name) .'%');
            });
        }

        if(isset($request->operation_type_name) && $request->operation_type_name != ''){
            $row->where(function($query) use ($request){
                $query->where('operation_type.operation_type_name_ru','like','%' .$request->operation_type_name .'%');
            });
        }

        if(isset($request->comment) && $request->comment != ''){
            $row->where(function($query) use ($request){
                $query->where('operation.comment','like','%' .$request->comment .'%')
                     ->orWhere('sender.name','like','%' .$request->comment .'%');
            });
        }

        if($request->date_from != ''){
            $row->where('operation.created_at','>=',date("Y-m-d 00:00", strtotime($request->date_from)));
        }

        if($request->date_to != ''){
            $row->where('operation.created_at','<=',date("Y-m-d 23:59", strtotime($request->date_to)));
        }

        $row = $row->paginate(20);

        return  view('admin.operation.operation',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function sendOrdaList(Request $request)
    {
        View::share('menu', 'send-daryn-list');

        $row = UserRequest::leftJoin('users','users.user_id','=','user_request.user_id')
            ->leftJoin('region','region.region_id','=','users.region_id')
            ->leftJoin('users as sender','sender.user_id','=','user_request.sender_user_id')
            ->where('user_request.payment_type_id',5)
            ->orderBy('user_request.updated_at','desc')
            ->select(
                'user_request.cost',
                'user_request.is_success',
                'user_request.user_request_id',
                'sender.name as sender_user_name',
                'sender.email as sender_email',
                'sender.phone as sender_phone',
                'users.name as user_name',
                'users.avatar',
                'users.email',
                'users.phone',
                'region.region_id',
                'region.region_name_ru',
                DB::raw('DATE_FORMAT(user_request.updated_at,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->recipient_name) && $request->recipient_name != ''){
            $row->where(function($query) use ($request){
                $query->where('users.name','like','%' .$request->recipient_name .'%')
                    ->orWhere('users.email','like','%' .$request->recipient_name .'%')
                    ->orWhere('users.phone','like','%' .Helpers::getPhoneFormat4($request->recipient_name) .'%');
            });
        }

        if(isset($request->sender_name) && $request->sender_name != ''){
            $row->where(function($query) use ($request){
                $query->where('sender.name','like','%' .$request->sender_name .'%')
                    ->orWhere('sender.email','like','%' .$request->sender_name .'%')
                    ->orWhere('sender.phone','like','%' .Helpers::getPhoneFormat4($request->sender_name) .'%');
            });
        }

        if($request->date_from != ''){
            $row->where('user_request.created_at','>=',date("Y-m-d 00:00", strtotime($request->date_from)));
        }

        if($request->date_to != ''){
            $row->where('user_request.created_at','<=',date("Y-m-d 23:59", strtotime($request->date_to)));
        }


        $total_sum = clone ($row);

        $total_sum = $total_sum->where('user_request.is_success',1)->sum('user_request.cost');

        $row = $row->paginate(20);

        return  view('admin.operation.send-score-operation',[
            'row' => $row,
            'total_sum' => $total_sum,
            'request' => $request
        ]);
    }

    public function showSendOrda()
    {
        View::share('menu', 'send-daryn');

        $partners = Users::orderBy('name','asc')->where('role_id',5)->get();
        View::share('partners', $partners);

        return  view('admin.operation.send-score');
    }

    public function sendOrda(Request $request)
    {
        if($request->partner_id != '' && $request->partner_id > 0){
            $client = Users::where('user_id',$request->partner_id)->first();
        }
        else {
            $client = Users::where('email',$request->email)->first();
        }

        if($client == null){
            $result['status'] = false;
            $result['error'] = 'Такого пользователя не существует';
            return response()->json($result);
        }

        if($client->user_id == Auth::user()->user_id){
            $result['status'] = false;
            $result['error'] = 'Вы не можете себе отправить деньги';
            return response()->json($result);
        }


        if(Auth::user()->money < $request->daryn && Auth::user()->role_id != 1){
            $result['status'] = false;
            $result['error'] = 'Орда бонустарыңыз жетпейді';
            return response()->json($result);
        }

        try {

            if(Auth::user()->role_id != 1){
                $sender = Users::where('user_id',Auth::user()->user_id)->first();
                $sender->money -= $request->score;
                $sender->save();
            }

            $user_request = new UserRequest();
            $user_request->cost = $request->score;
            $user_request->is_pay = 1;
            $user_request->is_success = 1;
            $user_request->transaction_number = '';
            $user_request->sender_user_id = Auth::user()->user_id;
            $user_request->user_id = $client->user_id;
            $user_request->payment_type_id = 5;
            $user_request->save();

            $client->money += $request->daryn;
            $client->save();

            $operation = new Operation();
            $operation->user_id = $client->user_id;
            $operation->sender_user_id = Auth::user()->user_id;
            $operation->score = $request->score;
            $operation->is_active = 1;
            $operation->operation_type_id = 16;
            $operation->save();

            $operation = new Operation();
            $operation->user_id = Auth::user()->user_id;
            $operation->recipient_user_id = $client->user_id;
            $operation->score = $request->score * -1;
            $operation->is_active = 1;
            $operation->operation_type_id = 17;
            $operation->save();

            $result['status'] = true;
            $result['message'] = 'Успешно отправлено';
            return response()->json($result);
        }
        catch(Exception $ex){
            return $ex;
        }
    }

    public function cancelSendOrda(Request $request)
    {
        $user_request = UserRequest::where('user_request_id',$request->user_request_id)
                                    ->where('user_request.payment_type_id',5)
                                    ->first();

        if($user_request == null){
            $url = '?error=Такой операции не существует';
            if($request->page > 0) $url .= '&page='.$request->page;
            return redirect('/admin/send-daryn/list'.$url);
        }

        if($user_request->is_success == 0){
            $url = '?error=Операция уже отменена';
            if($request->page > 0) $url .= '&page='.$request->page;
            return redirect('/admin/send-score/list'.$url);
        }

        $recipient = Users::where('user_id',$user_request->user_id)->first();
        $sender = Users::where('user_id',$user_request->sender_user_id)->first();

        if($recipient == null){
            $url = '?error=Такой операции не существует';
            if($request->page > 0) $url .= '&page='.$request->page;
            return redirect('/admin/send-score/list'.$url);
        }

        if($recipient->money < $user_request->cost){
            $url = '?error=У получателя не хватает баланса';
            if($request->page > 0) $url .= '&page='.$request->page;
            return redirect('/admin/send-score/list'.$url);
        }

        try {

            if($sender->role_id != 1){
                $sender->money += $user_request->cost;
                $sender->save();
            }

            $user_request->is_success = 0;
            $user_request->save();

            $recipient->money -= $user_request->cost;
            $recipient->save();

            $operation = new Operation();
            $operation->user_id = $recipient->user_id;
            $operation->sender_user_id = Auth::user()->user_id;
            $operation->score = $user_request->cost * -1;
            $operation->is_active = 1;
            $operation->operation_type_id = 21;
            $operation->save();

            $operation = new Operation();
            $operation->user_id = Auth::user()->user_id;
            $operation->recipient_user_id = $recipient->user_id;
            $operation->score = $user_request->cost;
            $operation->is_active = 1;
            $operation->operation_type_id = 22;
            $operation->save();

            $url = '?message=Успешно отменили';
            if($request->page > 0) $url .= '&page='.$request->page;
            return redirect('/admin/send-score/list'.$url);
        }
        catch(Exception $ex){
            return $ex;
        }
    }

}
