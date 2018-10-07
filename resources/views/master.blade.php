<!DOCTYPE html>
<html>
<!--[if IE 9 ]>
<html class="ie9">
<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Color Nations</title>

    @section('styles')
        @include('includes.styles')
    @show
</head>
<body>
@include('header')
@include('subheader')
@include('announcements')
<section id="main">
    @include('sidebar')

    <section id="content">
        <div class="container" id="pjax-container">
            @yield('content')
        </div>
    </section>
</section>

<!-- Older IE warning message -->
<!--[if lt IE 9]>
@include('ie')
<![endif]-->

@section('scripts')
    @include('includes.scripts')
@show

</body>
</html>