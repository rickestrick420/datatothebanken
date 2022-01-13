<!doctype html>
<html lang="DE">
<head>
        <meta charset="utf-8">
        <title>E-Mensa</title>
        <link rel="stylesheet" href="home.css">
</head>

<body>

    @yield('topper')
    @yield('menu_links')
    @yield('a1')

<div class="inhalt">

        @yield('text')
        @yield('gerichte')
        @yield('allergene')
        @yield('text2')

</div>


<div class="foot">
        @yield('impressum')

</div>
<script>
        if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
        }
</script>
</body>

</html>