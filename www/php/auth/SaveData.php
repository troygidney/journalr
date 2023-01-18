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
        $date = $dateVar->format('Ymd');

        $userinfo = new UserInfo($this->getClient());

        $json = json_encode($this->getData()); // Is there a better way to refrence json in php?
        $block = json_encode($this->getData()['blocks']);

        $id = $userinfo->getID();

        $hash = hash("sha256", $id.$block);

        print_r($_SESSION['datahash']);

        if (isset($_SESSION['datahash']) && $_SESSION['datahash'] == $hash) {
            exit;
        }

        $_SESSION['datahash'] = $hash;
        echo $userinfo->getID().$json;

        try {
            $stmt = $this->sqldb->getCon()->query("
            INSERT INTO data.user_data (date, owner_id, data_refrence) VALUES (". (int)$date .",".  $id .",'". $hash ."') ON DUPLICATE KEY UPDATE data_refrence='".$hash."';
            ");

            $stmt = $this->sqldb->getCon()->query("
            INSERT INTO data.user_data_content (data_id, data_content) VALUES ('". $hash ."','". $json ."') ON DUPLICATE KEY UPDATE data_content='".$json."';
            ");
        } catch (PDOException $e) {

        }
        

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