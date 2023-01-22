<?php 

require_once '/var/www/html/vendor/autoload.php';

 class UserInfo{

    private $gauth;
    private $google_info;

    private $calendarService;


    public function __construct($client) {
        if (isset($_SESSION['token'])) {
            $this->gauth = new Google\Service\Oauth2($client);
            $this->google_info = $this->gauth->userinfo->get();
            $this->service = new Google\Service\Calendar($client);
        }

    }

    public function getCalendarService() {
        return $this->getCalendarService;
    }

    public function getName() {
        return $this->google_info->name;
    }

    public function getEmail() {
        return $this->google_info->email;
    }

    public function getID() {
        return $this->google_info->id;
    }

    public function getPicture() {
        return $this->google_info->picture;
    }

 }
