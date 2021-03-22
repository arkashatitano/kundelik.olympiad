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



class IndexController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = Helpers::getSessionLang();
    }


    public function index(Request $request)
    {
        $menu = Cache::remember('menu_main_page_'.$this->lang, 1440, function () {
            return Menu::where('is_show',1)
                ->where('menu_redirect','/')
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

        $tests = OlympiadTest::orderBy('olympiad_test_grade','asc')
            ->orderBy('sort_num','asc')
            ->select(
                'olympiad_test.*',
                DB::raw('DATE_FORMAT(olympiad_test.olympiad_test_date_start,"%d.%m.%Y") as olympiad_test_date_start'),
                DB::raw('DATE_FORMAT(olympiad_test.olympiad_test_date_end,"%d.%m.%Y") as olympiad_test_date_end')
            );

        if(!Auth::check() || Auth::user()->role_id != 1) $tests->where('is_show',1);

        $tests =$tests->get();

        return view('index.index.index',
            [
                'menu' => $menu,
                'olympiad_tests' => $tests,
            ]);
    }

    public function showPage(Request $request,$url)
    {
        $url = '/'.$url;

        $menu = Cache::remember('menu_'.$url.'_'.$this->lang, 1440, function () use ($url) {
            return Menu::where('is_show',1)
                ->where('menu_redirect',$url)
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

        return view('index.page.page',
            [
                'menu' => $menu
            ]);
    }

}
