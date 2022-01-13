@extends('layout')

@section("topper")

    <div class="topper">
        <div class="mensaLogo">
            <div>ID: {{$_GET['gerichtid']}}</div>
        </div>
        <div class="menu_links">
                Gerichte Bewerten!
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

   <table><tr>
    @foreach($data1 as $row)
    <td>{{$row['name']}}</td>

               @if($row['bildname']==0)
        <td><img src="/img/gerichte/00_image_missing.jpg" alt="Bild" style="width: 150px" style="height: 150px"></td>
    @else
        <td><img src="/img/gerichte/{{$row['bildname']}}" alt="Bild" style="width: 150px" style="height: 150px"></td>
    @endif

    @endforeach
       </tr></table>


<form action="/bewertung_hochladen" method="POST">
    <input type="hidden" name="gerichtid" value="{{$_GET['gerichtid']}}">
    <label for="bemerkung">Bewertung:</label><br>
    <textarea id="bemerkung" name="bemerkung" cols="35" rows="5" required></textarea><br>
    <select id="rank" name="rank" required>
        <option value="4star">Sehr gut</option>
        <option value="3star">Gut</option>
        <option value="2star">Schlecht</option>
        <option value="1star">Sehr Schlecht</option>
    </select>
    <input type="submit">
</form>
@endsection


@section("impressum")
    <b style="padding-top: 5px"> E-Mensa GmbH</b>
    <b class="footer1">Egzon und Ben</b>
    <b class="footer1"><a href="http://bitly.com/98K8eH">Impressum</a></b>
@endsection