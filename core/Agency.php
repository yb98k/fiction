<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 19-1-30
 * Time: 上午11:51
 */

namespace core;


use core\inf\DIInf;

class Agency
{
    protected $obj;

    public function __construct(DIInf $obj)
    {
        $this->obj = $obj;
    }

    public function get($id)
    {
        return $this->obj->get($id);
    }
}