@extends("layout")

@section("topper")

    <div class="topper">
    <div class="mensaLogo">
    <div>E-Mensa Logo</div>
    </div>
    <div class="menu_links">
        @if(isset($_SESSION['loginOK']))
        @if($_SESSION['loginOK'])
            <a href="/meinebewertungen">Meine Bewertungen</a>
        @endif
        @endif
    <a href="/bewertungen"> Alle Bewertungen </a>
    <a href="https://localhost:63342/INF_A_Salomon_Tatari_4/werbeseite/wunschgericht.php"> Wunschgericht </a>
        @if(isset($_SESSION['loginOK']))
            @if($_SESSION['loginOK'] == true )
            <a href="/abmeldung">Abmelden</a>

            @else
            <a href="/anmeldung">Anmelden</a>
            @endif
            @if($_SESSION['loginOK'] == true )
            <a  style="float:right;">Sie sind angemeldet</a>
            @endif

        @else
            <a href="/anmeldung">Anmelden</a>

        @endif
    </div>
    </div>
@endsection







@section("text")

    <h1 id="ank">Bald gibt es Essen auch Online!</h1>
    <p style="border: 1px solid black; padding: 10px; margin-right: 10%; margin-left: 10%">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
@endsection


@section("gerichte")
    <h2 id="speisen">Köstlichkeiten, die Sie erwarten</h2>
    <table border="black">
        <tr>
            <th>Gerichtname</th>
            <th>Allergene</th>
            <th>Preis intern</th>
            <th>Preis extern</th>
            <th>Bild</th>
        </tr>
        @foreach($data1 as $row)
            <tr><td>{{$row['name']}}</td><td>{{$row['allergene']}}</td><td>{{$row['preis_intern']}}</td><td>{{$row['preis_extern']}}</td>
                     @if($row['bildname']==0)
                        <td><img src="/img/gerichte/00_image_missing.jpg" alt="Bild" style="width: 150px" style="height: 150px"></td>
                    @else
                         <td><img src="/img/gerichte/{{$row['bildname']}}" alt="Bild" style="width: 150px" style="height: 150px"></td>
                    @endif


                @if(isset($_SESSION['loginOK']))
                @if($_SESSION['loginOK'])
                    <td><a href="/bewertung?gerichtid={{$row['id']}}">Gericht Bewerten</a></td></tr>
                @endif
            @endif
        @endforeach
    </table>
@endsection

@section("allergene")
<table border="black">
    @foreach($data2 as $row)
        <tr><td>{{$row['code']}}</td><td>{{$row['name']}}</td></tr>
    @endforeach
</table>
@endsection

@section("text2")
    <h1>Meinungen unserer Gäste!</h1>
    <table border="black" style="text-align: center">
        <tr>

            <th>Anzahl Sterne</th>
            <th>Bild</th>
            <th>Gerichtname</th>
            <th>Bemerkung</th>
            <th>Bewertungszeitpunkt</th>
        </tr>
        @foreach($data3 as $row)

            <tr>

                <td>{{$row['Sterne']}}</td>
                @if($row['bildname']==0)
                    <td><img src="/img/gerichte/00_image_missing.jpg" alt="Bild" style="width: 150px" style="height: 150px"></td>
                @else
                    <td><img src="/img/gerichte/{{$row['bildname']}}" alt="Bild" style="width: 150px" style="height: 150px"></td>
                @endif
                <td>{{$row['gerichtname']}}</td><td>{{$row['Bemerkung']}}</td><td>{{$row['Bewertunsgzeitpunkt']}}</td>

            </tr>


        @endforeach
    </table>
@endsection

@section("impressum")
    <b style="padding-top: 5px"> E-Mensa GmbH</b>
    <b class="footer1">Egzon und Ben</b>
    <b class="footer1"><a href="http://bitly.com/98K8eH">Impressum</a></b>
@endsection

