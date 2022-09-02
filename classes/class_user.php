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
                
                if(password_verify($_REQUEST["password"],$user->password)){
                    $user = ["logged"=>true,"id"=>$user->id,"user"=>$user];
                    return $user;
                }
            }
        }
        return $user = ["logged"=>false];
        return $user;;
    }
    function getUserById($id)
    {
        $logged = new stdClass;
        $logged->firstName = "";
        $logged->lastName = "";
        
        foreach ($this->allUser as $user) {
            if ($id === $user->id) {
$logged=$user;
            }
        }
        
        return $logged;
    }

    function setLoggedAndAddData($session,$fn)
    {
        $user = $fn["user"];
$session["logged"] = true;
$session["user"] = $user;

return $session;
    }

    
    function getAllUser()
    {
        return $this->allUser;
    }


    function registration($request)
    {
        $emptyArray = [];
        
        $newUser = new stdClass;
        $newUser->id = uniqid();
        $newUser->firstName = $request["firstName"];
        $newUser->lastName = $request["lastName"];
        $newUser->password = $this->hash_password($request["password"]);
        $newUser->email = $request["email"];
        $allUser = $this->getAllUser();
        //var_dump($allUser);
        //die();
        $newArray = array_merge($emptyArray, $allUser);
        array_push($newArray, $newUser);
        $text=json_encode($newArray, JSON_UNESCAPED_UNICODE);
        file_put_contents("assets/jsons/users.json", "");
        file_put_contents("assets/jsons/users.json",$text );
        return true;
    }


    function hash_password($password){
    return password_hash($password, PASSWORD_ARGON2I);

    }



    function modify_logged_user($session, $request){
        $arr = [];
        $response = false;
        foreach ($this->allUser as $user) {
            if ($session["user"]->id === $user->id) {
                $session["user"]->firstName = $request["firstName"];
                $session["user"]->lastName = $request["lastName"];
                $user->firstName = $request["firstName"];
                $user->lastName = $request["lastName"];
                if($request["passwordNew"]===$request["passwordNew2"]){
                    $user->password = $this->hash_password($request["passwordNew2"]);
                } else{
                    die("Eltérő jelszavak");
                }
                array_push($arr, $user);

            }else{

                array_push($arr, $user);
            }
        }
        $text = json_encode($arr, JSON_UNESCAPED_UNICODE);
        file_put_contents("assets/jsons/users.json", "");
        file_put_contents("assets/jsons/users.json",$text );
        $response = true;
        return $response;
    }

}


