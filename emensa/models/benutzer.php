<?php


function getUserFromEmail($email) {
    $link = connectdb();

    // Eingabemaskierung
    $email = mysqli_real_escape_string($link, $email);

    mysqli_begin_transaction($link);

    // Prepared Statements
    $stmt = mysqli_stmt_init($link);
    mysqli_stmt_prepare($stmt, "SELECT id, email, passwort, admin from benutzer where email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_array($result);

    mysqli_commit($link);

    mysqli_free_result($result);
    mysqli_close($link);
    return $data;
}


function Anmeldung($email)
{
    $link = connectdb();

    // Eingabemaskierung
    $email = mysqli_real_escape_string($link, $email);

    mysqli_begin_transaction($link);

    $stmt = mysqli_stmt_init($link);

    // Prepared Statements
    mysqli_stmt_prepare($stmt, "update benutzer set letzteanmeldung = CURRENT_TIMESTAMP where email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    mysqli_commit($link);

    mysqli_close($link);

}


function AnmeldungFehler($email)
{
    $link = connectdb();

    // Eingabemaskierung
    $email = mysqli_real_escape_string($link, $email);

    mysqli_begin_transaction($link);

    $stmt = mysqli_stmt_init($link);

    // Prepared Statements
    mysqli_stmt_prepare($stmt, "update benutzer set anzahlfehler = anzahlfehler + 1, letzterfehler = CURRENT_TIMESTAMP where email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    mysqli_commit($link);

    mysqli_close($link);

}

function Anmeldungen() {
    $link = connectdb();

    $sql = "select * from view_anmeldungen";
    $result = mysqli_query($link, $sql);

    $data = mysqli_fetch_all($result, MYSQLI_BOTH);

    mysqli_close($link);
    return $data;
}

function Proz($email){

//connect to database
    $link = connectdb();
    mysqli_begin_transaction($link);

    $stmt = mysqli_stmt_init($link);

    // Prepared Statements
    mysqli_stmt_prepare($stmt, "CALL proze(?)");
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    mysqli_commit($link);
    mysqli_close($link);
//run the store proc
}