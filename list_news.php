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
    <?php
    include_once "read_news.php";
    include_once "menu.php";
    $n = new  News();
    $news = $n->get_news();
    foreach ($news as $n) :
    ?>
        <ul class="list-group">
  <li class="list-group-item"><a href="edit_news.php"><?php echo $n->title?></a></li>
</ul>
    <?php
    endforeach;
    ?>
</body>

</html>