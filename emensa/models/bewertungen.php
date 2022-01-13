<?php
use Illuminate\Database\Capsule\Manager as DB;

class Bewertung extends Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
    protected $table = 'bewertungen';
    protected $fillable = ['name'];

    public function db_bewertungen()
    {

        return DB::table('bewertungen')
            ->join('gericht', 'bewertungen.GerichtID', '=', 'id')
            ->select('BewertungsID', 'gericht.name', 'bildname', 'Sterne', 'Bemerkung', 'Bewertungszeitpunkt', 'Hervorgehoben')
            ->distinct()
            ->orderBy('Sterne', 'DESC')
            ->take(30)
            ->get();
    }
}
function bewertung_hochladen($rank,$benutzerid,$bemerkung,$gerichtid)
{
    $link = connectdb();
    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }

    $sql = "INSERT INTO bewertungen (Sterne, ErstellerID, Bemerkung, GerichtID) VALUES (?,?,?,?) ";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('iisi',$rank,$benutzerid,$bemerkung,$gerichtid);
    $stmt->execute();
    mysqli_close($link);
    return true;

}

function db_bewertungen(){

    $link = connectdb();
    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }
    $sql = "SELECT DISTINCT BewertungsID, gericht.name AS gerichtname, bildname, Sterne, Bemerkung, Bewertungszeitpunkt, Hervorgehoben from bewertungen
            JOIN gericht ON bewertungen.GerichtID = gericht.id ORDER BY Sterne DESC LIMIT 30";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_all($result, MYSQLI_BOTH);
    mysqli_close($link);
    if (!$data) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }
    return $data;
}

function db_meinebewertungen(){

    $link = connectdb();
    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }

    $sql = "SELECT DISTINCT BewertungsID, gericht.name AS gerichtname, bildname, Sterne, Bemerkung, Bewertungszeitpunkt, Hervorgehoben from bewertungen
            JOIN benutzer on bewertungen.ErstellerID = ?
            JOIN gericht ON bewertungen.GerichtID = gericht.id ORDER BY Bewertungszeitpunkt DESC LIMIT 30";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('i',$_SESSION['userid']);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = mysqli_fetch_all($result, MYSQLI_BOTH);
    mysqli_close($link);
    if (!$data) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }
    return $data;

}

function bewertungloeschen($id){

    $link = connectdb();
    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }

    $sql = "DELETE FROM bewertungen WHERE BewertungsID = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('i',$id);
    $stmt->execute();
    mysqli_close($link);
    return true;
}

function bewertunghervorheben($id){
    $link = connectdb();
    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }
    $sql = "UPDATE bewertungen SET Hervorgehoben=!Hervorgehoben WHERE BewertungsID = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('i',$id);
    $stmt->execute();
    mysqli_commit($link);
    mysqli_close($link);
    return true;
}

function db_hervorgehobenebewertungen(){

    $link = connectdb();
    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }
    $sql = "SELECT DISTINCT BewertungsID, gericht.name AS gerichtname, bildname, Sterne, Bemerkung, Bewertungszeitpunkt, Hervorgehoben from bewertungen
            JOIN gericht ON bewertungen.GerichtID = gericht.id WHERE Hervorgehoben=1 ORDER BY Sterne DESC LIMIT 30";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_all($result, MYSQLI_BOTH);
    mysqli_close($link);
    if (!$data) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }
    return $data;
}