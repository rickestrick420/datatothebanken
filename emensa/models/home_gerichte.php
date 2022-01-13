<?php
function db_gerichte()
{
    $link = connectdb();
    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }
    $sql = "SELECT id, gericht.name, preis_intern, preis_extern, bildname, GROUP_CONCAT(allergen.code) allergene
                FROM
                    (allergen RIGHT JOIN gericht_hat_allergen ON allergen.code=gericht_hat_allergen.code)
                    RIGHT JOIN gericht ON gericht_hat_allergen.gericht_id=gericht.id
                GROUP BY gericht.name
                LIMIT 20;";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_all($result, MYSQLI_BOTH);
    mysqli_close($link);
    if (!$data) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }
    return $data;
}

function db_nameundbild(){
    $link = connectdb();
    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }

    if (isset($_GET['gerichtid'])) {
        $id = $_GET['gerichtid'];

        $sql = "SELECT id, gericht.name, bildname FROM gericht where id like $id;";
        $result = mysqli_query($link, $sql);
        $data = mysqli_fetch_all($result, MYSQLI_BOTH);
        mysqli_close($link);
        if (!$data) {
            echo "Fehler während der Abfrage:  ", mysqli_error($link);
            exit();
        }
        return $data;
    }
}

function db_allergene(){
    $link = connectdb();

    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }
    //Gerichte und Allergene aus DB anfragen
    $sql = "SELECT allergen.code,name
                    FROM
                        ((SELECT gericht.id FROM gericht ORDER BY id LIMIT 20) t INNER JOIN gericht_hat_allergen
                        ON t.id=gericht_hat_allergen.gericht_id)
                        INNER JOIN allergen
                        ON allergen.code=gericht_hat_allergen.code
                    GROUP BY gericht_hat_allergen.code";
    $result = mysqli_query($link, $sql); //Datenbank Ergebnisse in Array laden
    $data = mysqli_fetch_all($result, MYSQLI_BOTH);
    mysqli_close($link);
    if (!$data) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }
    return $data;
}