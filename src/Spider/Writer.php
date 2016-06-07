<?php

namespace Vanry\Spider;

class Writer
{
    private $items = [];
    private $filename;

    public function __construct($filename = 'result.csv')
    {
        $this->filename = $filename;
    }
    
    public function addItem($item)
    {
        $this->items[] = $item;
    }

    public function write()
    {   
        $fp = fopen($this->filename, 'w');
        fputcsv($fp, ['标题', '摘要']);

        foreach ($this->items as $item) {
            echo "正在保存: {$item['title']} \n";
            fputcsv($fp, $item);
        }

        fclose($fp);
    }
}