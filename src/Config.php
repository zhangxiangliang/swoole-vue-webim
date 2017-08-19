<?php

namespace Lyon;

use \Exception;

class Config implements \ArrayAccess
{
    private $path;
    private $config;
    private static $instance;

    public static function instance()
    {
        if(!(self::$instance instanceof Config))
            self::$instance = new Config();
        return self::$instance;
    }

    public function setPath($path)
    {
        $path = $this->formatPath($path);
        $this->config = $this->path == $path ? $this->config : [];
        $this->path = $path;
    }

    private function formatPath($path)
    {
        return substr($path, -1) == '/' ? $path : $path . '/';
    }

    public function offsetExists($offset)
    {
        return isset($this->config[$offset]);
    }

    public function offsetGet($offset)
    {
        $filename = $this->path.$offset.'.php';

        if(empty($this->config[$offset])) {
            if (file_exists($filename)) $this->config[$offset] = require $filename;
            else throw new Exception("配置文件不存在");
        }

        return $this->config[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new Exception("不提供设置配置");
    }

    public function offsetUnset($offset)
    {
        throw new Exception('不提供删除配置');
    }
}
