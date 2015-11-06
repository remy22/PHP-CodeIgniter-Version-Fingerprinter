<?php
require __DIR__ . '/../src/CiVersionTester.class.php';

class CiVersionTesterTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $version = '1';
        $ciVersionTests = new CiVersionTester\CiVersionTests;
        $ciVersionTests->test('controllersIndexHtml', $version);
        $ciVersionTests->test('userGuideVersion', $version);
        $ciVersionTests->test('applicationFolder', $version);
        $ciVersionTests->test('librariesCalendar', $version);
        $ciVersionTests->test('modelsIndexHtml', $version);
        $ciVersionTests->test('licenseTxt', $version);
        $ciVersionTests->test('systemInitUnitTest', $version);
    }
}
