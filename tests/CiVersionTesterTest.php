<?php
require __DIR__ . '/../src/CiVersionTester.class.php';

class CiVersionTesterTest extends PHPUnit_Framework_TestCase
{
    //public function testEmpty()
    //{
    //    $this->assertFalse(new CiVersionTester\CiVersionTests()); 
    //}
    
    public function testCi()
    {
        $version = '3.0.3';
        $ciVersionTests = new CiVersionTester\CiVersionTests('http://www.codeigniter.com/');
        $ciVersionTests->test('controllersIndexHtml', $version);
        $ciVersionTests->test('userGuideVersion', $version);
        $ciVersionTests->test('applicationFolder', $version);
        $ciVersionTests->test('librariesCalendar', $version);
        $ciVersionTests->test('modelsIndexHtml', $version);
        $ciVersionTests->test('licenseTxt', $version);
        $ciVersionTests->test('systemInitUnitTest', $version);
    }

    public function testHairstreet()
    {
        $version = '2.2.0';
        $ciVersionTests = new CiVersionTester\CiVersionTests('http://www.hairstreet.com/');
        $ciVersionTests->test('controllersIndexHtml', $version);
        $ciVersionTests->test('userGuideVersion', $version);
        $ciVersionTests->test('applicationFolder', $version);
        $ciVersionTests->test('librariesCalendar', $version);
        $ciVersionTests->test('modelsIndexHtml', $version);
        $ciVersionTests->test('licenseTxt', $version);
        $ciVersionTests->test('systemInitUnitTest', $version);
    }
    
    public function testVesta()
    {
        $version = '2.1.4';
        $ciVersionTests = new CiVersionTester\CiVersionTests('https://www.vestavuurwerk.nl');
        $ciVersionTests->test('controllersIndexHtml', $version);
        $ciVersionTests->test('userGuideVersion', $version);
        $ciVersionTests->test('applicationFolder', $version);
        $ciVersionTests->test('librariesCalendar', $version);
        $ciVersionTests->test('modelsIndexHtml', $version);
        $ciVersionTests->test('licenseTxt', $version);
        $ciVersionTests->test('systemInitUnitTest', $version); 
    }
    
    public function testGraviton()
    {
        $version = '1.7.2';
        $ciVersionTests = new CiVersionTester\CiVersionTests('http://gravitonbouldergym.nl/gdb/');
        $ciVersionTests->test('controllersIndexHtml', $version);
        $ciVersionTests->test('userGuideVersion', $version);
        $ciVersionTests->test('applicationFolder', $version);
        $ciVersionTests->test('librariesCalendar', $version);
        $ciVersionTests->test('modelsIndexHtml', $version);
        $ciVersionTests->test('licenseTxt', $version);
        $ciVersionTests->test('systemInitUnitTest', $version);
    }
    
    public function testFnq()
    {
        $version = '1.5.3';
        $ciVersionTests = new CiVersionTester\CiVersionTests('https://www.fnqapartments.com/res/');
        $ciVersionTests->test('controllersIndexHtml', $version);
        $ciVersionTests->test('userGuideVersion', $version);
        $ciVersionTests->test('applicationFolder', $version);
        $ciVersionTests->test('librariesCalendar', $version);
        $ciVersionTests->test('modelsIndexHtml', $version);
        $ciVersionTests->test('licenseTxt', $version);
        $ciVersionTests->test('systemInitUnitTest', $version);
    }
    
    public function testAudk()
    {
        $version = '1.5.1';
        $ciVersionTests = new CiVersionTester\CiVersionTests('http://cs.au.dk/~grav/hypweb/codeigniter/');
        $ciVersionTests->test('controllersIndexHtml', $version);
        $ciVersionTests->test('userGuideVersion', $version);
        $ciVersionTests->test('applicationFolder', $version);
        $ciVersionTests->test('librariesCalendar', $version);
        $ciVersionTests->test('modelsIndexHtml', $version);
        $ciVersionTests->test('licenseTxt', $version);
        $ciVersionTests->test('systemInitUnitTest', $version);
    }
}
