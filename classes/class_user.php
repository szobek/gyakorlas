<?php

class User
{
    public $allUser = [];
    public $file = "assets/jsons/users.json";
    function __construct()
    {
        $text = file_get_contents($this->file);
        $this->allUser = json_decode($text);
        
    }
    function login()
    {
        foreach ($this->allUser as $user) {
            if ($_REQUEST["email"] === $user->email) {
                var_dump($this->hash_password($_REQUEST["password"]));
                if($this->hash_password($_REQUEST["password"]) === $user->password){
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

    
    function getAllUser()
    {
        return $this->allUser;
    }


    function registration($text)
    {
        file_put_contents("assets/jsons/users.json", "");
        file_put_contents("assets/jsons/users.json",$text );
        return true;
    }
    function hash_password($password){
        $salt="ijiod";
return crypt($password,$salt);

    }

}


