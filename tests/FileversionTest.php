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

    /**
     * @var string
     */
    protected $workingDir = '/tmp/file-version-test/';

    public function setUp()
    {
        $this->fileVersion = new Fileversion;
        $this->tearDown();
        @mkdir($this->workingDir);
    }

    public function tearDown()
    {
        array_map('unlink', glob($this->workingDir . '*'));
        @rmdir($this->workingDir);
    }

    public function testInterface()
    {
        $this->assertInstanceOf(FileversionInterface::class, $this->fileVersion);
    }

    public function testVersions1()
    {
        $this->assertEquals([1], $this->fileVersion->versions());
    }

    public function testVersions2()
    {
        $version  = rand(1, 100);
        $filePath = '/tmp/file-' . md5(microtime(true)) . '.txt';
        $contents = 'this is my random test content ' . rand(1, 100);

        file_put_contents($filePath . '.a', $contents);
        file_put_contents($filePath . '.b', $contents);
        file_put_contents($filePath . '.c', $contents);
        file_put_contents($filePath . '.1', $contents);
        file_put_contents($filePath . '.2', $contents);
        file_put_contents($filePath . '.3', $contents);
        file_put_contents($filePath . '-another.1', $contents);
        file_put_contents($filePath . '-another.2', $contents);
        file_put_contents($filePath . '-another.3', $contents);
        file_put_contents($filePath . '-unversioned', $contents);
        $this->fileVersion->setPath($filePath);

        $versions = $this->fileVersion->versions();
        $this->assertEquals([1,2,3], $versions);
    }

    public function testVersions3()
    {
        $version  = rand(1, 100);
        $filePath = '/tmp/file-' . md5(microtime(true)) . '.txt';
        $contents = 'this is my random test content ' . rand(1, 100);

        file_put_contents($filePath . '.a', $contents);
        file_put_contents($filePath . '.b', $contents);
        file_put_contents($filePath . '.c', $contents);
        file_put_contents($filePath . '-another.1', $contents);
        file_put_contents($filePath . '-another.2', $contents);
        file_put_contents($filePath . '-another.3', $contents);
        file_put_contents($filePath . '-unversioned', $contents);
        $this->fileVersion->setPath($filePath);

        $versions = $this->fileVersion->versions();
        $this->assertEquals([1], $versions);
    }

    public function testVersion1()
    {
        $version = $this->fileVersion->version();
        $this->assertInternalType('int', $version);
        $this->assertEquals(1, $version);
    }

    public function testVersion2()
    {
        $filePath = $this->workingDir . 'file-' . md5(microtime(true));
        $contents = 'this is my random test content ' . rand(1, 100);

        file_put_contents($filePath, $contents);
        $this->fileVersion->setPath($filePath);

        $version = $this->fileVersion->version();
        $this->assertInternalType('int', $version);
        $this->assertEquals(1, $version);
    }

    public function testVersion3()
    {
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';
        $contents = 'this is my random test content ' . rand(1, 100);

        file_put_contents($filePath, $contents);
        $this->fileVersion->setPath($filePath);

        $version = $this->fileVersion->version();
        $this->assertInternalType('int', $version);
        $this->assertEquals(1, $version);
    }

    public function testVersion4()
    {
        $version  = rand(1, 100);
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';
        $contents = 'this is my random test content ' . rand(1, 100);

        file_put_contents($filePath . '.' . $version, $contents);
        $this->fileVersion->setPath($filePath);

        $this->assertEquals($version, $this->fileVersion->version());
    }

    public function testIsUpdated1()
    {
        $this->assertTrue($this->fileVersion->isUpdated());
    }

    public function testIsUpdated2()
    {
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';
        $this->fileVersion->setPath($filePath);

        $contents = 'this is my random content ' . rand(1, 100);
        $this->fileVersion->write($contents);

        $this->assertTrue($this->fileVersion->isUpdated());
    }

    public function testIsUpdated3()
    {
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';
        $this->fileVersion->setPath($filePath);

        $contents = 'this is my random content ' . rand(1, 100);
        for ($i = 1; $i <= 10; $i++) {
            $this->fileVersion->write($contents);
        }

        $this->assertFalse($this->fileVersion->isUpdated());
    }

    public function testIsUpdated4()
    {
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';
        $this->fileVersion->setPath($filePath);

        $contents = 'this is my random content ' . rand(1, 100);
        $this->fileVersion->write($contents . '1');
        $this->fileVersion->write($contents . '2');

        $this->assertTrue($this->fileVersion->isUpdated());
    }

    public function testRead1()
    {
        $filePath = $this->workingDir . 'unexistent-file-' . md5(microtime(true)) . '.txt';
        $this->fileVersion->setPath($filePath);
        $this->assertFalse($this->fileVersion->read());
    }

    public function testRead2()
    {
        $version  = rand(1, 100);
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';

        $contents1 = 'this is my first random test content ' . rand(1, 100);
        $contents2 = 'this is my seccond random test content ' . rand(1, 100);
        $contents3 = 'this is my third random test content ' . rand(1, 100);

        file_put_contents($filePath . '.1', $contents1);
        file_put_contents($filePath . '.2', $contents2);
        file_put_contents($filePath . '.3', $contents3);
        file_put_contents($filePath . '-another.1', $contents1);
        file_put_contents($filePath . '-another.2', $contents2);
        file_put_contents($filePath . '-another.3', $contents3);
        $this->fileVersion->setPath($filePath);

        $this->assertEquals($contents3, $this->fileVersion->read());
    }

    public function testWrite1()
    {
        $version  = 1;
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';
        $this->fileVersion->setPath($filePath);

        $contents = 'this is my random content ' . rand(1, 100);
        $object   = $this->fileVersion->write($contents);
        $this->assertInstanceOf(Fileversion::class, $object);

        $this->assertEquals($version, $this->fileVersion->version());
        $this->assertEquals($contents, $this->fileVersion->read());
    }

    public function testWrite2()
    {
        $version  = 2;
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';
        $this->fileVersion->setPath($filePath);

        $contents1 = 'this is my random content ' . rand(1, 100);
        $this->fileVersion->write($contents1);

        $contents2 = 'this is my random content ' . rand(1, 100);
        $this->fileVersion->write($contents2);

        $this->assertEquals($version, $this->fileVersion->version());
        $this->assertEquals($contents2, $this->fileVersion->read());
    }

    public function testDelete1()
    {
        $this->fileVersion->delete(rand(1, 100));
    }

    public function testDelete2()
    {
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';
        $this->fileVersion->setPath($filePath);

        $contents1 = 'this is my random content ' . rand(1, 100);
        $this->fileVersion->write($contents1);

        $contents2 = 'this is my random content ' . rand(1, 100);
        $this->fileVersion->write($contents2);

        $object = $this->fileVersion->delete(1);
        $this->assertInstanceOf(Fileversion::class, $object);

        $this->assertFileNotExists($filePath . '.1');
        $this->assertFileExists($filePath . '.2');
    }

    public function testDelete3()
    {
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';
        $this->fileVersion->setPath($filePath);

        $contents1 = 'this is my random content ' . rand(1, 100);
        $this->fileVersion->write($contents1);

        $contents2 = 'this is my random content ' . rand(1, 100);
        $this->fileVersion->write($contents2);

        $object = $this->fileVersion->delete(2);
        $this->assertInstanceOf(Fileversion::class, $object);

        $this->assertFileNotExists($filePath . '.2');
        $this->assertFileExists($filePath . '.1');
    }

    public function testClear1()
    {
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';
        $this->fileVersion->setPath($filePath);

        $contents1 = 'this is my random content ' . rand(1, 100);
        $this->fileVersion->write($contents1);

        $object = $this->fileVersion->clear();
        $this->assertInstanceOf(Fileversion::class, $object);
    }

    public function testClear2()
    {
        $keep     = rand(1, 3);
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';
        $this->fileVersion->setPath($filePath);

        for ($i = 1; $i <= $keep; $i++) {
            $this->fileVersion->write('this is my random content ' . rand(1, 100));
        }

        $object = $this->fileVersion->clear($keep);
        $this->assertInstanceOf(Fileversion::class, $object);
    }

    public function testClear3()
    {
        $keep     = 3;
        $filePath = $this->workingDir . 'file-' . md5(microtime(true)) . '.txt';
        $this->fileVersion->setPath($filePath);

        for ($i = 1; $i <= 10; $i++) {
            $this->fileVersion->write('this is my random content ' . rand(1, 100));
        }

        $object = $this->fileVersion->clear($keep);
        $this->assertInstanceOf(Fileversion::class, $object);

        $this->assertFileExists($filePath . '.10');
        $this->assertFileExists($filePath . '.9');
        $this->assertFileExists($filePath . '.8');
        $this->assertFileNotExists($filePath . '.7');
        $this->assertFileNotExists($filePath . '.6');
        $this->assertFileNotExists($filePath . '.5');
        $this->assertFileNotExists($filePath . '.4');
        $this->assertFileNotExists($filePath . '.3');
        $this->assertFileNotExists($filePath . '.2');
        $this->assertFileNotExists($filePath . '.1');
    }
}
