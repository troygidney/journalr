<?php 

require_once '/var/www/html/vendor/autoload.php';

class SaveData {

    
    private $data;
    private $sqldb;
    private $client;


    public function __construct($data, $client) {
        $this->sqldb = new SQLDB();

        $this->setData($data);
        $this->setClient($client);
    }

    public function saveData() {
        $dateVar = new DateTime();
        $date = $dateVar->format('Y-m-d');

        $userinfo = new UserInfo($this->getClient());

        $json = json_encode($this->getData());
        $hash = hash("sha256", $userinfo->getID().$json['blocks']);

        if (isset($_SESSION['datahash']) && $_SESSION['datahash'] == $hash) {
            exit;
        }

        $_SESSION['datahash'] = $hash;
        echo $userinfo->getID().$json;
        

        // TODO Make database entry
        // Add DataLoader
        // Rename and refreactor to DataController
        // Storage hash locally to reduce amount of http requests
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