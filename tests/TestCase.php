<?php
namespace Lyon\Test;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use org\bovigo\vfs\vfsStream;
use \ReflectionClass;

class TestCase extends PHPUnitTestCase
{
    public function mockFile($filename, $content)
    {
        $root = vfsStream::setup();
        vfsStream::newFile($filename)->at($root)->setContent($content);
        return $root->url();
    }

    public function mockUnpublicMethod($object, $methodName, $args)
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }
}
