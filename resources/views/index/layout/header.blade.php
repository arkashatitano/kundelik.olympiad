<header>
    <div class="container">
        <div class="header">
            <a class="main-logo" href="/">
                <img src="/img/main/logo.png">
            </a>
            <div class="mobile-menu">
                <ul class="nav main-nav">

                    @foreach(\App\Models\Menu::getHeaderMenu($lang) as $item)
                        <li class="nav-item">
                            <a class="nav-link" href="@if($item->menu_redirect != ''){{$item->menu_redirect}}@else{{$item['menu_url_'.$lang]}}@endif">{{$item['menu_name_'.$lang]}}</a>
                        </li>
                    @endforeach

                </ul>
                <div class="header-authorize">
                    @if(Auth::check())
                        <a class="login-link btn-transparent" href="/profile">Профиль</a>
                        <a class="registration-link btn-main" href="/profile/test">@lang('messages.my_test')</a>
                    @else
                        <a class="login-link btn-transparent" href="/auth/login">@lang('messages.login')</a>
                        <a class="registration-link btn-main" href="/auth/register">Регистрация</a>
                    @endif
                    <a @if($lang == 'ru') style="text-decoration: underline" @endif href="javascript:void(0)" onclick="setLangSite('ru')">RU</a>
                    <a @if($lang == 'kz') style="text-decoration: underline" @endif href="javascript:void(0)" onclick="setLangSite('kz')">KZ</a>
                </div>
            </div>
            <button class="btn-plain call-menu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
    </div>
</header>
