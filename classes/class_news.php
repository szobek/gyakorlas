<?php


class News
{
    public $all = [];
    public $sliced = [];
    public $perpage = 10;
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

    function set_empty_value(): stdClass
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
    /*
param $a actual page num
*/
    function show_pagination(string $a)
    {
        if (intval($a) < 1) {
            die("Hibás oldalszám");
        }
        //$news_num = count($this->sliced);
        $a = (int)$a;
        $this->sliced = $this->show_sliced_news();
        $allpage = count($this->all) / $this->perpage;
       /*  var_dump($allpage);
        die(); */
        $prev = ($a <= 1) ? '' : '<li class="page-item"><a class="page-link" href="?p=' . ($a - 1) . '">Előző</a></li>';
        $next = ($allpage > $a) ? '<li class="page-item"><a class="page-link" href="?p=' . ($a + 1) . '">Következő</a></li>' : '' ;
        echo '<ul class="pagination">' . $prev;

/*          var_dump($a===1);
        die();
 */             echo ($a>1)? '<li class="page-item "><a class="page-link" href="?p=1">Első</a></li>':'';
            echo ($a-2>1)?'<li class="page-item ">...</li>':'';
            echo ($a-2>=1)?'<li class="page-item "><a class="page-link" href="?p=' . ($a-2) . '">' . ($a-2) . '</a></li>':'';
            echo ($a-1>=1 )?'<li class="page-item "><a class="page-link" href="?p=' . ($a-1) . '">' . ($a-1) . '</a></li>':'';
            echo '<li class="page-item active"><a class="page-link" href="?p=' . ($a) . '">' . ($a) . '</a></li>';
            echo ($a<round($allpage)+1)?'<li class="page-item "><a class="page-link" href="?p=' . ($a+1) . '">' . ($a+1) . '</a></li>':'';
            echo ($a<round($allpage)+1)?'<li class="page-item "><a class="page-link" href="?p=' . ($a+2) . '">' . ($a+2) . '</a></li>':'';
            echo ($a+2<round($allpage)+1)?'<li class="page-item ">...</li>':'';
            echo ($a < (round($allpage)+1))? '<li class="page-item "><a class="page-link" href="?p=' . (round($allpage)+1) . '">Utolsó</a></li>':'';
       

        echo $next . '</ul>';
    }
    function show_sliced_news($page = 0)
    {

        if (!$this->check_page($page)) {
            die("Hibás oldal");
        } else {
            $page = intval($page);
        }
        $from = ($page * $this->perpage) - $this->perpage;
        $sliced = array_slice($this->all, $from, $this->perpage);
        $this->sliced = $sliced; //5öt kivág
        /*        var_dump($sliced);
        die(); */
        return $sliced;
    }

    function check_page($page)
    {
        $valid = false;

        if (!preg_match("/[0-9]/", $page)) {
            $page = intval($page);
        } else {
            $valid = true;
        }
        return $valid;
    }

    function explode_keywords_to_strings($kw)
    {
        $keys = [];
        if (strpos($kw, ' ') !== false) {
            $keys =  explode(" ", $kw);
        } else {
            array_push($keys, $kw);
        }

        return $keys;
    }

    function get_news_by_kw($keyword): array
    {
        $arr = [];

        foreach ($this->all as $item) {
            $keywords = $this->explode_keywords_to_strings($item->keywords);
            //  var_dump($keywords);
            //die();
            if (is_numeric(array_search($keyword, $keywords))) {
                array_push($arr, $item);
            }
        }
        //      var_dump($arr);
        //die();

        return $arr;
    }
}
