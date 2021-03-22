<!DOCTYPE html>
<html lang="en">

@include('index.layout.app')

<body>
<i class="ajax-loader"></i>

@yield('header')

@yield('content')

@yield('footer')

<script src="/js/libs.min.js"></script>
<script src="/js/main.js"></script>
<script src="/custom/js/custom.js"></script>

@yield('js')

</body>
</html>
