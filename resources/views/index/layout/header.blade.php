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
                        <a class="registration-link btn-main" href="/profile/test">Мои тесты</a>
                    @else
                        <a class="login-link btn-transparent" href="/auth/login">Войти</a>
                        <a class="registration-link btn-main" href="/auth/register">Регистрация</a>
                    @endif
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
