<?php

class Image
{

    function upload_image($name = "image")
    {
        $target_dir = "./image/";
        $uid = uniqid();


        $fileName = $uid . basename($_FILES[$name]["name"]);
        $target_file = $target_dir . $fileName;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $enabledFormat = ["png", "jpg", "jpeg", "webp"];

        $convertedNameArray = explode("." . $imageFileType, $fileName);
        $convertedName = $this->convert_image_name($convertedNameArray[0]);
        $target_file = $target_dir . $convertedName . "." . $imageFileType;
        if (!in_array($imageFileType, $enabledFormat)) {
            echo "Hibás formátum!";
        } else {
            if ($imageFileType !== "webp") {

                move_uploaded_file($_FILES[$name]["tmp_name"], $target_file);

                $this->convert_image($target_file, $convertedName . "." . $imageFileType, $imageFileType);
            } else {

                move_uploaded_file($_FILES[$name]["tmp_name"], "image/webp/" . $fileName);
            }
        }
        $ret = ["uid" => $uid, "filename" => $convertedName . "." . $imageFileType];
        return $ret;
    }

    function list_images()
    {
        $pngImages = scandir('./image/');
        foreach ($pngImages as $file) {
            if ($file !== "." && $file !== ".." && $file !== "webp") {
                $this->seo_image($file);
            }
        }
    }

    function convert_image($image, $fileName, $imageFileType)
    {

        $newImage = "image/webp/" . $fileName;
        //die($fileName);
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
    }

    function seo_image($file, $alt = 'NULL')
    {
        if (substr($file, 0, 4) !== "http") {
            $imageName = explode(".", $file);
            if (count($imageName) < 2) {
                return;
            }
            echo '<picture >
            <source type="../image/webp" srcset="image/webp/' . $imageName[0] . '.webp">
            <source type="../image/jpeg" srcset="image/' . $imageName[0] . '.' . $imageName[1] . '">
            <img 
            data-url="../image/' . $imageName[0] . '.' . $imageName[1] . '"
            data-name="' . $imageName[0] . '.' . $imageName[1] . '"
            data-pathlib="../image/"
            data-pathoriginal="../image/"
            class="photo-item" 
            data-src="' . $file . '"
            src="../image/' . $imageName[0] . '.' . $imageName[1] . '" 
            alt="'.$alt.'" 
            title="An image " >
           </picture>
           ';
        } else {
            echo '<img src="' . $file . '" alt="' . $alt . '">';
        }
    }

    function convert_image_name($fileName)
    {
        $mirol = ["/[^a-zA-Z0-9]/"];
        $mire = ["_"];
        return preg_replace($mirol, $mire, $fileName);
    }
}
