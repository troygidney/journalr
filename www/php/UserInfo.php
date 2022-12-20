<?php 
 class UserInfo{

    private $gauth;
    private $google_info;


    public function __construct($client) {
        if (isset($_SESSION['token'])) {
            $this->gauth = new Google_Service_oauth2($client);
            $this->google_info = $this->gauth->userinfo->get();
        }
    }

    public function getName() {
        return $this->google_info->name;
    }

    public function getEmail() {
        return $this->google_info->email;
    }

    public function getPicture() {
        return $this->google_info->picture;
    }

 }
?>