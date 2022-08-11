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

    function list_images()
    {
    }

    function convert_image($image, $fileName, $imageFileType)
    {
        $newImage = "image/webp/" . $fileName;
        copy($image, $newImage);
        switch ($imageFileType) {
            case "png":
                $im = imagecreatefrompng($newImage);
                $newImagePath = str_replace("png ", "webp", $newImage);
                break;
            case "jpg":
                imagecreatefromjpeg($newImage);
                $newImagePath = str_replace("jpg ", "webp", $newImage);
                break;
            case "jpeg":
                imagecreatefromjpeg($newImage);
                $newImagePath = str_replace("jpeg ", "webp", $newImage);
                break;
            default:
        }
        $quality = 100;
        imagewebp($im, $newImagePath, $quality);
    }
}
