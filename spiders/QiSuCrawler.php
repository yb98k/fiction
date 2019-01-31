<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 19-1-31
 * Time: 上午10:02
 */

namespace spider;


use common\FunctionTrait;
use core\Agency;
use core\inf\Crawler;
use voku\helper\HtmlDomParser;

class QiSuCrawler extends Crawler
{

    use FunctionTrait;

    public function __construct(Agency $config)
    {
        parent::__construct($config);
    }

    public function getParam($id)
    {
        return parent::getParam($id);
    }

    public function run()
    {
        $html = self::getHtmlObj($this->url, true);

        $allHref = $html->find('a')->href ?? [];

        $this->getFiles($allHref, $this->url);
    }

    public function getFiles($allHref, $originUrl)
    {
        foreach ($allHref as $url) {
            if($url == '/') continue;
            if($url == $originUrl) continue;
            var_dump($url);
            $url = strpos($url, '://') === false ? $this->domain . $url : $url;
            if(strpos($url, '.txt') !== false) {
                $this->queue->enqueue($url);

                while($this->queue->count() >= 10) {

                    do{
                        $fileUrl = $this->queue->dequeue();
//                        self::downloadFile($fileUrl);
                        var_dump('下载链接：' . $fileUrl);
                    }while($this->queue->count() > 0);
                }
            } else {
                $html = self::getHtmlObj($url, true);
                if(is_array($html->find('a')->href)) {
                    $this->getFiles($html->find('a')->href, $url);
                }
            }
        }
    }
}