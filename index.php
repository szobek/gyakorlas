<?php
    $pages = [
        ""=>"news.php",
        "/"=>"news.php",
        "author"=>"author-profile.php",
        "one"=>"one_news.php",
        "list"=>"list_news.php",
        "login"=>"login.php",
        "logout"=>"logout.php",
        "news_by_keyword"=>"news_by_keyword.php",
        "save"=>"save_news.php",
        "me"=>"user-profile.php",
        "save"=>"save_news.php",
        "edit"=>"edit_news.php",
        "save"=>"save_news.php",
        "new"=>"edit_news.php",
        "list_image"=>"list_image.php",
        "image_up"=>"media.php",
    ];

    function checkUri($uri){
        global $pages;

        foreach ($pages as $item=>$file) {
            if($item===$uri){
                return true;
            }
        }
        return false;

    }
    

    $request = explode("?",$_SERVER['REQUEST_URI'])[0];
    $request = substr($request,1);
   
    if(!checkUri($request)){
        require_once "404.php";die();
    }
foreach ($pages as $uri => $file) {
    if($request === $uri && file_exists($file) && is_readable($file)){
        require_once $file;
    }
}
