<?php
include_once "load.php";
include_once "check_logged.php";
$n = new  News();
if(isset($_REQUEST["id"])){
    $n->delete_news($_REQUEST["id"]);

} else {
    die("hibás id");
}