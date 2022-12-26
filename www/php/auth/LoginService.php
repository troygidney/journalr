<?php

class LoginService extends \Google\Client{

     const FILEPATH = "/run/secrets/google_secret";

    public function __construct() {

        $this->setKey($this->getKey()); //Get secret
        
        parent::__construct(); // Construct Google Client before

        $k = json_decode($this->getKey(), true); //Format for auth config

        $this->setAuthConfig($k);

        $this->addScope('profile'); //Add scope of google auth
        $this->addScope('email');
        $this->addScope(Google_Service_Calendar::CALENDAR);

        
        if (isset($_SESSION['token'])) { // If the session token is set, add token to google client
            $this->setAccessToken($_SESSION['token']);
        }

    }
    

    public function login() { // Login the user
        if (isset($_GET['code']) && !isset($_SESSION['token'])) { // If a user gets google access token
            $token = $this->fetchAccessTokenWithAuthCode($_GET['code']); // Fetch access token from auth code in $_GET['code'] supplied from google
            $this->setAccessToken($token); //Set access token for google client

            $_SESSION['token'] = $this->getAccessToken(); //Set session token to access token
        
            echo 
            "<script type='text/javascript'>
                window.location.href = 'http://localhost/';
            </script>";
        } else if (!isset($_SESSION['token'])) { // If user is not logged in
            echo "<a href='".$this->createAuthUrl()."'>login with Google</a>" ;


        } else if ($this->validate()) { // If a user navigates to login.php
            echo "Logged in<br>";

            echo 
            "<script type='text/javascript'>
                window.location.href = 'http://localhost/';
            </script>";
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
        if (!isset($_SESSION['token']) || $this->isAccessTokenExpired()) {
            session_destroy();
            
            echo 
        "<script type='text/javascript'>
        window.location.href = 'http://localhost/auth/login.php';
        </script>";}
        else return true;
    }

}