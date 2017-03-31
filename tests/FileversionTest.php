<?php

namespace Lidercap\Tests\Component\Fileversion;

use Lidercap\Component\Fileversion\Fileversion;
use Lidercap\Component\Fileversion\FileversionInterface;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class FileversionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Fileversion
     */
    protected $fileVersion;

    /**
     * @var vfsStreamDirectory
     */
    protected $workingDir;

    public function setUp()
    {
        $this->fileVersion = new Fileversion;
        $this->workingDir  = vfsStream::setup('tmp');
    }

    public function testInterface()
    {
        $this->assertInstanceOf(FileversionInterface::class, $this->fileVersion);
    }

    public function testIsNotUpdated()
    {
        $this->assertFalse($this->fileVersion->isUpdated());
    }

    public function testVersion1()
    {
        $this->assertEquals(1, $this->fileVersion->version());
    }

    public function testVersion2()
    {
        $filePath = $this->workingDir->url() . '/file-' . md5(microtime(true));
        $contents = 'this is my random test content ' . rand(1, 100);

        file_put_contents($filePath, $contents);
        $this->fileVersion->setPath($filePath);

        $this->assertEquals(1, $this->fileVersion->version());
    }

    public function testVersion3()
    {
        $filePath = $this->workingDir->url() . '/file-' . md5(microtime(true)) . '.txt';
        $contents = 'this is my random test content ' . rand(1, 100);

        file_put_contents($filePath, $contents);
        $this->fileVersion->setPath($filePath);

        $this->assertEquals(1, $this->fileVersion->version());
    }

    public function testVersion4()
    {
        $version  = rand(1, 100);
        $filePath = $this->workingDir->url() . '/file-' . md5(microtime(true)) . '.txt';
        $contents = 'this is my random test content ' . rand(1, 100);

        file_put_contents($filePath, $contents);
        $this->fileVersion->setPath($filePath);

        $this->assertEquals($version, $this->fileVersion->version());
    }

    public function testFetch()
    {
        $version  = rand(1, 100);
        $filePath = $this->workingDir->url() . '/file-' . md5(microtime(true)) . '.txt';
        $contents = 'this is my random test content ' . rand(1, 100);

        file_put_contents($filePath . '.1', $contents);
        file_put_contents($filePath . '.2', $contents);
        file_put_contents($filePath . '.3', $contents);
        $this->fileVersion->setPath($filePath);

        $this->assertEquals([1,2,3], $this->fileVersion->fetch());
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