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
        //var_dump($id);
        $one = new stdClass;
        if ($id === -1) {
            $one =  $this->set_empty_value();
        }
        //var_dump($one);
        //die();
        foreach ($this->all as $n) {
            if ($n->id == $id) {
                $one = $n;
            }
        }
        if ($one->content === "" || empty($one)) {
            $one = $this->set_empty_value();
        }
        $one->k = $this->explode_keywords($one->keywords);
        return $one;
    }

    function explode_keywords($string)
    {

        if (strpos($string, ' ') !== false) {
            $keys = join(" ", explode(" ", $string));
        } else {
            $keys = $string;
        }
        return $keys;
    }
    function save_news_new($uid)
    {
        $newn = new stdClass;
        $file = "news.json";
        $text = json_decode(file_get_contents($file));
        $newn->id = uniqid();
        $newn->lead = $_REQUEST["lead"];
        $newn->title = $_REQUEST["title"];
        $newn->content = $_REQUEST["content"];
        $newn->image_url = $uid.$_REQUEST["image_url"];
        $newn->image_alt = $_REQUEST["image_alt"];
        $newn->keywords = $_REQUEST["keywords"];
        // print_r($newn);
        //die();
        array_push($text, $newn);


        $b =  stripslashes(json_encode($text));
        //print_r($b);

        file_put_contents($file, "");
        file_put_contents($file, $b);
        header("Location:/");
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
        return $one;
    }

    function delete_news($id)
    {
        $i = -1;
        $arr = [];
        foreach ($this->all as $item) {
            $i++;
            if ($item->id === $id) {
                unset($this->all[$i]);
            } else {
                array_push($arr, $item);
            }
        }
        file_put_contents("news.json", json_encode($arr));
        header("Location:/");
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
    function modify_news($id, $request,$uid)
    {
        $index = $this->get_news_index($id);
        $this->all[$index]->title = $request["title"];
        $this->all[$index]->keywords = $request["keywords"];
        $this->all[$index]->image_url = $uid.$request["image_url"];
        $this->all[$index]->image_alt = $request["image_alt"];
        $this->all[$index]->content = $this->remove_string_end($request["content"]);
        $this->all[$index]->lead = $request["lead"];
        file_put_contents("news.json", "");
        file_put_contents("news.json", json_encode($this->all));
        header("Location:/");
    }

    function remove_string_end($string){
        return substr($string,0,-2);

    }

    function convert_new_line($string){
        return str_replace("\r\n","<br>",$string);
    }
}
