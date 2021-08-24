<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Article;
use App\Models\Certificate;
use App\Models\Contact;
use App\Models\EntQuestion;
use App\Models\Menu;
use App\Models\ObjectDB;
use App\Models\ObjectPair;
use App\Models\ObjectSubject;
use App\Models\OlympiadTest;
use App\Models\OlympiadTestQuestion;
use App\Models\Operation;
use App\Models\Page;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;

use App\Models\Question;
use App\Models\Region;
use App\Models\Speciality;
use App\Models\University;
use App\Models\UserOlympiadTest;
use App\Models\UserOlympiadTestAnswer;
use App\Models\UserRequest;
use App\Models\Users;
use App\Models\UserTest;
use App\Models\UserTestAnswer;
use Dompdf\Options;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Cookie;
use View;
use Auth;



class CertificateController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->middleware('profile');
    }

    public function getCertificate(Request $request,$user_olympiad_test_id)
    {
        $user_olympiad_test = UserOlympiadTest::leftJoin('users','users.user_id','=','user_olympiad_test.user_id')
            ->leftJoin('olympiad_test','olympiad_test.olympiad_test_id','=','user_olympiad_test.olympiad_test_id')
            ->where('user_olympiad_test.user_id',Auth::user()->user_id)
            ->where('user_olympiad_test_id',$user_olympiad_test_id)
            ->where('user_olympiad_test.is_success',1)
            ->select('user_olympiad_test.*',
                'users.name',
                'olympiad_test.olympiad_test_name_ru',
                'olympiad_test.certificate_type_id',
                'olympiad_test.certificate_text_1',
                'olympiad_test.certificate_text_2',
                'olympiad_test.certificate_text_3',
                'user_olympiad_test.score as score',
                DB::raw('DATE_FORMAT(user_olympiad_test.created_at,"%d.%m.%Y") as date')
            )
            ->first();

        if($user_olympiad_test == null) abort(404);

        $certificate = Certificate::where('user_olympiad_test_id',$user_olympiad_test_id)->first();

        if($certificate == null){
            $certificate = $this->addCertificate($user_olympiad_test_id);
        }

        $certificate->info = $user_olympiad_test;

        // share data to view
        view()->share('row',$certificate);
        $pdf = PDF::loadView('index.certificate.certificate', $certificate);

        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }

    public function addCertificate($user_olympiad_test_id)
    {
        //сертификат
        $certificate = new Certificate();
        $certificate->user_id = Auth::user()->user_id;
        $certificate->user_name = Auth::user()->name;
        $certificate->user_olympiad_test_id = $user_olympiad_test_id;
        $certificate->save();

        $certificate_id = $certificate->certificate_id;

        if($certificate_id < 10000){
            $length = 5;
            $certificate_id = substr(str_repeat(0, $length).$certificate_id, - $length);
        }
        $certificate->certificate_name = $certificate_id;
        $certificate->save();

        return $certificate;
    }

}
