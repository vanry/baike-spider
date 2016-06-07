<?php

namespace Vanry\Spider;

class Spider
{
    private $seed;
    private $limit = 0;

    private $urlManager;
    private $downloader;
    private $parser;
    private $writer;

    public function __construct($seed)
    {   
        $this->seed = $seed;

        $this->urlManager = new UrlManager;
        $this->downloader = new Downloader;
        $this->parser = new Parser;
        $this->writer = new Writer;
    }

    /**
     * 设置最大抓取量
     *
     * @param  string  $limit
     * @return void
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    public function crawl()
    {
        //将种子url加入待抓取队列
        $this->urlManager->addUrl($this->seed);

        //取出待抓取的url开始抓取
        $count = 0;
        while ($url = $this->urlManager->next()) {
            if ($this->limit != 0 && $count >= $this->limit) {
                echo "抓取数量已达到设定值 \n";
                break;
            }

            echo "正在抓取: $url \n";
            $html = $this->downloader->download($url);

            //抓取过的url加入已抓取集合
            $this->urlManager->addVisted($url);
            $count++;

            //失败则跳过
            if (! $html) {
                continue;
            }

            //解析出新的链接和标题、简介
            $data = $this->parser->parse($html);
            extract($data);

            $this->urlManager->addUrls($urls);
            $this->writer->addItem($item);
            
            //避免触发反爬虫机制，延时1~3秒
            sleep(mt_rand(1, 3));
        }

        //保存到csv文件
        $this->writer->write();
    }
}
