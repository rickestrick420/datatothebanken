<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Gerichte > 2€</title>
</head>
<body>

    <ul>
        <table style="border: solid 1px black">
            <tr><td style="border: solid 1px black">Gerichte</td><td style="border: solid 1px green">Preis Intern</td></tr>
        @forelse($data as $a)
                <tr><td style="border: solid 1px black">{{$a['name']}}</td><td style="border: solid 1px green">{{$a['preis_intern']}}€</td></tr>
        @empty
                <h2>Es sind keine Gerichte vorhanden.</h2>
        @endforelse
        </table>
    </ul>

</body>
</html>