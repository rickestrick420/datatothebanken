<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/kategorie.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/gericht.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/gerichteover2.php');

class ExampleController
{
    public function m4_6a_queryparameter(RequestData $rd) {

        $vars = [
            'name' => $rd->query['name'] ?? 'Max Mustermann',
            'request' => $rd,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ];

        return view('examples.m4_6a_queryparameter',  $vars);

    }

    public function m4_6b_kategorie(RequestData $rd) {
        $data = db_kategorie_select_all();

        return view('examples.m4_6b_kategorie',  ['data' => $data]);
    }

    public function m4_6c_gerichte(RequestData $rd) {
        $data = db_gerichteover2();
        $vars = [
            'data' => $data,
            'rd' => $rd,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ];
        return view('examples.m4_6c_gerichte',$vars);
    }

    public function m4_6d_layout(RequestData $rd) {
        $vars = [
            'no' => $rd->query['no'] ?? '1',
            'request' => $rd,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ];
        if($vars['no'] == '1'){
            return view('examples.pages.m4_6d_page', $vars);
        } else {
            return view('examples.pages.m4_6d_page_2', $vars);
        }
    }
}