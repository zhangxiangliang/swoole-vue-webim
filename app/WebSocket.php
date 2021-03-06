<?php

namespace App;

use Lyon\Config;
use \Exception;
use \Swoole\WebSocket\Server;

class WebSocket
{
    const CONNECT_TYPE = 'connect';
    const DISCONNECT_TYPE = 'disconnect';
    const MESSAGE_TYPE = 'message';
    const INIT_SELF_TYPE = 'self_init';
    const INIT_OTHER_TYPE = 'other_init';
    const COUNT_TYPE = 'count';

    private $server;
    private $config;
    private $ip;
    private $port;

    public function __construct(Config $config)
    {
        $this->makeConfig($config);
        $this->loadConfig(['ip', 'port']);
    }

    protected function makeConfig($instance)
    {
        $this->config = $instance['server'];
    }

    protected function loadConfig($configs)
    {
        foreach ($configs as $config) $this->$config = $this->config[$config];
    }
}
