<?php

include 'CiVersionTester.class.php';

$opendir = opendir('codeigniter-version-detect');

$versions = array();
while ($dirname = readdir($opendir)) {
    if ($dirname != '.' AND $dirname != '..') {
        if (substr($dirname, 0, 11) == 'CodeIgniter') {
            $versions[] = $dirname;
        }
    }
}

foreach ($versions as $version) {
    $ciVersionTests = new CiVersionTests;
    $ciVersionTests->url = 'http://localhost:8080/codeigniter-version-detect/' . $version .'/' . $version . '/';

    $evv = explode('_', $version);
    $version = $evv[1];

    echo '<br>Testing version ' . $version . ' ... ';

    echo '<table style="font-size:11px">';
    echo '<tr><td>' . $ciVersionTests->test('controllersIndexHtml', $version) . '</td></tr>';
    echo '<tr><td>' . $ciVersionTests->test('userGuideVersion', $version) . '</td></tr>';
    echo '<tr><td>' . $ciVersionTests->test('applicationFolder', $version) . '</td></tr>';
    echo '<tr><td>' . $ciVersionTests->test('librariesCalendar', $version) . '</td></tr>';
    echo '<tr><td>' . $ciVersionTests->test('modelsIndexHtml', $version) . '</td></tr>';
    echo '<tr><td>' . $ciVersionTests->test('licenseTxt', $version) . '</td></tr>';
    echo '<tr><td>' . $ciVersionTests->test('systemInitUnitTest', $version) . '</td></tr>';
    echo '</table>';
}
