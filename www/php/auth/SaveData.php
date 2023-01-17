<?php 

require_once '/var/www/html/vendor/autoload.php';
include "/var/www/php/UserInfo.php";
include "/var/www/php/SQLDB.php";

class SaveData {

    
    private $data;
    private $sqldb;
    private $client;


    private function __construct() {
        $this->sqldb = new SQLDB();
    }

    public static function noData() {
        $obj = new SaveData();

        return $obj;
    }

    public static function init($data, $client) {
        $obj = new SaveData();
        $obj->setData($data);
        $obj->setClient($client);
        return $obj;
    }


    private function saveData() {
        $dateVar = new DateTime();
        $date = $dateVar->format('Y-m-d');

        

    }


    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getClient() {
        return $this->client;
    }

    public function setClient($client) {
        $this->client = $client;
    }



}


?>