<?php
include_once "load.php";

if(isset($_REQUEST["id"])){
    $id = $_REQUEST["id"];
    
    
} else {
    die("hibás id");
}
$n = new News();
$news = $n->get_news_by_id($id);


if(!isset($news->content)){
    echo "Nem találtam ilyen hírt!";
    die();
}
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
                    <p><?php echo $n->convert_new_line($news->content);  ?></p>
                    <hr>
                    <p><small>Szerző: <a href="author?id=<?php echo $news->author; ?>"> <?php 
                    $usera = $user_class->author;
                    //var_dump($user_class);die();

                    if(property_exists($usera,"firstName") && 
                    property_exists($usera,"lastName")){

                        echo $usera->firstName . " ".$usera->lastName;
                    }
                    ?></a></small></p>
                    <hr>
                    <div>Kulcszavak: <?php 
                     foreach($news->k as $keyword){
                        echo '<div class="kw"><a href="news_by_keyword?kw='.$keyword.'">'.$keyword . " </a></div>";
                     }
                     ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>