<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 19-1-30
 * Time: 上午9:33
 */

namespace core\servers;

use core\Agency;

class SpiderServer
{
    protected $server;

    public function __construct(Agency $config)
    {
        $this->server = new \Swoole\Server(
            $config->get('host'),
            $config->get('port'),
            SWOOLE_BASE,
            SWOOLE_SOCK_TCP
        );

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
        swoole_set_process_name('yb_fiction_spider_server');
    }

    public function workerStart(\Swoole\Server $server, int $workerId)
    {

    }

    public function receive(\Swoole\Server $server, $fd, $reactorId, $data)
    {
        var_dump($data);
        $server->send($fd, '2222');
    }

    public function close(\Swoole\Server $server, int $fd, int $reactorId)
    {
        //
    }
}