<?php
include_once "class_news.php";
include_once "class_image.php";
$id = $_REQUEST["id"];
$n = new News();
$news = $n->get_news_by_id((int)$id);
$i = new Image();

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
    <meta name="description" content="<?php echo $news->lead ?>">
</head>

<body>
    <?php include_once "menu.php";

    ?>
    <div class="container">
        <div class="row">
            <div class="col one-news-container">
                <div class="text-center">
                    <?php $i->seo_image($news->image_url, $news->image_alt); ?>
                </div>
                <div class="news-content-wrapper">

                    <p><?php echo $news->content ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>