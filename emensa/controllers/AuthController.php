<?php
require_once ('../models/benutzer.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AuthController
{
    public function verifikation(RequestData $rd) {
        $email = $_POST['email'];
        $passwort = $_POST['passwort'];


        $benutzer = getUserFromEmail($email);

        $sp = sha1('DBWT'.$passwort);

        $_SESSION['getErrorMessage'] = null;



        // Erfolgreiche Anmeldung
        if ($email == $benutzer['email'] && $sp == $benutzer['passwort']) {
            // create a log channel
            logger()->info('Angemeldet als: ',[$email]);

           Proz($email);

            $_SESSION['loginOK'] = true;
            $_SESSION['isAdmin'] = $benutzer['admin'];
            $_SESSION['userid'] = $benutzer['id'];

            Anmeldung($email);
            header('Location: /');
        }
        else {
            // create a log channel
            logger()->info('Falsches Passwort von Benutzer: ',[$email]);
            $_SESSION['loginOK'] = false;
            $_SESSION['getErrorMessage'] = 'Falsche Daten!';
            AnmeldungFehler($email);
            header('Location: /anmeldung');
        }
    }

    public function logi(RequestData $rd) {
        $msg = $_SESSION['getErrorMessage'] ?? null;
        return view('login',
            ['errorMessage' => $msg,]);
    }

    public function abmelden() {
        // create a log channel
        $log = new Logger('Logout');
        $log->pushHandler(new StreamHandler('../storage/logs/logs.log', Logger::INFO));
        $log->info('Benutzer abgemeldet');
        $_SESSION['loginOK'] = false;
        session_destroy();
        header('Location: /');
    }
}