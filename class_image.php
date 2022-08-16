<?php

class Image
{

    function upload_image()
    {
        $target_dir = "image/";
        $fileName = uniqid() . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $fileName;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $enabledFormat = ["png", "jpg", "jpeg", "webp"];
        if (!in_array($imageFileType, $enabledFormat)) {
            echo "Hibás formátum!";
        } else {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

            $this->convert_image($target_file, $fileName, $imageFileType);
        }
    }

    function list_images(){
        $pngImages = scandir('image/');
        foreach ($pngImages as $file) {
          if ($file !== "." && $file !== ".." && $file !== "webp") {
            $this->seo_image($file);
          }
        }
    }

    function convert_image($image, $fileName, $imageFileType)
    {
        $newImage = "image/webp/" . $fileName;
        copy($image, $newImage);
        switch ($imageFileType) {
            case "png":
                $im = imagecreatefrompng($newImage);
                $newImagePath = str_replace("png", "webp", $newImage);
                break;
            case "jpg":
                $im = imagecreatefromjpeg($newImage);
                $newImagePath = str_replace("jpg", "webp", $newImage);
                break;
            case "jpeg":
                $im = imagecreatefromjpeg($newImage);
                $newImagePath = str_replace("jpeg", "webp", $newImage);
                break;
            default:
            $im = imagecreatefrompng($newImage);
                $newImagePath = str_replace("png", "webp", $newImage);
        }
        $quality = 100;
        imagewebp($im, $newImagePath, $quality);
        unlink($newImage);
        header("Location:/");
    }

    function seo_image($file, $alt = 'NULL'){
        if(substr( $file, 0, 4 ) !== "http"){
            $imageName = explode(".",$file);
            if (count($imageName)<2){
                return;
            } 
            echo '<picture>
            <source type="image/webp" srcset="image/webp/ '.$imageName[0].'.webp">
            <source type="image/jpeg" srcset="image/'.$imageName[0].'.'.$imageName[1].'">
            <img src="image/'.$imageName[0].'.'.$imageName[1].'" alt="An image" title="An image " data-src="'.$file.'">
           </picture>
           ';
        } else {
            echo '<img src="'.$file.'" alt="'.$alt.'">';
        }
        
    }
}
