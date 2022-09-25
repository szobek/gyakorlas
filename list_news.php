<?php
require_once "load.php";
include_once "check_logged.php";
    
    $n = new  News();
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hírek</title>
    <?php include_once "header.php";
    echo $n->head_meta_desc("hírek lista");
    ?>
</head>

<body>
  <?php include_once "menu.php";?>
  <div class="container list-news-container">
    <div class="row">
      <div class="col">
        <ul class="list-group ">
          <?php
    $news = $n->all;
    foreach ($news as $n) :
      ?>
  <li class="list-group-item"><a href="<?php echo "one?id=" . $n->id ?>"><?php echo $n->title?></a> <div class="button-container">
    <a class="btn btn-danger"href="delete_news.php?id=<?php echo $n->id?>"><i class="fa fa-window-close"></i></a>
    <a class="btn btn-success" href="edit?id=<?php echo $n->id?>"><i class="fa fa-pencil"></i></a>
  </div></li>
  <?php
    endforeach;
    ?>
    <li class="list-group-item"><a href="new?id=-1">Új</a></li>
  </ul>
  
</div>
</div>
</div>
    <?php include "footer.php"; ?>