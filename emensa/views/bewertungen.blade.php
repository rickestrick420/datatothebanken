@extends('layout')

@section("topper")

    <div class="topper">
        <div class="mensaLogo">
            <a href="/" style="color: black"> zurück </a>
        </div>
        <div class="menu_links">
            @if(isset($_SESSION['loginOK']))
                @if($_SESSION['loginOK'])
                    <a href="/meinebewertungen">Meine Bewertungen</a>
                @endif
            @endif

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


@section("gerichte")
    <h2>Top 30 Bewertungen:</h2>
    <table border="black" style="text-align: center">
        <tr>

            <th>Anzahl Sterne</th>
            <th>Bild</th>
            <th>Gerichtname</th>
            <th>Bemerkung</th>
            <th>Bewertungszeitpunkt</th>
            @if(isset($_SESSION['isAdmin']))
                @if($_SESSION['isAdmin'])
                    <th>Hervorheben/Abwählen</th>
                @endif
            @endif


        </tr>
        @foreach($data1 as $row)

            <tr @if($row->Hervorgehoben == 1) class="Hervorgehoben"@endif>

                        <td>{{$row->Sterne}}</td>
                        @if($row->bildname==0)
                            <td><img src="/img/gerichte/00_image_missing.jpg" alt="Bild" style="width: 150px" style="height: 150px"></td>
                        @else
                            <td><img src="/img/gerichte/{{$row->bildname}}" alt="Bild" style="width: 150px" style="height: 150px"></td>
                        @endif
                        <td>{{$row->name}}</td><td>{{$row->Bemerkung}}</td><td>{{$row->Bewertungszeitpunkt}}</td>

                    @if(isset($_SESSION['isAdmin']))
                        @if($_SESSION['isAdmin'])
                        <td><a href="/bewertunghervorheben?id={{$row->BewertungsID}}">Bewertung hervorheben/abwählen</a></td>
                        @endif
                    @endif

            </tr>


        @endforeach
    </table>
@endsection

@section("impressum")
    <b style="padding-top: 5px"> E-Mensa GmbH</b>
    <b class="footer1">Egzon und Ben</b>
    <b class="footer1"><a href="http://bitly.com/98K8eH">Impressum</a></b>
@endsection