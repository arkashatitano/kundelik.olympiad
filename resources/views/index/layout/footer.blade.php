<footer>
    <div class="container">
        <div class="footer">
            <div class="copyright">
                <span>© {{date('Y')}}  Олимпиада</span>
                <ul class="nav copyright-nav">

                    @foreach(\App\Models\Menu::getFooterMenu($lang) as $item)
                        <li class="nav-item">
                            <a class="nav-link" href="@if($item->menu_redirect != ''){{$item->menu_redirect}}@else{{$item['menu_url_'.$lang]}}@endif">{{$item['menu_name_'.$lang]}}</a>
                        </li>
                    @endforeach

                </ul>
            </div>
            <div class="footer-social">
                <a href="{{\App\Http\Helpers::getInfoText(49)}}" target="_blank">
                    <i class="icon icon-vk"></i>
                </a>
                <a href="{{\App\Http\Helpers::getInfoText(50)}}" target="_blank">
                    <i class="icon icon-facebook"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
