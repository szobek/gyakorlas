<?php

class User
{
    public $allUser = [];
    function __construct()
    {
        $file = "users.json";
        $text = file_get_contents($file);
        $this->allUser = json_decode($text);
    }
    function login()
    {
        foreach ($this->allUser as $user) {
            if ($_REQUEST["email"] === $user->email) {
                if($_REQUEST["password"] === $user->password){
                    $user = ["logged"=>true,"id"=>$user->id,"user"=>$user];
                    return $user;
                }
            }
        }
        return $user = ["logged"=>false];
        return $user;;
    }
    function loggedUser()
    {
    }

    function setLogged()
    {
    }

}
