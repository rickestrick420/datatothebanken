<!DOCTYPE html>
<html lang="de">

@section('content')
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
    </head>
    @endsection
@section('header')
    <h1>Anmeldung</h1>
    @yield('header')
    <body>
    @endsection
    <div class="grid-container">
        <div class="gridbox logo">
            <div>
                <img src="img/logo.png" alt="Logo" class="logo">
            </div>
        </div>
    @yield ('content')

    @yield ('anm')

</html>



