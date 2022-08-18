<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hírek</title>
   <?php include_once "header.php"?>
</head>

<body>
    <ul class="list-group">
    <?php
    include_once "class_news.php";
    include_once "menu.php";
    $n = new  News();
    $news = $n->get_news();
    foreach ($news as $n) :
    ?>
  <li class="list-group-item"><a href="<?php echo "one_news.php?id=" . $n->id ?>"><?php echo $n->title?></a> <div class="button-container">
    <a class="btn btn-danger"href="delete_news.php?id=<?php echo $n->id?>">x</a>
    <a class="btn btn-success" href="edit_news.php?id=<?php echo $n->id?>">modify</a>
  </div></li>
  <?php
    endforeach;
    ?>
    <li class="list-group-item"><a href="edit_news.php?id=-1">Új</a></li>
    </ul>
    <?php include "footer.php"; ?>