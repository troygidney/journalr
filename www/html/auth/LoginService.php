<?php

class LoginService extends \Google\Client{

     const FILEPATH = "/run/secrets/google_secret";

    public function __construct() {

        $this->setKey($this->getKey());
        
        parent::__construct();

        $k = json_decode($this->getKey(), true);

        $this->setAuthConfig($k);

        $this->addScope('profile');
        $this->addScope('email');
        
        if (isset($_SESSION['token'])) {
            $this->setAccessToken($_SESSION['token']);
        }

    }
    

    public function login() {
        if (isset($_GET['code']) && !isset($_SESSION['token'])) {
            $token = $this->fetchAccessTokenWithAuthCode($_GET['code']);
            $this->setAccessToken($token);
        
            $gauth = new Google_Service_oauth2($this);
            $google_info = $gauth->userinfo->get();
            $email = $google_info->email;
            $name = $google_info->name;
        
            echo "Welcome ". $name. ". You are logged in with ". $email;
            $_SESSION['token'] = $this->getAccessToken();
        

        } else if (!isset($_SESSION['token'])) {
            echo "<a href='".$this->createAuthUrl()."'>login with Google</a>" ;


        } else if ($this->validate()) {
            echo "Logged in<br>";

            $gauth = new Google_Service_oauth2($this);
            $google_info = $gauth->userinfo->get();
            $email = $google_info->email;
            $name = $google_info->name;

            echo "Welcome ". $name. ". You are logged in with ". $email;
        }
    }

    private function getKey() {
        // if (isset($this->clientSecret)) return $this->clientSecret;
        
        // $clientSecret = fopen(self::FILEPATH, "r", true) or die("Server Config Error!");

        $file = fopen(self::FILEPATH, "r", true) or die("Server Config Error!");
        $clientSecret = fread($file,filesize("/run/secrets/google_secret"));
        fclose($file);
        
        return $clientSecret;
    }

    public function setKey($key) {
        $this->setClientSecret($key);
    }

    public function validate() {
        if (!isset($_SESSION['token']) || $this->isAccessTokenExpired()) echo 
        "<script type='text/javascript'>
        window.location.href = 'http://localhost/auth/login.php';
        </script>";
        else return true;
    }

}