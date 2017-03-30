<?php

namespace Lidercap\Tests\Component\Fileversion;

use Lidercap\Component\Fileversion\Fileversion;
use Lidercap\Component\Fileversion\FileversionInterface;

class FileversionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Fileversion
     */
    protected $fileVersion;

    public function setUp()
    {
        $this->fileVersion = new Fileversion;
    }

    public function testInterface()
    {
        $this->assertInstanceOf(FileversionInterface::class, $this->fileVersion);
    }

    public function testIsNotUpdated()
    {
        $this->assertFalse($this->fileVersion->isUpdated());
    }

    public function testIsOutdated()
    {
        $this->assertTrue($this->fileVersion->isOutdated());
    }

    public function testVersion()
    {
        $this->assertEquals(1, $this->fileVersion->version());
    }

    public function testFetch()
    {
        $this->assertEquals([1], $this->fileVersion->fetch());
    }

    public function testRead()
    {
        $this->assertEquals('{"key": "value"}', $this->fileVersion->read());
    }

    public function testWrite()
    {
        $contents = 'this is my ramdom content ' . rand(1, 100);
        $object   = $this->fileVersion->write($contents);
        $this->assertInstanceOf(Fileversion::class, $object);
    }

    public function testClearDefaultValue()
    {
        $object = $this->fileVersion->clear();
        $this->assertInstanceOf(Fileversion::class, $object);
    }
}
