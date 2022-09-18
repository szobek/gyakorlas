<?php
include_once "load.php";

if(isset($_REQUEST["kw"])){
    $kw = $_REQUEST["kw"];
    

} else {
    die("hibás kulcsszó");
}
$news_class = new News();
$image_class = new Image();
$user_class = new User();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hírek kulcsszó szerint</title>
    <?php include_once "header.php";?>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col text-center">

                <h1>Kulcsszó szerint</h1>
            </div>
        </div>
        <div class="row">
            <div class="col  d-flex justify-content-center news-container p-3">
            <?php
    $news=$news_class->get_news_by_kw($kw);
                foreach ($news as $n) :
                ?>
                    <div class="card">
                        <?php $image_class->seo_image($n->image_url, $n->image_alt); ?>

                        <div class="card-header">
                            <?php //echo mb_strimwidth($n->lead, 0, 60, "...")  ?>
                            <?php echo $n->title  ?>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo mb_strimwidth($n->content, 0, 60, "...")  ?></p>
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
    
</body>
</html>