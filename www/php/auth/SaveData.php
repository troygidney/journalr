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

        $json = json_encode($this->getData());
        $hash = hash("sha256", $userinfo->getID().$this->getData()['blocks']);

        if (isset($_SESSION['datahash']) && $_SESSION['datahash'] == $hash) {
            exit;
        }

        $_SESSION['datahash'] = $hash;
        echo $userinfo->getID().$json;

        try {
            $stmt = $this->sqldb->getCon()->query("INSERT INTO data.user_data (date, id, data_refrence) VALUES (". (int)$date .",".  $userinfo->getID() .",". $hash .")");
        } catch (PDOException $e) {
            print_r($e);
            if ($e->getCode() == 23000) {
                // echo "User data exists.";
            }
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