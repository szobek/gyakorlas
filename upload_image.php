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
<?php
function rasmname(){
 $dirname = "./";
 $images = glob($dirname."*.jpg");
foreach($images as $image) {
 echo '<img src="'.$image.'" /><br />';
  }
}
rasmname();
?>
    <form action="media.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image" id="">
        <button>Mentés</button>
    </form>
</body>
</html>