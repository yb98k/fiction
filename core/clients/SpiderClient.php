<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 19-1-30
 * Time: 下午3:06
 */

namespace core\clients;


use core\Agency;
use core\Command;

class SpiderClient
{
    public static function addConfig(Agency $config)
    {

        $client = new \Swoole\Client(SWOOLE_SOCK_TCP);

        $linkRes = $client->connect($config->get('host'), $config->get('port'), -1);
        if(!$linkRes) {
            throw new \Exception('connect failed, error:' . var_export($client->errCode));
        }

        $data = [
            'action' => 'add',
            'host' => $config->get('host'),
            'port' => $config->get('port'),
            'setting' => $config->get('setting')
        ];

        $client->send(json_encode($data));

        Command::displayMsg($client->recv(), 'green');

        $client->close();
    }

    public static function repeatRequest(Agency $config)
    {

        $client = new \Swoole\Client(SWOOLE_SOCK_TCP);

        $linkRes = $client->connect($config->get('host'), $config->get('port'), -1);
        if(!$linkRes) {
            throw new \Exception('connect failed, error:' . var_export($client->errCode));
        }

        $data = [
            'action' => 'repeat',
            'host' => $config->get('host'),
            'port' => $config->get('port'),
            'setting' => $config->get('setting')
        ];

        $client->send(json_encode($data));

        Command::displayMsg($client->recv(), 'green');

        $client->close();
    }
}