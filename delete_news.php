<?php

include_once "class_news.php";
$n = new  News();
$n->delete_news($_REQUEST["id"]);
