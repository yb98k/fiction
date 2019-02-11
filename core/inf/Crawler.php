<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 19-1-31
 * Time: 上午10:03
 */

namespace core\inf;


use core\Agency;

abstract class Crawler
{
    protected $queue;

    protected $url;

    protected $scheme;

    protected $host;

    protected $port;

    protected $path;

    protected $domain;

    public function __construct(Agency $config)
    {
        $this->url = $config->get('setting')['url'] ?? '';

        if($this->url) {
            $urlInfo = parse_url($this->url);
            $this->scheme = $urlInfo['scheme'] ?? 'http';
            $this->host = $urlInfo['host'] ?? '';
            $this->port = $this->scheme == 'https' ? 443 : 80;
            $this->path = $urlInfo['path'] ?? '/';

            $this->domain = $this->scheme . '://' . $this->host;

            $this->queue = new \SplQueue();

            $this->queue->setIteratorMode(\SplQueue::IT_MODE_FIFO);
        }
    }

    public function getParam($id)
    {
        return $this->{$id} ?? null;
    }

    abstract public function run();
}