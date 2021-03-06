<!DOCTYPE html>
<!--
 - Praktikum DBWT. Autoren:
 - Ben, Salomon, 3232880
 - Egzon Tatari, 3235721
-->


<html lang="de">

<head>
    <meta charset="UTF-8">

    <title>Wunschgericht</title>
</head>

<body>

<form method="post" action="wunschgericht.php">
    <label>Name: </label>
    <input type="text" name="name" placeholder ="name"> <br>
    <label>Email: </label>
    <input type="email" name="email" placeholder ="email" required> <br>
    <label>Gerichtname: </label>
    <input type="text" name="gerichtname" placeholder ="gerichtname" required> <br>
    <label>Beschreibung: </label>
    <input type="text" name="beschreibung" placeholder ="beschreibung" required> <br>
    <input type="submit" name="senden" value="schicken">
</form>


</body>
</html>
<?php

//Verbindung zum Server aufbauen
$link = mysqli_connect("localhost",
    "root",
    "root",
    "emensawerbeseite"
);

if (!$link) {
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}

if(isset($_POST['senden']) &&
    isset($_POST['email'])  && //Dadurch das in der HTML die felder email gerichtname und beschreibung als Required gesetzt sind dient das nur zu VollstÃ¤ndigkeit
    isset($_POST['gerichtname'] ) &&
    isset($_POST['beschreibung'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gerichtname = $_POST['gerichtname'];
    $beschreibung = $_POST['beschreibung'];
    $erstellungsdatum = date("d/m/Y");


    if (($_POST["name"] == ""))
        $name = "anonym";

    $stmt = $link->prepare("INSERT INTO ersteller (EMail,Name) VALUES (?,?)");
    $stmt->bind_param("ss", $email, $name);
    $stmt->execute();
// Check for Errors
    print $stmt->error;


    $stmt = $link->prepare("INSERT INTO wunschgerichte (Gerichtname,Beschreibung,Erstellungsdatum, erstellerID) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $gerichtname, $beschreibung,$erstellungsdatum, $email);

    $stmt->execute();


// Check for Errors
    print $stmt->error;


    unset($_POST);
    header('Location:'.$_SERVER['PHP_SELF']);
    //Unset the data and Prevent after refresh an insertion
}