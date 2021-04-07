<!DOCTYPE html>
<html lang="en">

@include('admin.layout.app')

<body class="fix-header fix-sidebar card-no-border">
<i class="ajax-loader" ></i>
<div class="preloader">
  <svg class="circular" viewBox="25 25 50 50">
    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>

<div id="main-wrapper">
  <header class="topbar">
    <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
      <div class="navbar-header">
        <a class="navbar-brand" href="/">
          <b>
            <img style="max-width: 150px" src="/img/main/logo.png" alt="homepage" class="dark-logo" />
            <img style="max-width: 150px" src="/img/main/logo.png" alt="homepage" class="light-logo" />
          </b>

              {{--          <span>
                         <img src="/admin/img/logo.png" alt="homepage" class="dark-logo" />
                         <img src="/admin/img/logo.png" class="light-logo" alt="homepage" /></span>--}} </a>
      </div>

      <div class="navbar-collapse">

        <ul class="navbar-nav mr-auto mt-md-0 ">
          <!-- This is  -->
          <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
          <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a> </li>
        </ul>

        <ul class="navbar-nav my-lg-0">
          <li class="nav-item hidden-sm-down">
            <form class="app-search">
              <input type="text" class="form-control" placeholder="Поиск..."> <a class="srh-btn"><i class="ti-search"></i></a> </form>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{Auth::user()->avatar}}" alt="user" class="profile-pic" /></a>
            <div class="dropdown-menu dropdown-menu-right animated flipInY">
              <ul class="dropdown-user">
                <li>
                  <div class="dw-user-box">
                    <div class="u-img"><img src="{{Auth::user()->avatar}}" alt="user"></div>
                    <div class="u-text">
                      <h4>{{Auth::user()->name}}</h4>
                      <p class="text-muted">{{Auth::user()->login}}</p>{{--<a href="#" class="btn btn-rounded btn-danger btn-sm">View Profile</a>--}}</div>
                  </div>
                </li>
                <li role="separator" class="divider"></li>
                <li><a href="/admin/password"><i class="ti-settings"></i> Сменить пароль</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="/admin/logout"><i class="fa fa-power-off"></i> Выйти</a></li>
              </ul>
            </div>
          </li>
          {{--<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-us"></i></a>
            <div class="dropdown-menu  dropdown-menu-right animated bounceInDown"> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> Dutch</a> </div>
          </li>--}}
        </ul>
      </div>
    </nav>
  </header>

  @include('admin.layout.sidebar.admin')

  <div class="page-wrapper">

    @yield('content')

    <footer class="footer">
      © {{date('Y')}}
    </footer>

  </div>
</div>

<script src="/admin/assets/plugins/jquery/jquery.min.js"></script>
<script src="/admin/assets/plugins/bootstrap/js/tether.min.js"></script>
<script src="/admin/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<script src="/admin/js/jquery.slimscroll.js"></script>
<script src="/admin/js/waves.js"></script>
<script src="/admin/js/sidebarmenu.js"></script>
<script src="/admin/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="/admin/js/custom.min.js"></script>

<script type="text/javascript" src="/custom/wysiwyg/kindeditor.js?v=5"></script>
<script type="text/javascript" src="/custom/wysiwyg/ru_Ru.js?v=1"></script>
<script type="text/javascript" src="/custom/js/jquery.gritter.js"></script>

<script src="/custom/js/admin.js?v=249"></script>


<script>
  @if(isset($_GET['error']))
    showError('{{$_GET['error']}}');
  @endif

  @if(isset($_GET['message']))
    showMessage('{{$_GET['message']}}');
  @endif


</script>

@yield('js')

</body>

</html>
