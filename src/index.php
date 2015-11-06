<?php
    include 'CiVersionTester.class.php';
    
// TEST CASE

$opendir = opendir('C:\Users\KM\Desktop\CodeIgniterVersionTester\root\codeigniter-version-detect');

$versions = array();
while ($dirname = readdir($opendir)) {
    if ($dirname != '.' && $dirname != '..') {
        if (substr($dirname,0,11) == 'CodeIgniter') {
            $versions[] = $dirname;
        }
    }
}

foreach ($versions as $version) {
    $CiVersionTests = new CiVersionTests;
    $uri = 'http://localhost:8080/codeigniter-version-detect/' . $version .'/' . $version . '/';
    $CiVersionTests->url = $uri;

    //$avv = $_POSSIBLE_VERSIONS;
    $evv = explode('_', $version);
    $version = $evv[1];

    //echo '<strong>URL</strong>: ' . $CiVersionTests->url . '<br>';
    echo '<br>Testing version ' . $version . ' ... ';

    echo '<table style="font-size:11px">';
    $CiVersionTests->test('controllersIndexHtml', $version);
    $CiVersionTests->test('userGuideVersion', $version);
    $CiVersionTests->test('applicationFolder', $version);
    $CiVersionTests->test('librariesCalendar', $version);
    $CiVersionTests->test('modelsIndexHtml', $version);
    $CiVersionTests->test('licenseTxt', $version);
    //$CiVersionTests->test('system_init_unit_test', $version);
    echo '</table>';
}
