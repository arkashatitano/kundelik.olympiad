<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <div class="user-profile">
            <div class="profile-img"><img src="{{Auth::user()->avatar}}" alt="user"/></div>
            <div class="profile-text"><a href="#" class="dropdown-toggle link u-dropdown" data-toggle="dropdown"
                                         role="button" aria-haspopup="true" aria-expanded="true">{{Auth::user()->name}}
                    <span class="caret"></span></a>
                <div class="dropdown-menu animated flipInY">
                    <div class="dropdown-divider"></div>
                    <a href="/admin/password" class="dropdown-item"><i class="ti-settings"></i> Сменить пароль</a>
                    <div class="dropdown-divider"></div>
                    <a href="/admin/logout" class="dropdown-item"><i class="fa fa-power-off"></i> Выйти</a>
                </div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <ul id="sidebarnav" style="padding-bottom: 140px">
                <li>
                    <a class="has-arrow @if(isset($main_menu) && $main_menu == 'olympiad-test') active @endif" href="#" aria-expanded="false">
                        <i class="mdi mdi-view-grid"></i><span class="hide-menu">Олимпиада</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="/admin/olympiad-test" class="@if(isset($menu) && $menu == 'olympiad-test') active @endif">Тест</a></li>
                        <li><a href="/admin/olympiad-test-question" class="@if(isset($menu) && $menu == 'olympiad-test-question') active @endif">Вопрос</a></li>
                        <li><a href="/admin/answer-olympiad-test" class="@if(isset($menu) && $menu == 'answer-olympiad-test') active @endif">Участники</a></li>
                    </ul>
                </li>
                <li>
                    <a class="@if(isset($menu) && $menu == 'menu') active @endif" href="/admin/menu">
                        <i class="mdi mdi-view-grid"></i><span class="hide-menu">Меню</span>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="#" aria-expanded="false">
                        <i class="mdi mdi-view-grid"></i><span class="hide-menu">Справочник</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="/admin/banner"
                               class="@if(isset($menu) && $menu == 'banner') active @endif">Баннер</a></li>
                        <li><a href="/admin/info" class="@if(isset($menu) && $menu == 'info') active @endif">Тексты на
                                сайте</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow @if(isset($main_menu) && $main_menu == 'operation') active @endif" href="#"
                       aria-expanded="false">
                        <i class="mdi mdi-view-grid"></i><span class="hide-menu">Операции</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="/admin/operation" class="@if(isset($menu) && $menu == 'operation') active @endif">Операции</a>
                        </li>
                        <li><a href="/admin/payment" class="@if(isset($menu) && $menu == 'payment') active @endif">Платежи</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow @if(isset($menu) && $menu == 'client') active @endif" href="#"
                       aria-expanded="false">
                        <i class="mdi mdi-account"></i><span class="hide-menu">Пользователи</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="/admin/client?active=0" class="active">Активные</a></li>
                        <li><a href="/admin/client?active=1">Заблокированные</a></li>
                    </ul>
                </li>
                <li>
                    <a class="@if(isset($menu) && $menu == 'action') active @endif" href="/admin/action">
                        <i class="mdi mdi-receipt"></i><span class="hide-menu">Действие пользователей</span>
                    </a>
                </li>
                <li>
                    <a class="@if(isset($menu) && $menu == 'password') active @endif" href="/admin/password">
                        <i class="mdi mdi-settings"></i><span class="hide-menu">Сменить пароль</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="sidebar-footer">
        <!-- item-->
        <a href="/admin/password" class="link" data-toggle="tooltip" title="Сменить пароль"><i class="ti-settings"></i></a>
        <!-- item-->
        <a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
        <!-- item-->
        <a href="/admin/logout" class="link" data-toggle="tooltip" title="Выйти"><i class="mdi mdi-power"></i></a>
    </div>

</aside>
