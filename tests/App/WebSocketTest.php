<?php
namespace Lyon\Test\Library;

use App\WebSocket;
use Lyon\Test\TestCase;
use Lyon\Config;

class WebSocketTest extends TestCase
{
    public function testInitInstance()
    {
        // 创建模拟文件
        $filename = 'server.php';
        $content = "<?php return ['ip' => 9501, 'port' => '0.0.0.0'];";
        $this->dir = $this->mockFile($filename, $content);

        // 创建配置实例
        $config = Config::instance();
        $config->setPath($this->dir);

        // 创建 WebSocket
        $wc = new WebSocket($config);
        $this->assertAttributeEquals(['ip' => 9501, 'port' => '0.0.0.0'], 'config', $wc);
        $this->assertAttributeEquals(9501, 'ip', $wc);
        $this->assertAttributeEquals('0.0.0.0', 'port', $wc);
    }
}
