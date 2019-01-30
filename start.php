#!/usr/bin/env php
<?php

include( __DIR__ . '/vendor/autoload.php' );


try{
    $DI = new \core\Container(require( __DIR__ . '/config/main.php' ));

    //监听命令
    \core\Command::listenCommand($argv);

    $server = require( __DIR__ . '/config/server.php' );
    $config = new \core\Agency(new \core\features\Config($server));

    (new \core\servers\SpiderServer($config))->run();
}catch (\Exception $ex){
    \core\Command::displayMsg($ex->getMessage());
}

