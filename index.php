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
    $n = new  News();
    $news = $n->get_news();
    foreach ($news as $n) :
    ?>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="<?php echo $n->image_url?>" alt="<?php echo $n->image_alt?>">
            <div class="card-body">
                <p class="card-text"><?php echo $n->title?></p>
            </div>
            <div class="card-footer">

                <a class="btn btn-success" href="<?php echo "one_news.php?id=" . $n->id ?>">Tovább</a>
            </div>
        </div>
    <?php
    endforeach;
    ?>
</body>

</html>