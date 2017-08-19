<?php

use Lyon\Config;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

class ConfigTest extends TestCase
{
    private $dir;

    public function testInstanceReturnConfigInstance()
    {
        $config = Config::instance();
        $this->assertInstanceOf(Config::class, $config);
    }

    public function testSetPathWhenPathUnset()
    {
        $expected = "/lyon/";
        $config = Config::instance();
        $config->setPath($expected);
        $this->assertAttributeEquals($expected, 'path', $config);
        $this->assertAttributeEquals([], 'config', $config);
    }

    public function testSetPathWhenPathIsset()
    {
        $config = Config::instance();
        $config->setPath("/lyon/");
        $config->setPath("/zhongze/");
        $this->assertAttributeEquals("/zhongze/", 'path', $config);
        $this->assertAttributeEquals([], 'config', $config);
    }

    public function testSetPathWhenPathRepeat()
    {
        $config = $this->createConfigInstance();
        $port = $config['server']['port'];
        $config->setPath($this->dir);
        $this->assertAttributeEquals(['server' => ['port' => 9501]], 'config', $config);
    }

    public function testOffsetGetWithKeyIsDefine()
    {
        $config = $this->createConfigInstance();
        $this->assertEquals(9501, $config['server']['port']);

    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage 配置文件不存在
     */
    public function testOffsetGetWithKeyIsUndefine()
    {
        $config = $this->createConfigInstance();
        $config['lyon'];
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage 不提供设置配置
     */
    public function testOffsetSet()
    {
        $config = $this->createConfigInstance();
        $config['server'] = 9527;
    }

    public function testOffsetExists()
    {
        $config = $this->createConfigInstance();
        $this->assertEquals(true, isset($config['server']));
        $this->assertEquals(false, isset($config['lyon']));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage 不提供删除配置
     */
    public function testOffsetUnset()
    {
        $config = $this->createConfigInstance();
        unset($config['server']);
    }

    private function createFileByFilenameAndContent($filename, $content)
    {
        $root = vfsStream::setup();
        vfsStream::newFile($filename)->at($root)->setContent($content);
        return $root->url();
    }

    private function createConfigInstance()
    {
        $filename = 'server.php';
        $content = "<?php return ['port' => 9501];";
        $this->dir = $this->createFileByFilenameAndContent($filename, $content);

        $config = Config::instance();
        $config->setPath($this->dir);

        return $config;
    }
}
