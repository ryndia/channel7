<!DOCTYPE html>
<html>
<head>
    @section('header')
        @include('./resource/header')
    @show
    @section('css')
        <!-- some master css here -->
    @show

</head>
<body>
    @section('navbar')
    @show

    @yield('content')        

    @section('footer')
    @show

    @section('js')
        <!-- some js here -->
    @show   
</body>
</html>