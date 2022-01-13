<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";
include '../config/orm.php';
use Illuminate\Database\Capsule\Manager as Capsule;
session_start();
const VERBOSITY = 0;
const PUBLIC_DIRNAME = "public";
const CONFIG_WEBROUTES = '../config/web.php';
const CONFIG_DB = '../config/db.php';


// DEMO
try {
    if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php")) {
        echo "<h1>Abhängigkeiten nicht gefunden</h1><pre>DOCUMENT_ROOT: {$_SERVER['DOCUMENT_ROOT']}</pre><br><p>Datei nicht gefunden: <strong>{$_SERVER['DOCUMENT_ROOT']}/../vendor/autoload.php</strong></p>";
        echo "<p>Häufigste Ursache</p><ul><li>Das Verzeichnis <code>public/</code> ist als Wurzelverzeichnis verwendet worden.</li><li>Die Abhängigkeiten wurden nicht mit <code>composer update</code> installiert.</code></li></ul>";
        exit(1);
    }
    // file exists

} catch (Exception $ex) {
    echo "DOCUMENT_ROOT: {$_SERVER['DOCUMENT_ROOT']}\t\tError: ".$ex->getMessage();
}
use eftec\bladeone\BladeOne;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/* Routing Script for PHP Dev Server */
$verbosity = VERBOSITY;
if (preg_match('/\.(?:css|js|png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;
} else {
    if ($verbosity > 1) {
        echo
            "<pre>Verbosity-Level: <strong>{$verbosity}</strong></pre>" .
            "<pre>" . print_r($_SERVER, 1) . "</pre><hr>";
    }
    FrontController::handleRequest("$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", $_SERVER['REQUEST_METHOD'], VERBOSITY);
}

class RequestData
{
    /**
     * @var array Request Querystring, broken down to key-value pairs
     */
    public array $query;
    /**
     * @var array Request arguments from path, after cutting two segments out for controller and action names
     */
    public array $args;
    /**
     * @var string HTTP Verb used
     */
    public string $method;

    /**
     * RequestData is the way the Router will provide information, use it in your Action methods.
     * @param $method string Verb used
     * @param $args array Arguments
     * @param $query array Key-Value Pairs
     */
    public function __construct($method, $args, $query)
    {
        $this->query = $query;
        $this->args = $args;
        $this->method = $method;
    }
}

class FrontController
{

    public static function handleRequest($url, $method = 'GET', $verbosity = 0, $configPath = CONFIG_WEBROUTES)
    {
        if (strpos($url, ':') === FALSE) $url = $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI']; // FIX no port given bug

        $scriptPath = dirname(__FILE__, 2) . '/';
        $controllerDirectory = $scriptPath . 'controllers/';

        // get a router/web-like config array to override filebased convention
        $config = FrontController::getConfig($configPath);

        // /Impressum/ --> ImpressumController->index()
        $request = parse_url($url);
        $ctrlName = $request['path'];
        $actionName = 'index';
        $args = array();
        $query = array();
        parse_str($request['query'] ?? "", $query);

        // provide POST data
        if ($method != 'GET')
            $query = array_merge($query, $_REQUEST);


        // check, if route has two levels
        if (strpos($ctrlName, '/', 1) > 0) {
            $path = explode('/', $request['path']); // Werbeseite/Speise/1/mobile?pretty=true&user=marcel
            array_shift($path);                             // skip once
            $ctrlName = array_shift($path);         // Werbeseite
            $actionName = array_shift($path);       // Speise
            $args = $path; // remainder of path-parts     // [1][mobile]
            if ($verbosity > 1) {
                echo "<pre>Request\n", print_r($request), "</pre>";
                echo "<pre>Path\n", print_r($path), "</pre>";
                echo "<pre>Query\n", print_r($query), "</pre>";
            }
        }

        // fix: trim slashes
        $ctrlName = trim($ctrlName, '/');
        $actionName = trim($actionName, '/');

        // $config based renaming of Controller/Action, precedes filebased convention
        // $config values must use syntax <ClassController>@<actionname>
        if (array_key_exists('/' . $ctrlName . '/' . $actionName, $config)) {
            $routingConfig = explode('@', $config['/' . $ctrlName . '/' . $actionName]);
            if ($verbosity > 0) {
                echo "<p>Routing Config matched request for <code>/" . $ctrlName . "/" . $actionName . "</code>:</p><p>routing config is</p><pre>" . print_r($routingConfig, 1) . '</pre>';
            }
            // important: overwriting controller and action name
            $ctrlClass = $routingConfig[0];
            $actionName = $routingConfig[1];
        } elseif (array_key_exists($request['path'], $config)) {
            // exact match on full path, this also means "/"
            $routingConfig = explode('@', $config[$request['path']]);
            if ($verbosity > 0) {
                echo "<p>Routing Config matched for full path <code>" . $request['path'] . "</code>:</p><p>routing config is</p><pre>" . print_r($routingConfig, 1) . '</pre>';
            }
            // important: overwriting controller and action name
            $ctrlClass = $routingConfig[0];
            $actionName = $routingConfig[1];
        } else {
            if ($verbosity > 0) {
                echo "Request $ctrlName/$actionName was not in \$config.";
            }

            // fall back to filebased convention: match controller classes in directory
            $ctrlClass = ucfirst($ctrlName . 'Controller');
        }

        $ctrlFile = ($ctrlClass . '.php');
        $validControllers = FrontController::getValidControllers($controllerDirectory);
        if (!in_array($controllerDirectory . $ctrlFile, $validControllers)) {
            if ($verbosity > 0) {
                echo "<div><p>Controller: $ctrlFile not found in</p><pre>" . print_r($validControllers, 1) . "</pre><p>Config Array:</p><pre>" . print_r($config, 1) . "</pre></div>";
            }
            echo "<h1>Web Software Error</h1><img alt='shrug' src='https://c.tenor.com/9TEDud6eP2UAAAAC/woody-woodpecker-shrug-shoulders.gif'>" .
                "<p>Keine entspreche Zuordnung der Route für {$ctrlName}::{$actionName} gefunden. Tippfehler in der Route?" .
                "<p>Es konnte keine Klasse <abbr title='Gesucht im Verzeichnis {$controllerDirectory}'>" . $ctrlFile . "</abbr> gefunden werden! Request fehlgeschlagen.</p>" .
                "<p> Prüfen Sie die Einträge in der Datei <code>config/web.php</code> und gleichen Sie den getätigten Aufruf damit ab.</p>";
            exit(1);
        }

        // a file matching has been found, now try to load the class
        try {
            require_once $controllerDirectory . $ctrlFile;
            // instantiate the controller

            $controller = new $ctrlClass();
            $rd = new RequestData($method, $args, $query);

            if ($verbosity > 0) {
                var_dump($controller, $rd);
            }
            // the controller will load model and view and return some html
            print call_user_func_array(array($controller, $actionName), array($rd));
        } catch (Exception $ex) {
            print("<h2>Error in Controller. $ctrlClass</h2><p>Make sure, the path is correct and a corresponding Controller/Action exists.</p>");
            print($ex->getMessage());
        }
    }

    public static function getConfig($configPath)
    {
        try {
            // load the $config Array from a file given in $configPath
            $config = include $_SERVER['DOCUMENT_ROOT'] . '/' . $configPath;
        } catch (Exception $e) {
            $config = array('/' => 'HomeController@index');
        } finally {
            return $config;
        }
    }

    public static function getValidControllers($path = '')
    {
        if ($path == '') {
            $path = getcwd() . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;
        }
        return glob($path . '*Controller.php');
    }
}

function connectdb()
{
    $config = include CONFIG_DB;
    $link = mysqli_connect($config['host'], // Host der Datenbank (p: Persistent connection)
        $config['user'],       // Benutzername zur Anmeldung
        $config['password'],   // Passwort zur Anmeldung
        $config['database']);  // Auswahl der Datenbank
    if (!$link) {
        echo '<div class="error" style="background-color: #F08170; padding: 2em; margin: 4em">';
        echo "<h1>Verbindung mit der Datenbank nicht möglich</h1>";
        echo "<p style='margin-bottom: 2em;'>Verbindung fehlgeschlagen: <code>" . mysqli_connect_error() . "</code>.</p>";
        echo "<h2>Prüfen Sie</h2><ol><li>die Angaben in der Datei <code>config/db.php</code>:" .
            " ( ist Benutzer <code>{$config['user']}</code> an Datenbank <code>{$config['database']}</code> auf Server <code>{$config['host']}</code> korrekt?)<br>" .
            "</li><li>ob Ihre Datenbank unter der oben gezeigten Adresse läuft </li></ol>";
        echo "</div>";
        exit();
    }

    return $link;
}

function view($viewname, $viewargs = array())
{
    $views = dirname(__DIR__) . '/views';
    $cache = dirname(__DIR__) . '/storage/cache';
    $blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

    return $blade->run($viewname, $viewargs);
}

function logger(){
    $log = new Logger('name');
    $log->pushHandler(new StreamHandler('../storage/logs/logs.log'));
    return $log;
}