<?php

namespace App\Http\Controllers\Admin;

use App\Models\Actions;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Policy;
use App\Models\Region;
use App\Models\School;
use App\Models\Statistic;
use App\Models\Subscription;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers;
use Auth;
use Illuminate\Support\Facades\Cache;
use View;
use DB;



class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        View::share('menu', 'statistic');

        $statistic['user_count_today'] = Cache::remember('user_count_today_', 15, function () {
            return Users::where('created_at','>=',date('Y-m-d 00:00'))
                ->where('created_at','<=',date("Y-m-d 23:59"))
                ->select('users.user_id')
                ->count();
        });

        $statistic['user_count_all'] = Cache::remember('user_count_all_', 15, function () {
            return Users::select('users.user_id')->count();
        });

        $statistic['subscription_count_today'] = Cache::remember('subscription_count_today', 15, function () {
            return Subscription::where('subscription.created_at','>=',date('Y-m-d 00:00'))
                ->where('subscription.created_at','<=',date("Y-m-d 23:59"))
                ->select('subscription.subscription_id')
                ->count();
        });

        $statistic['subscription_count_all'] = Cache::remember('subscription_count_all', 15, function () {
            return Subscription::select('subscription.subscription_id')->count();
        });

        if(!isset($request->date_from))
            $request->date_from = date('d-m-Y', strtotime('-7 day'));

        if(!isset($request->date_to))
            $request->date_to = date('d-m-Y');

        if($request->day == '7') {
            $request->date_from = date('d-m-Y', strtotime('-7 day'));
            $request->date_to = date('d-m-Y');
        }
        elseif($request->day == '14') {
            $request->date_from = date('d-m-Y', strtotime('-14 day'));
            $request->date_to = date('d-m-Y');
        }

        $dates = array();

        $max_count = 0;
        $max_count_subscription = 0;

        $count = 0;

        $date = $request->date_from;

        while (strtotime($date) <= strtotime($request->date_to)) {

            $dates[$count]['date'] = date("d.m", strtotime($date));

            $dates[$count]['user_count'] = Cache::remember('user_count_'.$count.'_'.$date, 15, function () use($date) {
                return Users::where('created_at','>=',date($date.' 00:00'))
                    ->where('created_at','<=',date($date." 23:59"))
                    ->select('users.user_id')
                    ->count();
            });


            if($max_count <= $dates[$count]['user_count']) $max_count = $dates[$count]['user_count'];

            $dates[$count]['subscription_count'] = Cache::remember('subscription_count_'.$count.'_'.$date, 15, function () use($date) {
                return Subscription::where('subscription.created_at','>=',date($date.' 00:00'))
                    ->where('subscription.created_at','<=',date($date." 23:59"))
                    ->select('subscription.subscription_id')
                    ->count();
            });

            if($max_count_subscription <= $dates[$count]['subscription_count']) $max_count_subscription = $dates[$count]['subscription_count'];


            $count++;

            if($count == 15)
                break;

            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
        }


        return  view('admin.index.index',
            [
                'menu' => 'home',
                'results' => $dates,
                'statistic' => $statistic,
                'max_count' => $max_count + 5,
                'max_count_subscription' => $max_count_subscription + 5
            ]);
    }

    public function showAction(Request $request)
    {
        $row = Actions::leftJoin('users','users.user_id','=','actions.user_id')
            ->orderBy('actions.action_id','desc')
            ->select('*',
                DB::raw('DATE_FORMAT(actions.created_at,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->name) && $request->name != ''){
            $row->where(function($query) use ($request){
                $query->where('name','like','%' .$request->name .'%');
            });
        }

        if(isset($request->action_name) && $request->action_name != ''){
            $row->where(function($query) use ($request){
                $query->where('action_text_ru','like','%' .$request->action_name .'%');
            });
        }

        $row = $row->paginate(20);

        return  view('admin.action.index',
            [
                'menu' => 'home',
                'row' => $row,
                'request' => $request

            ]);
    }

}
