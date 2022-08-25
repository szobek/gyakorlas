<?php
include_once "check_logged.php";
include_once "class_news.php";
$n = new  News();
$n->delete_news($_REQUEST["id"]);
