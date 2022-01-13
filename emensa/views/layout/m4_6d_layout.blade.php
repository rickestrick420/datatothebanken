<!DOCTYPE html>
<html lang="de">
<head>
    <title>Layout Page: @yield('title')</title>
    <style>
        .grid-container{
            display: grid;
            grid-template-columns: 15% auto;
            grid-template-rows: 20% auto;
            gap: 20px;

            grid-template-areas:
            "header header"
            " sidebar main"
            "footer footer"
        ;
        }
        .header{
            grid-area: header;
            border: solid 5px red;
        }
        .main{
            grid-area: main;
            border: solid 5px red;
        }
        .sidebar{
            border: solid 5px red;
            grid-area: sidebar;
        }
        .footer{
            grid-area: footer;
            border: solid 5px red;
        }
    </style>
</head>

<div class="grid-container">

<div class="header">
@section('header')
    @show
</div>

    <div class="main">
        @section('main')
        @show
    </div>

    <div class="sidebar">
        @section('sidebar')
        @show
    </div>


<div class="footer">
    @section('footer')
    @show
</div>
</div>
</html>