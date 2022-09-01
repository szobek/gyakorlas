<?php
include_once "check_logged.php";
include_once "classes/class_news.php";
$n = new  News();
if(isset($_REQUEST["id"])){
    $n->delete_news($_REQUEST["id"]);

} else {
    die("hibás id");
}