<?php

include_once "load.php";
include_once "classes/class_news.php";
include_once "classes/class_image.php";
$news_class = new  News();
$image = new Image();
$page = (isset($_REQUEST["page"])) ? $_REQUEST["page"] : 1;
/* var_dump($page);
die(); */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hírek</title>
    <?php include_once "header.php";
    echo $news_class->head_meta_desc("hírek");
    ?>
</head>

<body>
    <?php include_once "menu.php"; ?>
    <div class="container">
        <div class="row">
            <div class="col text-center">

                <h1>Főoldal</h1>
            </div>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-center news-container p-3">
                <?php
                $news = $news_class->show_sliced_news($page);
                foreach ($news as $n) :
                ?>
                    <div class="card">
                        <?php $image->seo_image($n->image_url, $n->image_alt); ?>

                        <div class="card-header">
                            <?php echo mb_strimwidth($n->lead, 0, 60, "...")  ?>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo mb_strimwidth($n->content, 0, 160, "...")  ?></p>
                        </div>
                        <div class="card-footer text-center">

                            <a class="btn my-btn " href="<?php echo "one_news.php?id=" . $n->id ?>">Tovább</a>
                        </div>
                    </div>
                <?php
                endforeach;

                ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col mt-4 paginator">
                <?php
                $news_class->show_pagination($page);
                ?>
                <div class="up">
                <i class="fa fa-arrow-up" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
    <?php

    include "footer.php"; ?>