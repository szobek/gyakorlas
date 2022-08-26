<?php
session_start();
include_once "classes/class_news.php";
include_once "classes/class_image.php";
include_once "classes/class_user.php";
$id = $_REQUEST["id"];
$n = new News();
$news = $n->get_news_by_id($id);
$i = new Image();
$user_class = new User();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $news->title ?></title>
    <?php include_once "header.php" ?>
    <meta name="keywords" content="<?php echo $news->k ?>">
    <?php echo $n->head_meta_desc($news->lead);  ?>
    <?php echo $n->head_meta_title($news->title);  ?>
</head>

<body>
    <?php include_once "menu.php";

    ?>
    <div class="container">
        <div class="row">
            <div class="col one-news-container">
                <div class="text-center">
                    <p><?php $i->seo_image($news->image_url, $news->image_alt);
                     ?></p>
                    <p><small><i><?php echo $news->image_alt;?></i></small></p>
                    
                </div>
                <div class="news-content-wrapper">
<p class="news-lead"><strong><?php echo $n->convert_new_line($news->lead); ?></strong></p>
                    <p><?php echo $news->content ?></p>
                    <p><small>Szerző: <?php 
                    $user = $user_class->getUserById($news->author);
                    echo $user->firstName . " ".$user->lastName;
                    ?></small></p>
                    <p class="kw">Kulcszavak: <?php echo $news->k ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>