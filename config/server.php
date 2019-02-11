<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 19-1-30
 * Time: 上午10:44
 */

return [
    'host' => '127.0.0.1',
    'port' => 9501,
    'setting' => [
        'worker_num' => 4,
//        'task_worker_num' => 8,
        'daemonize' => false, //是否以后台进程运行
        'backlog' => 128,
    ]
];