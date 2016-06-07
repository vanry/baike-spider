<?php

require __DIR__.'/../vendor/autoload.php';

use Vanry\Spider\Spider;

$url = 'http://baike.baidu.com/view/284853.htm';

$spider = new Spider($url);

//设置最大抓取量
$spider->setLimit(10);

//开始抓取..
$spider->crawl();