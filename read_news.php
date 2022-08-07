<?php

class News
{
    public $all = [];
    function __construct()
    {

        $file = "news.json";
        $news = fopen($file, "r");
        $text = "";
        while ($row = fgets($news)) {
            $text .= $row;
        }
        $this->all = json_decode($text);
        fclose($news);
    }

    function get_news()
    {
        return $this->all;
    }

    function get_news_by_id($id)
    {
        $one = new stdClass;
        foreach ($this->all as $n) {
            if ($n->id === $id) {
                $one = $n;
            } else{
                $one->title="";
                $one->content="";
                $one->image_url="";
                $one->image_alt="";
                $one->keywords="";
            }
        }
        $one->k = $this->explode_keywords($one->keywords);
        return $one;
    }

    function explode_keywords($string)
    {
        $keys = join(" ", explode(" ", $string));
        return $keys;
    }
    function save_news(){

    }
}
