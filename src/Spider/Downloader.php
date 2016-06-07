<?php

namespace Vanry\Spider;

use Curl\Curl;

class Downloader
{
    const USER_AGENT = 'Mozilla/5.0 (Windows NT 5.1; rv:5.0) Gecko/20100101 Firefox/5.0';

    private $client;

    /**
     * 可传入自定义设置后的Curl\Curl实例
     *
     * @param  Curl\Curl  $curl
     * @return void
     */
    public function __construct(Curl $curl = null)
    {
        if (is_null($curl)) {
            $curl = new Curl;
            $curl->setUserAgent(self::USER_AGENT);

            //抓取跳转后的页面
            $curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
        }

        $this->client = $curl;
    }
    
    public function download($url)
    {
        //GET方式发送请求
        $response = $this->client->get($url);

        //过滤不可访问的链接
        if ($this->client->httpStatusCode >= 400) {
            return false;
        }

        return $response;
    }
}
