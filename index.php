<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hírek</title>
    <?php include_once "header.php" ?>
</head>

<body>
    <?php include_once "menu.php"; ?>
    <div class="container">
        <div class="row">
            <div class="col d-flex news-container p-3" style="gap: 20px;flex-wrap:wrap">

                <?php
                include_once "class_news.php";
                include_once "class_image.php";
                $n = new  News();
                $news = $n->get_news();
                $image = new Image();
                foreach ($news as $n) :
                ?>
                    <div class="card" style="width: 20rem;">
                        <?php $image->seo_image($n->image_url, $n->image_alt); ?>

                        <div class="card-header">
                            <?php echo $n->title ?>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo $n->lead ?></p>
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
<?php include "footer.php"; ?>