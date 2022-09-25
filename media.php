<?php 
require_once "load.php";
$image = new Image();
$newImg=$image->upload_image("upload");
$fileNameToStore = $newImg["filename"];
$url = "image/".$fileNameToStore;
$res = ['uploaded' => '1','fileName' => $fileNameToStore,'url' => $url];
echo json_encode($res);