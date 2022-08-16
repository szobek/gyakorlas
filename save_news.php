<?php 

include_once "class_news.php";
    $n = new News();
if($_REQUEST["title"]===""||$_REQUEST["keywords"]===""||$_REQUEST["image_alt"]===""||$_REQUEST["image_url"]===""||$_REQUEST["content"]===""){
    echo "Üres Mező";
    
}else{

    if($_REQUEST["id"]==="-1"){
        //új
$n->save_news_new();
    } else{
        //módosítás
$n->modify_news($_REQUEST["id"],$_REQUEST);
    }
}