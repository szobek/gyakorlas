<?php
include_once "class_news.php";
include_once "class_image.php";
$id=$_REQUEST["id"];
$n = new News();
$news = $n->get_news_by_id((int)$id);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include_once "header.php"?>
</head>
<body>
<?php include_once "menu.php";

?>
    <h1><?php echo $news->title ?></h1>
    <p><?php echo $news->content ?></p>
    <p>Kulcsszavak: <?php echo $news->k ?></p>
</body>
</html>
