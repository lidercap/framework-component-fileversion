<?php

namespace Lidercap\Tests\Component\Fileversion\Behavior;

use Lidercap\Component\Fileversion\Behavior\PathAware;

class PathAwareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PathAware
     */
    protected $trait;

    public function setUp()
    {
        $this->trait = $this->getMockForTrait(PathAware::class);
    }

    /**
     * @return array
     */
    public function providerPathsAndNames()
    {
        return [
            ['/path/to/the/file'],
            ['/path/to/the/file.txt'],
            ['/path/to/the/file.txt.' . rand(1, 100)],

            ['file'],
            ['file.txt'],
            ['file.txt.' . rand(1, 100)],
        ];
    }

    /**
     * @dataProvider providerPathsAndNames
     *
     * @param string $path
     */
    public function testSetPath($path)
    {
        $object = $this->trait->setPath($path);
        $this->assertTrue(is_object($object));

        $property = new \ReflectionProperty($this->trait, 'path');
        $property->setAccessible(true);

        $value = $property->getValue($this->trait);

        $exploded = (array)@explode('.', $value);
        $this->assertFalse(is_numeric(end($exploded)));
    }

    public function testGetPath1()
    {
        $this->assertNull($this->trait->getPath());
    }

    public function testGetPath2()
    {
        $path  = '/path/to/the/file-' . rand(1, 100) . '.txt';
        $value = $this->trait->setPath($path)->getPath();
        $this->assertEquals($path, $value);
    }

    /**
     * @dataProvider providerPathsAndNames
     *
     * @param string $string
     */
    public function testSuffixRemove($string)
    {
        $method = new \ReflectionMethod($this->trait, 'suffixRemove');
        $method->setAccessible(true);

        $result = $method->invokeArgs($this->trait, [$string]);

        $exploded = (array)@explode('.', $result);
        $this->assertFalse(is_numeric(end($exploded)));
    }
}
