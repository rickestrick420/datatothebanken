<?php
/**
 * Mapping of paths to controllers.
 * Note, that the path only supports one level of directory depth:
 *     /demo is ok,
 *     /demo/subpage will not work as expected
 */

return array(
    '/'             => 'HomeController@index',
    '/home'         => 'HomeController@index',
    '/demo'         => 'DemoController@demo',
    '/dbconnect'    => 'DemoController@dbconnect',
    '/debug'        => 'HomeController@debug',


    // Erstes Beispiel:
    '/m4_6a_queryparameter' => 'ExampleController@m4_6a_queryparameter',
    '/queryparameter'       => 'ExampleController@m4_6a_queryparameter',
    '/m4_6b_kategorie'      => 'ExampleController@m4_6b_kategorie',
    '/kategorie'            => 'ExampleController@m4_6b_kategorie',
    '/m4_6c_gerichte'       => 'ExampleController@m4_6c_gerichte',
    '/gerichte'             => 'ExampleController@m4_6c_gerichte',
    '/m4_6d_layout'         => 'ExampleController@m4_6d_layout',
    '/layout'               => 'ExampleController@m4_6d_layout',
    '/m4'                   => 'ExampleController@m4_6a_queryparameter',

    // Login
    '/anmeldung'                => 'AuthController@logi',
    '/anmeldung_verifizieren'   => 'AuthController@verifikation',
    '/abmeldung'                => 'AuthController@abmelden',

    //Bewertungen
    '/bewertung'                => 'HomeController@bewertung',
    '/bewertung_hochladen'      => 'HomeController@bewertunghochladen',
    '/bewertungen'                => 'HomeController@bewertungen',
    '/meinebewertungen'         => 'HomeController@meineBewertungen',
    '/bewertungloeschen'         => 'HomeController@bewertungloeschen',
    '/bewertunghervorheben'         => 'HomeController@bewertunghervorheben'


);