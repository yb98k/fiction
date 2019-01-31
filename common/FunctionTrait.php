<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 19-1-31
 * Time: 上午8:26
 */

namespace common;

use core\Command;
use voku\helper\HtmlDomParser;

trait FunctionTrait
{
    public static function replaceRules(&$content)
    {
        $content = strip_tags($content);
//        $content = str_replace('&#13;', '\n', $content);
    }

    public static function downloadFile($fileUrl)
    {
        $filename= pathinfo($fileUrl)['filename'] . '.txt';
        $localPath = __DIR__ . '/resources/' . $filename;

        $handle = fopen($fileUrl, 'rb');
        do {
            $data = fread($handle, 8192);
            if (strlen($data) == 0){
                break;
            }
            file_put_contents($localPath, $data, FILE_APPEND);
        } while(true);

        fclose ($handle);

        Command::displayMsg('DOWNLOAD OK', 'yellow');
    }

    public static function getHtmlObj($url, $isGzip = false)
    {
        if($isGzip) {
            return (new HtmlDomParser())->loadHtml(file_get_contents('compress.zlib://' . $url));
        } else {
            return HtmlDomParser::file_get_html($url);
        }
    }
}