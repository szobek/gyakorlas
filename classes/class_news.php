<?php


class News
{
    public $all = [];
    public $sliced = [];
    function __construct()
    {

        $file = "assets/jsons/news.json";
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
        if ($id === -1 || $id === "-1") {
            $one =  $this->set_empty_value();
        }
        foreach ($this->all as $n) {
            if ($n->id == $id) {
                $one = $n;
            }
        }

        if (isset($one->keywords)) {

            $one->k = $this->explode_keywords_to_strings($one->keywords);
            
        }

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
    function save_news_new($uid, $session)
    {
        $newn = new stdClass;
        $file = "assets/jsons/news.json";
        $text = json_decode(file_get_contents($file));
        $newn->id = uniqid();
        $newn->lead = $_REQUEST["lead"];
        $newn->title = $_REQUEST["title"];
        $newn->content = $this->remove_string_end($_REQUEST["content"]);
        $newn->image_url = $uid . $_REQUEST["image_url"];
        $newn->image_alt = $_REQUEST["image_alt"];
        $newn->keywords = $_REQUEST["keywords"];
        $newn->author = $session["user"]->id;
        array_push($text, $newn);


        $b =  stripslashes(json_encode($text, JSON_UNESCAPED_UNICODE));
        $this->convert_and_put($b, false);
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
        $one->author = "";
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
        $this->convert_and_put($arr);
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
    function modify_news($id, $request, $uid, $session)
    {
        $uid = ($request["id"] !== "-1") ? $uid : "";
        $index = $this->get_news_index($id);
        $this->all[$index]->title = $request["title"];
        $this->all[$index]->keywords = $request["keywords"];
        $this->all[$index]->image_url = $uid . $request["image_url"];
        $this->all[$index]->image_alt = $request["image_alt"];
        $this->all[$index]->content = $this->remove_string_end($request["content"]);
        $this->all[$index]->lead = $request["lead"];
        $this->all[$index]->author = $session["user"]->id;
        //var_dump($uid,$request["id"]);
        //die();
        $this->convert_and_put($this->all);
        header("Location:/");
    }

    function remove_string_end($string)
    {
        return substr($string, 0, -2);
    }

    function convert_new_line($string)
    {
        return str_replace("\r\n", "<br>", $string);
    }
    function head_meta_desc($desc = "")
    {
        return '<meta name="description" content="' . mb_strimwidth($desc, 0, 160, "...") . '">';
    }
    function head_meta_title($title = "")
    {
        return '<meta name="title" content="' . $title . '">';
    }

    function convert_and_put($json_string, $je = true)
    {
        if ($je) {
            $text = json_encode($json_string);
        } else {
            $text = $json_string;
        }
        file_put_contents("assets/jsons/news.json", "");
        file_put_contents("assets/jsons/news.json", $text);
    }

    function get_news_by_author($author)
    {
        $arr = [];
        foreach ($this->all as $item) {
            if ($item->author === $author) {
                array_push($arr, $item);
            }
        }
        return $arr;
    }

    function show_pagination($a)
    {
        if (intval($a) < 1) {
            die("Hibás oldalszám");
        }
        //$news_num = count($this->sliced);
        $a = (int)$a;
        $i = 1;
        $this->sliced = $this->show_sliced_news();
        //var_dump($a);
        //die();
        $prev = ($a <= 1) ? '' : '<li class="page-item"><a class="page-link" href="?p=' . ($a - 1) . '">Előző</a></li>';
        $next = (count($this->sliced) === $a) ? "" : '<li class="page-item"><a class="page-link" href="?p=' . ($a + 1) . '">Következő</a></li>';
        echo '<ul class="pagination">' . $prev;


        foreach ($this->sliced as $link) {
            $active = ($i === (int)$a) ? ' active' : '';
            echo '<li class="page-item ' . $active . '">
<a class="page-link" href="?p=' . $i . '">' . $i . '</a>
</li>';
            $i++;
        }
        echo $next . '</ul>';
    }
    function show_sliced_news($page = 0, $perpage = 5)
    {

        if(!$this->check_page($page)){
            die("Hibás oldal");
        } else {
            $page = intval($page);
        }
        $from = ($page * $perpage) - $perpage;
        $sliced = array_slice($this->all, $from, $perpage);
        $this->sliced = $sliced;
        return $sliced;
    }

    function check_page($page)
    {
        $valid = false;
        
        if (!preg_match("/[0-9]/",$page) ) {
            $page = intval($page);
        } else {
            $valid = true;
        }
        return $valid;
    }

    function explode_keywords_to_strings($kw){
        if (strpos($kw, ' ') !== false) {
            $keys =  explode(" ", $kw);
        } else {
            $keys = $kw;
        }
        
        return $keys;
    }
}
