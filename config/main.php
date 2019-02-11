<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 19-1-30
 * Time: 上午10:44
 */



return [
   'component' => [
       'redis' => [
           'class' => 'Predis\Client',
           'config' => [
               'host' => '127.0.0.1',
               'port' => 6379,
           ]
       ],
       'fileCache' => [
           'class' => 'Symfony\Component\Cache\Adapter\FilesystemAdapter'
       ],
   ]
];