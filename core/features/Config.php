<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 19-1-30
 * Time: 上午11:42
 */

namespace core\features;


use core\inf\DIInf;

class Config implements DIInf
{

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function get($id)
    {
        return $this->config[$id] ?? null;
    }
}