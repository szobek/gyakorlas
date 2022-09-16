<?php


class News
{
    public $all;
    public $sliced = [];
    public $perpage;
    function __construct()
    {

        $file = "assets/jsons/news.json";
        $text = file_get_contents($file);
        $this->all = (!empty($text)) ? json_decode($text) : [];
        $this->perpage = 10;
    }


    public function get_news_by_id(string $id): stdClass
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


    public function save_news_new(string $uid,  $session): void
    {
        $newn = new stdClass;
        $file = "assets/jsons/news.json";
        $text = json_decode(file_get_contents($file));
        $newn->id = uniqid();
        $newn->lead = $this->secure_string($_REQUEST["lead"]);
        $newn->title = $this->secure_string($_REQUEST["title"]);
        $newn->content = $this->explode_and_convert_string($_REQUEST["content"]);
        $newn->image_url = $uid . $this->secure_string($_REQUEST["image_url"]);
        $newn->image_alt = $this->secure_string($_REQUEST["image_alt"]);
        $newn->keywords = $this->secure_string($_REQUEST["keywords"]);
        $newn->author = $session["user"]->id;
        array_push($text, $newn);
        // var_dump($m);die();


        $b =  stripslashes(json_encode($text, JSON_UNESCAPED_UNICODE));
        $this->convert_and_put($b, false, $newn);
        header("Location:/");
    }

    protected function explode_and_convert_string(string $string): string
    {

        $mirol = ['&quot;', '"', "rnrn", "rn"];
        $mire = ["'", "'", "", ""];
        $string = str_replace($mirol, $mire, $string);
        //        var_dump($string);die(); 
        return htmlspecialchars(strip_tags($string), ENT_QUOTES, 'UTF-8');
    }

    protected function set_empty_value(): stdClass
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

    public function delete_news(string $id): void
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


    protected function get_news_index(string $id): string
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
    public function modify_news(string $id, array $request, int $uid, array $session): void
    {
        $uid = ($request["id"] !== "-1") ? $uid : "";
        $index = $this->get_news_index($id);
        $this->all[$index]->title = $this->secure_string($request["title"]) ;
        $this->all[$index]->keywords = trim($request["keywords"]);
        if ($request["modify-image"] === "on") {

            $this->all[$index]->image_url = $uid . $this->secure_string($request["image_url"]);
        }
        $this->all[$index]->image_alt = $this->secure_string($request["image_alt"]);
        $this->all[$index]->content = $this->explode_and_convert_string($_REQUEST["content"]);
        $this->all[$index]->lead = $this->secure_string($request["lead"]);
        $this->all[$index]->author = $session["user"]->id;

        $this->convert_and_put($this->all);
        header("Location:/");
    }

    public function convert_new_line(string $string): string
    {

        $str = str_replace("rn", "", $string);
        $str = str_replace("\r\n", "<br>", $string);

        return $str;
    }
    public function head_meta_desc(string $desc = ""): string
    {
        return '<meta name="description" content="' . mb_strimwidth($desc, 0, 160, "...") . '">';
    }
    public function head_meta_title(string $title = ""): string
    {
        return '<meta name="title" content="' . $title . '">';
    }

    protected function convert_and_put($json_string, bool $je = true, $newn = null): void
    {
        $text = ($je) ? json_encode($json_string) : $text = $json_string;

        file_put_contents("assets/jsons/news.json", "");
        file_put_contents("assets/jsons/news.json", $text);
        if (property_exists($newn, "id")) {

            $this->send_email_about_news($newn);
        }
    }

