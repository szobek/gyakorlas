<?php
include_once "class_news.php";
include_once "class_image.php";
include_once "menu.php";
$n = new  News();
$id = $_REQUEST["id"];

$news = $n->get_news_by_id((int)$id);

$c = ($news->content === "") ? "" : $news->content;
$t = ($news->title === "") ? "" : $news->title;
$i = ($news->image_url === "") ? "" : $news->image_url;
$k = ($news->keywords === "") ? "" : $news->keywords;
$ia = ($news->image_alt === "") ? "" : $news->image_alt;
$id = ($news->id === "") ? "-1" : $news->id;
$l = ($news->lead === "") ? "" : $news->lead;
$img_class = new Image();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $t ?></title>
    <?php include_once "header.php" ?>
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col">
                <form action="save_news.php" method="post" class="news-form"  enctype="multipart/form-data">

                    <label for="title">title</label>
                    <div class="input-group mb-3">
                        <input type="text" id="title" value="<?php echo $t ?>" class="form-control" placeholder="title" name="title">
                    </div>

                    <label for="lead">lead</label>
                    <div class="input-group mb-3">
                        <textarea name="lead" id="lead" class="form-control"><?php echo $l ?></textarea>
                    </div>
<div id="img-view">
<?php $img_class->seo_image($i); ?>
<button class="btn my-btn" id="modify-btn">Módosít</button>
</div>
                    <div id="img-input" style="display: none;">
                    <div class="d-flex cancel-row"> <div id="modify-btn-cancel">X</div></div>
                    <label for="image_url">image_url</label>
                    <p><input accept="image/*" type='file' id="imgInp" name="image"/>
                        <img id="imgPreview" src="#" alt="your image" />
                    </p>
                    <div class="input-group mb-3">
                        <input type="text" id="image_url" value="<?php echo $i ?>" class="form-control" name="image_url" placeholder="image_url">
                    </div>

                    <label for="image_alt">Kép alt</label>
                    <div class="input-group mb-3">
                        <input type="text" id="image_alt" value="<?php echo $ia ?>" class="form-control" name="image_alt" placeholder="image_alt">
                    </div>

                </div>
                    <textarea style="width: 100%;" name="content"><?php echo $c ?></textarea>
                    <script>
                        CKEDITOR.replace('content',{
    removeButtons: 'Source, Form,Checkbox,PasteText, PasteFromWord,Image,Table,About'
});
                    </script>
                    <br>

                    <label for="keywords">Kulcsszavak</label>
                    <div class="input-group mb-3">
                        <input type="text" id="keywords" name="keywords" value="<?php echo $k ?>" class="form-control" placeholder="Kulcsszavak">
                    </div>



                    <input type="text" hidden value="<?php echo $id ?>" class="form-control" name="id"><br>
                    <button class="btn btn-peimary">Mentés</button>
                </form>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>