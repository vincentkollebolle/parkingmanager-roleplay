<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Interface/ObserverInterface.php';

class ObserverInterfaceTest extends TestCase
{
    public function testInterfaceExists()
    {
        $this->assertTrue(interface_exists('ObserverInterface'));
    }
}
