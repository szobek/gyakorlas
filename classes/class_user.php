<?php

require_once "classes/class_news.php";

class User
{
    public $allUser;
    public $author;
    public $user;
    public $file = "assets/jsons/users.json";


    function __construct()
    {
        $this->allUser = [];

        $text = file_get_contents($this->file);
        $regex='/^[[]\W+id\W+\w+\W+firstName\W+\w+\W+lastName\W+\w+\W+password.+\W+email\W+.+\W+]$/';
        $result_preg_match = preg_match($regex, $text);
        //var_dump($result_preg_match);die();
        if ($result_preg_match) {
            $this->allUser = json_decode($text);
        } else {
            $this->allUser = [];
        }
         
        
        
        if ($_SERVER["PHP_SELF"] === "/author-profile.php") {
            $this->getUserById($_REQUEST["id"]);
        }
        if ($_SERVER["PHP_SELF"] === "/one_news.php") {
            $this->getUserByNewsId($_REQUEST["id"]);
        }
    }
    public function login()
    {
        $user_logged = [];
        foreach ($this->allUser as $user) {
            if ($_REQUEST["email"] === $user->email) {
                $psw = $user->password;
                $verify_psw=password_verify($_REQUEST["password"], $psw);
                //var_dump($verify_psw);die();
                
                if ($verify_psw) {
                    $user_logged = ["logged" => true, "id" => $user->id, "user" => $user];
                    return $user_logged;
                }
            }
        }
        return ["logged" => false];
    }
    protected function getUserByNewsId(string $id): void
    {
        $news_class = new News();
        $news = $news_class->get_news_by_id($id);

        foreach ($this->allUser as  $user) {
            if ($news->author === $user->id) {
                $this->author = $user;
                break;
            }
        }
    }
    protected function getUserById(string $id):void
    {
        foreach ($this->allUser as  $user) {
            if ($id === $user->id) {
                $this->user = $user;
                break;
            }
        }
    }

    public function setLoggedAndAddData(array $session, array $fn): array
    {
        $user = $fn["user"];
        $session["logged"] = true;
        $session["user"] = $user;

        return $session;
    }

    public function registration(array $request): bool
    {
        try {
            $emptyArray = [];

            $newUser = new stdClass;
            $newUser->id = uniqid();
            $newUser->firstName = $this->secure_string($request["firstName"]);
            $newUser->lastName = $this->secure_string($request["lastName"]);
            $newUser->password = $this->hash_password($request["password"]);
            $newUser->email = $this->secure_string($request["email"]);
            $allUser = $this->allUser;
            $newArray = array_merge($emptyArray, $allUser);
            array_push($newArray, $newUser);
            $text = json_encode($newArray, JSON_UNESCAPED_UNICODE);
            file_put_contents("assets/jsons/users.json", "");
            file_put_contents("assets/jsons/users.json", $text);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    protected function hash_password(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2I);
    }



    public function modify_logged_user(array $session, array $request): bool
    {

        try {
            $arr = [];
            foreach ($this->allUser as $user) {
                if ($session["user"]->id === $user->id) {
                    $session["user"]->firstName = $user->firstName = $this->secure_string($request["firstName"]);
                    $session["user"]->lastName = $user->lastName = $this->secure_string($request["lastName"]);
                    if ($request["passwordNew"] === $request["passwordNew2"]) {
                        $user->password = $this->hash_password($request["passwordNew2"]);
                    } else {
                        die("Eltérő jelszavak");
                    }
                    array_push($arr, $user);
                } else {

                    array_push($arr, $user);
                }
            }
            $text = json_encode($arr, JSON_UNESCAPED_UNICODE);
            file_put_contents("assets/jsons/users.json", "");
            file_put_contents("assets/jsons/users.json", $text);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function logout(): void
    {
        session_destroy();
        header("Location:/");
    }
    protected function secure_string(string $string): string
    {
        return htmlspecialchars(strip_tags($string), ENT_QUOTES, 'UTF-8');;
    }
}
