<?php

namespace Vanry\Spider;

use DiDom\Document;

class Parser
{
    private $dom;
    
    public function __construct()
    {
        $this->dom = new Document;
    }

    public function parse($html)
    {
        $this->dom->load($html);

        $urls = $this->extractLinks();
        $item = $this->getItem();

        return compact('urls', 'item');
    }

    public function extractLinks()
    {
        $urls = [];
        $nodes = $this->dom->find('div.main-content a');

        foreach ($nodes as $node) {
            //只保留包含viewurl, 忽略锁定词条
            if (strpos($node->href, 'view/') !== false && $node->title != '锁定') {
                $urls[] = 'http://baike.baidu.com'.$node->href;
            }
        }

        return array_unique($urls);
    }

    public function getItem()
    {
        $title = $this->getTitle();
        $intro = $this->getIntro();

        return compact('title', 'intro');
    }

    private function getTitle()
    {
        return $this->dom->find('dd.lemmaWgt-lemmaTitle-title h1')[0]->text();
    }

    private function getIntro()
    {
        $intro = $this->dom->find('div.lemma-summary')[0]->text();

        return trim($intro);
    }
}