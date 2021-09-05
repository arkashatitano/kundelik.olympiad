<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App;
use View;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        if ($request->isMethod('get')) {
            $locale = $request->segment(1);
            $lang_list = ['ru', 'kz'];

            if (in_array($locale, $lang_list)) {
                $this->app->setLocale($locale);
                setcookie("g_lang", $locale, time() + (86400 * 30), "/");

                \Illuminate\Support\Facades\View::share('lang', $locale);

                $segments = $request->segments();
                $first = array_shift($segments);
                header("HTTP/1.1 301 Moved Permanently");
                header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
                header('Location: ' . URL::to('/') . '/' . implode('/', $segments));
                exit();
            }
        }

        $locale = 'kz';
        if(isset($_COOKIE['g_lang']))
            $locale = $_COOKIE['g_lang'];

        App::setLocale($locale);
        View::share('lang', $locale);
        View::share('request', $request);
    }
}
