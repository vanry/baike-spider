<?php

namespace Vanry\Spider;

class UrlManager
{
    private $queue = [];
    private $visited = [];
    
    public function addUrl($url)
    {
        //每个url只抓取一遍
        if (! in_array($url, $this->queue) && ! in_array($url, $this->visited)) {
            array_push($this->queue, $url);
        }
    }

    public function addUrls($urls)
    {
        foreach ($urls as $url) {
            $this->addUrl($url);
        }
    }

    public function next()
    {
        return array_shift($this->queue);
    }

    public function addVisted($url)
    {
        array_push($this->visited, $url);
    }
}