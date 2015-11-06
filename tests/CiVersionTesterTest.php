<?php namespace CiVersionTester;

require_once 'PHPUnit/Autoload.php';
require __DIR__ . '/../src/CiVersionTester.class.php';

class CiVersionTesterTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $CiVersionTests = new CiVersionTests;
        $this->assertTrue(TRUE);
    }
}
