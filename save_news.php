<?php 
require_once "load.php";
include_once "check_logged.php";
include_once "classes/class_image.php";

include_once "classes/class_news.php";
    $n = new News();
if($_REQUEST["title"]===""||$_REQUEST["keywords"]===""||$_REQUEST["image_alt"]===""||$_REQUEST["image_url"]===""||$_REQUEST["content"]===""){
    echo "Üres Mező";
    
}else{
    $image = new Image();
   $uid = $image->upload_image()["uid"];
   //var_dump($uid);
   //die();
    if($_REQUEST["id"]==="-1"){
        //új
$n->save_news_new($uid,$_SESSION);
    } else{
        //módosítás
        /* var_dump($_REQUEST);
        die(); */
$n->modify_news($_REQUEST["id"],$_REQUEST,$uid,$_SESSION);
    }
}