<?php

if(array_key_exists("logged",$_SESSION)){
    if(!$_SESSION["logged"]){
        header("Location:login.php");
    }
}
