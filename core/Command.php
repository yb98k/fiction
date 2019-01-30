<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 19-1-30
 * Time: 下午2:48
 */

namespace core;


use core\clients\SpiderClient;

class Command
{
    /**
     * 监听命令
     * @param $argv
     * @throws \Exception
     */
    public static function listenCommand($argv)
    {
        if(isset($argv[1]) && $argv[1] == 'add') {
            if(!isset($argv[2])) {
                throw new \Exception('add command need path');
            }

            $filename = strpos($argv[2], '.php') === false ? $argv[2] . '.php' : $argv[2];
            $filePath = __DIR__ . '/../spiderRules/' . $filename;
            if(!file_exists($filePath)) {
                throw new \Exception($filePath . ' not exist');
            }

            $config = new \core\Agency(new \core\features\Config(require ($filePath)));
            SpiderClient::addConfig($config);
            exit(0);
        }
    }

    /**
     * 信息输出格式化
     * @param $content
     * @param string $colour
     * @param string $type
     */
    public static function displayMsg($content, $colour = 'red', $type = ''){
        switch($colour){
            case 'red':
            case '红':
                $strStart = "\033[31;40m";
                break;
            case 'green':
            case '绿':
                $strStart = "\033[32;40m";
                break;
            case 'yellow':
            case '黄':
                $strStart = "\033[33;40m";
                break;
            case 'blue':
            case '蓝':
                $strStart = "\033[34;40m";
                break;
            case 'violet':
            case '紫':
                $strStart = "\033[35;40m";
                break;
            default :
                $strStart = "\033[0m";
        }

        if($type == 'center'){
            $len = (strlen($content) + mb_strlen($content)) / 4;
            for($i = $len; $i < 50; $i++){
                $content = "=$content=";
            }
        }

        $content = $strStart . $content . "\033[0m" . PHP_EOL;

        echo $content;
    }
}