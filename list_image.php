<?php
include_once "load.php";
include_once "check_logged.php";
$img_class = new Image();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include_once "header.php" ?>
</head>
<body>
    <div class="img-list">
        
        <?php
$img_class->list_images();

?>
</div>
<script >
            let photos = document.querySelectorAll('.photo-item');
            console.log(photos);
        for(let photo of photos) {
            photo.addEventListener('click', ev => returnFileUrl(ev));
            photo.addEventListener('click', ev => browse(ev));
        }


        function returnFileUrl(ev) {
            var fileUrl = ev.target.dataset.url;
            window.opener.CKEDITOR.tools.callFunction( 1, fileUrl );
            window.close();
        }

        function browse(ev) {
            var fileUrl = ev.target.dataset.name;
            var pathLib = ev.target.dataset.pathlib;
            var pathOriginal = ev.target.dataset.pathoriginal;
            window.opener.popupCallback({fileUrl,pathLib, pathOriginal});
            window.close();
        }
        </script>

</body>
</html>