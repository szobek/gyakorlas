<?php 
include_once "class_image.php";

include_once "class_news.php";
    $n = new News();
if($_REQUEST["title"]===""||$_REQUEST["keywords"]===""||$_REQUEST["image_alt"]===""||$_REQUEST["image_url"]===""||$_REQUEST["content"]===""){
    echo "Üres Mező";
    
}else{
    $image = new Image();
   $uid = $image->upload_image()["uid"];
    if($_REQUEST["id"]==="-1"){
        //új
$n->save_news_new($uid);
    } else{
        //módosítás
$n->modify_news($_REQUEST["id"],$_REQUEST,$uid);
    }
}