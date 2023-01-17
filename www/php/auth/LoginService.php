<?php

// use Google\Auth;
require_once '/var/www/html/vendor/autoload.php';
include "/var/www/php/UserInfo.php";
include "/var/www/php/SQLDB.php";

class LoginService extends \Google\Client{

     private $FILEPATH = "/run/secrets/google_secret";

    public function __construct() {

        $this->setKey($this->getKey()); //Get secret
        
        parent::__construct(); // Construct Google Client before

        $k = json_decode($this->getKey(), true); //Format for auth config

        $this->setAuthConfig($k);

        $this->setAccessType('offline');
        $this->setApprovalPrompt('force');

        $this->addScope('profile'); //Add scope of google auth
        $this->addScope('email');
        $this->addScope(Google\Service\Calendar::CALENDAR);

        
        if (isset($_SESSION['token'])) { // If the session token is set, add token to google client
            $this->setAccessToken($_SESSION['token']);
        }

    }
    

    public function login() { // Login the user
        if (isset($_GET['code']) && !isset($_SESSION['token'])) { // If a user gets google access token
            $token = $this->fetchAccessTokenWithAuthCode($_GET['code']); // Fetch access token from auth code in $_GET['code'] supplied from google
            $this->setAccessToken($token); //Set access token for google client

            $_SESSION['token'] = $this->getAccessToken(); //Set session token to access token

            $db = new SQLDB();
            $userinfo = new UserInfo($this, $db); // Change to own  function 

            $id = $userinfo->getID();
            $_SESSION['id'] = $id;

            try { // This currently will always try to insert the user id, after one seccessful insert the primary key restriction fails all other inserts
                $stmt = $db->getCon()->query("INSERT INTO data.user_info (id,create_time) VALUES (". $id .",".  time() .")");

            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    // echo "User data exists.";
                }
            }
            // $result = $stmt->execute([$id, time()]);

            Header("Location: /");
        } else if (!isset($_SESSION['token'])) { // If user is not logged in
            echo "<a href='".$this->createAuthUrl()."'>login with Google</a>" ;


        } else if ($this->validate()) { // If a user navigates to login.php
            // echo "Logged in<br>";

            $db = new SQLDB();
            $userinfo = new UserInfo($this, $db); // Change to own  function 

            $id = $userinfo->getID();

            try {
                $stmt = $db->getCon()->query("INSERT INTO data.user_info (id,create_time) VALUES (". $id .",".  time() .")");
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    // echo "User data exists.";
                }
            }

            Header("Location: /");
        }
    }

    private function getKey() {
        // if (isset($this->clientSecret)) return $this->clientSecret;
        
        // $clientSecret = fopen(self::FILEPATH, "r", true) or die("Server Config Error!");

        $file = fopen($this->FILEPATH, "r", true) or die("Server Config Error!");
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
            
            Header("Location: /auth/login.php");
        }
        //     echo 
        // "<script type='text/javascript'>
        // window.location.href = 'http://localhost/auth/login.php';
        // </script>";}
        else return true;
    }

    public function heartbeat() {
        if (!isset($_SESSION['token']) || $this->isAccessTokenExpired()) {
            session_destroy();
            
            http_response_code (302);
            exit;
        }
        else {
            http_response_code (200);
            exit;
        }
    }

}