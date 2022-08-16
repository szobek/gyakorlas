<?php


class News
{
    public $all = [];
    function __construct()
    {

        $file = "news.json";
        $text = file_get_contents($file);
        $this->all = json_decode($text);
    }

    function get_news()
    {
        return $this->all;
    }

    function get_news_by_id($id)
    {
        $one = new stdClass;
        if ($id == "-1") {
            $this->set_empty_value();
        }
        foreach ($this->all as $n) {
            if ($n->id == $id) {
                $one = $n;
            }
        }
        if ($one->content === "" || empty($one)) {
            $this->set_empty_value();
        }
        $one->k = $this->explode_keywords($one->keywords);
        return $one;
    }

    function explode_keywords($string)
    {
        $keys = join(" ", explode(" ", $string));
        return $keys;
    }
    function save_news_new()
    {
        $newn = new stdClass;
        $file = "news.json";
        $text = json_decode(file_get_contents($file));
        $newn->id = uniqid();
        $newn->lead = $_REQUEST["lead"];
        $newn->title = $_REQUEST["title"];
        $newn->content = $_REQUEST["content"];
        $newn->image_url = $_REQUEST["id"];
        $newn->image_alt = $_REQUEST["id"];
        $newn->keywords = $_REQUEST["id"];
        print_r($newn);
        die();
        array_push($text, $newn);


        $b =  stripslashes(json_encode($text));
        print_r($b);

        file_put_contents($file, "");
        file_put_contents($file, $b);
    }

    function set_empty_value()
    {
        $one = new stdClass;
        $one->title = "";
        $one->lead = "";
        $one->content = "";
        $one->image_url = "";
        $one->image_alt = "";
        $one->keywords = "";
        $one->id = "";
    }

    function delete_news($id)
    {
        $i = -1;
        $arr=[];
        foreach ($this->all as $item) {
            $i++;
            if ($item->id === $id) {
                unset($this->all[$i]);
            }else{
                array_push($arr,$item);
            }
        }
        file_put_contents("news.json", json_encode($arr));
        header("Location:/");
    }

    function replace_image_string($id)
    {
        $one = $this->get_news_by_id($id);
        $str = '<img src="data:image/';
        $newstring = '';
        //        str_replace($str,$newstring);
    }

    function get_news_index($id)
    {
        $i = 0;

        foreach ($this->all as $n) {
            if ($n->id == $id) {
                break;
            }
            $i++;
        }
        return $i;
    }
    function modify_news($id,$request){
        $index = $this->get_news_index($id);
        $this->all[$index]->title = $request["title"];
        $this->all[$index]->keywords = $request["keywords"];
        $this->all[$index]->image_url = $request["image_url"];
        $this->all[$index]->image_alt = $request["image_alt"];
        $this->all[$index]->content = $request["content"];
        $this->all[$index]->lead = $request["lead"];
        file_put_contents("news.json", "");
        file_put_contents("news.json", json_encode($this->all));
        header("Location:/");
    }
}
