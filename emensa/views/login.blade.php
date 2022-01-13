@extends ('layout.loginlayout')

@section('title','Anmeldung')


@section('header')
@endsection

@section('anm')
    <div>
        <br>
        <br>
        <form action="/anmeldung_verifizieren" method="post">
            <label for="email">Email :  </label>
            <input type="email" name="email" id="email"><br>
            <label for="password">Passwort : </label>
            <input type="password" name="passwort" id="passwort"><br>
            <input type="submit" value="Anmeldung">
        </form>
        @if($errorMessage != null)
            <h3>{{$errorMessage}}</h3>
        @endif
    </div>
@endsection
