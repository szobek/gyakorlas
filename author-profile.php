<?php
session_start();
include_once "classes/class_news.php";
include_once "classes/class_image.php";
include_once "classes/class_user.php";
$id = $_REQUEST["id"];
$news_class = new News();
$image_class = new Image();
$user_class = new User();
if(!isset($_REQUEST["id"])){
    die("Hibás id");
}else{

    $id=$_REQUEST["id"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include_once "header.php";    ?>
</head>
<body>
<?php include_once "menu.php"; ?>
    <div class="container">
        <div class="row">
            <div class="col  author-container">
                <div class="author-data">
                <p>Név: <?php 
                    $user = $user_class->getUserById($id);
                    
                    if(empty($user)){
                        echo "Nem találtam ilyen szerzőt!";
                        die();
                    }
                    echo $user->firstName . " ".$user->lastName;
                    ?></p>
                <p>E-mail: <?php echo $user->email; ?></p>
                </div>
                
                <h1 class="text-center">Cikkek: </h1>
                <div class="d-flex p-2 authors-news-container">

                    <?php
                $news = $news_class->get_news_by_author($user->id);
                foreach ($news as $n) :
                ?>
                    <div class="card" >
                        <?php $image_class->seo_image($n->image_url, $n->image_alt); ?>

                        <div class="card-header">
                            <?php echo mb_strimwidth($n->lead,0,60,"...")  ?>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo mb_strimwidth($n->content,0,60,"...")  ?></p>
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
    </div>

    <?php include_once "footer.php";    ?>