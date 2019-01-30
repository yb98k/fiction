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

        $client->send('11111');

        Command::displayMsg($client->recv(), 'green');

        $client->close();
    }
}