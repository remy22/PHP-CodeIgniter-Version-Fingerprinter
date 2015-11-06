<?php
require __DIR__ . '/../src/CiVersionTester.class.php';

class CiVersionTesterTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $version = '1';
        $CiVersionTests = new CiVersionTester\CiVersionTests;
        $CiVersionTests->test('controllersIndexHtml', $version);
        $CiVersionTests->test('userGuideVersion', $version);
        $CiVersionTests->test('applicationFolder', $version);
        $CiVersionTests->test('librariesCalendar', $version);
        $CiVersionTests->test('modelsIndexHtml', $version);
        $CiVersionTests->test('licenseTxt', $version);
        $CiVersionTests->test('systemInitUnitTest', $version);
    }
}