    public function get_news_by_author(string $author): array
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
    public function show_pagination(string $pagenum = "1"): void
    {
        /* var_dump($pagenum);
        die();
  */
        if (intval($pagenum) < 1) {
            die("Hibás oldalszám");
        }
        //$news_num = count($this->sliced);
        $pagenum = (int)$pagenum;
        if (!is_array($this->all)) {
            $this->all = [];
        }
        $this->sliced = $this->show_sliced_news();
        $allpage = count($this->all) / $this->perpage;
        $last = ($allpage<16.5)?round($allpage):round($allpage)+1;
        if($pagenum>$last){
            die("Hibás oldal");
        }
        $prev = ($pagenum <= 1) ? '' : '<li class="page-item"><a class="page-link" href="?page=' . ($pagenum - 1) . '">Előző</a></li>';
        $next = ($allpage > $pagenum) ? '<li class="page-item"><a class="page-link" href="?page=' . ($pagenum + 1) . '">Következő</a></li>' : '';
        echo '<ul class="pagination lll">' . $prev;
        
        
        if($this->all>9){
            echo ($pagenum > 1) ? '<li class="page-item "><a class="page-link" href="?page=1">Első</a></li>' : '';
            echo ($pagenum - 2 > 1) ? '<li class="page-item "><sub>...</sub></li>' : '';
            echo ($pagenum - 2 >= 1) ? '<li class="page-item "><a class="page-link" href="?page=' . ($pagenum - 2) . '">' . ($pagenum - 2) . '</a></li>' : '';
            echo ($pagenum - 1 >= 1) ? '<li class="page-item "><a class="page-link" href="?page=' . ($pagenum - 1) . '">' . ($pagenum - 1) . '</a></li>' : '';
            echo '<li class="page-item active"><a class="page-link" href="?page=' . ($pagenum) . '">' . ($pagenum) . '</a></li>';
            echo ($pagenum < $allpage ) ? '<li class="page-item "><a class="page-link" href="?page=' . ($pagenum + 1) . '">' . ($pagenum + 1) . '</a></li>' : '';
            //var_dump($last,$last);die();
            echo ($pagenum+2 < round($allpage, 0, PHP_ROUND_HALF_UP)+1 ) ? '<li class="page-item "><a class="page-link" href="?page=' . ($pagenum + 2) . '">' . ($pagenum + 2) . '</a></li>' : '';
            //var_dump($pagenum+2,round($allpage, 0, PHP_ROUND_HALF_UP));die();
            
     
            echo ($pagenum + 3 < round($allpage, 0, PHP_ROUND_HALF_UP)+1 ) ? '<li class="page-item "><sub>...</sub></li>' : '';
            echo ($pagenum < $last) ? '<li class="page-item "><a class="page-link" href="?page=' . $last  . '">Utolsó</a></li>' : '';


            echo $next . '</ul>';
        }

        
    }
    function show_sliced_news(int $page = 0): array
    {
        $from = [];

        if (!$this->check_page($page)) {
            die("Hibás oldal");
        } else {
            $page = intval($page);
        }
        $from = ($page * $this->perpage) - $this->perpage;
        if (is_array($this->all)) {
            $sliced = array_slice($this->all, $from, $this->perpage);
            $this->sliced = $sliced; //5öt kivág
        } else {

            $sliced = [];
            $this->sliced = [];
        }
        /*        var_dump($sliced);
        die(); */
        return $this->sliced;
    }

    protected function check_page(string $page): bool
    {
        $valid = false;

        if (!preg_match("/[0-9]/", $page)) {
            $page = intval($page);
        } else {
            $valid = true;
        }
        return $valid;
    }

    protected function explode_keywords_to_strings(string $kw): array
    {
        $keys = [];
        if (strpos($kw, ' ') !== false) {
            $keys =  explode(" ", $kw);
        } else {
            array_push($keys, $kw);
        }

        return $keys;
    }

    public function get_news_by_kw(string $keyword): array
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

    protected function send_email_about_news(stdClass $newn): void
    {
        $to = "kunszt.norbert2@gmail.com";
        $subject = "Új  hír";
        $txt = "Látogasd meg az oldalt\r\nLink:<a href='http://mgy.gg/one_news.php?id=$newn->id ' target='_blank'>Link</a>";
        mail($to, $subject, $txt, "");

    }

    protected function secure_string(string $string): string
    {
        return htmlspecialchars(strip_tags($string), ENT_QUOTES, 'UTF-8');;
    }
}
