<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 19-1-30
 * Time: 上午9:33
 */

namespace core\servers;

use common\FunctionTrait;
use core\Agency;
use core\clients\SpiderClient;
use core\Command;
use core\inf\Crawler;
use function FastRoute\TestFixtures\empty_options_cached;

class SpiderServer
{
    protected $server;

    use FunctionTrait;

    public function __construct(Agency $config)
    {
        $table = new \swoole_table(20);
        $table->column('count',\swoole_table::TYPE_INT, 1);
        $table->create();

        $this->server = new \Swoole\Server(
            $config->get('host'),
            $config->get('port'),
            SWOOLE_BASE,
            SWOOLE_SOCK_TCP
        );

        $this->server->table = $table;

        $setting = $config->get('setting');
        if($setting) {
            $this->server->set($setting);
        }

        $this->server->on('start', [$this, 'start']);
        $this->server->on('workerStart', [$this, 'workerStart']);
        $this->server->on('receive', [$this, 'receive']);
        $this->server->on('close', [$this, 'close']);
    }

    public function run()
    {
        $this->server->start();
    }

    public function start()
    {
        $this->server->table->set('processCount', ['count' => 0]);

        swoole_set_process_name('yb_fiction_spider_server');
    }

    public function workerStart(\Swoole\Server $server, int $workerId)
    {

    }

    public function receive(\Swoole\Server $server, $fd, $reactorId, $data)
    {
        $dataArray = json_decode($data, true);

        if(empty($dataArray['action'])){
            $server->send($fd, 'UNKNOWN');
        } else {
            if($dataArray['action'] == 'add' && isset($dataArray['setting'])) {

                $configArray = [
                    'host' => $dataArray['host'],
                    'port' => $dataArray['port'],
                    'setting' => $dataArray['setting']
                ];

                $config = new \core\Agency(new \core\features\Config($configArray));
                $class = $config->get('setting')['class'] ?? null;
                if(class_exists($class)) {
                    $crawler = new $class($config);
                    \Swoole\Async::dnsLookup($crawler->getParam('host'), function ($host, $ip) use($crawler){
                        $crawler->run();
                    });
                }

                $server->send($fd, 'ADD SUCCESS');
            }
        }
    }

    public function close(\Swoole\Server $server, int $fd, int $reactorId)
    {
        //
    }
}