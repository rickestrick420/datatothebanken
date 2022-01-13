<?php
/**
 * Diese Datei enthält alle SQL Statements für die Tabelle "gerichte"
 */
function db_gerichteover2() {
    try {
        $link = connectdb();

        $sql = "SELECT name, preis_intern FROM gericht WHERE preis_intern > 2 ORDER BY name";
        $result = mysqli_query($link, $sql);

        $data = mysqli_fetch_all($result, MYSQLI_BOTH);

        mysqli_close($link);
    }

    finally {
        return $data;
    }

}
