<?php 

require_once '/var/www/html/vendor/autoload.php';

class DataController {
    
    private $data;
    private $sqldb;
    private $client;
    private $date;

    public function __construct($data, $client) {
        $this->sqldb = new SQLDB();

        $this->setData($data);
        $this->setClient($client);

        $dateVar = new DateTime("America/Edmonton");
        $this->date = $dateVar->format('Ymd');
    }

    public function saveData() {


        $userinfo = new UserInfo($this->getClient());

        $json = json_encode($this->getData()); // Is there a better way to refrence json in php?
        $block = json_encode($this->getData()['blocks']);

        $id = $userinfo->getID();

        $hash = base64_encode($block);

        print_r ($hash);

        if (isset($_SESSION['datahash']) && $_SESSION['datahash'] == $hash) {
            exit;
        }

        $_SESSION['datahash'] = $hash;

        try { // All of these need to be changed to prepared statements  
            $stmt = $this->sqldb->getCon()->query("
            INSERT INTO data.user_data (date, owner_id, data_refrence) VALUES (". $this->date .",".  $id .",'". $hash ."') ON DUPLICATE KEY UPDATE data_refrence='".$hash."';
            ");

            $stmt = $this->sqldb->getCon()->query("
            INSERT INTO data.user_data_content (data_id, data_content) VALUES ('". $hash ."','". $json ."') ON DUPLICATE KEY UPDATE data_content='".$json."';
            ");

            print_r($stmt);
        } catch (PDOException $e) {
            print_r ($e);
        }
        

        // TODO Make database entry
        // Add DataLoader
        // Storage hash locally to reduce amount of http requests
    }

    public function loadData() {
        if ($this->getData != null) { // if data is not null, either it's a first load, or a refresh
            echo "not null data";
            return;
        }

        $userinfo = new UserInfo($this->getClient());
        $id = $userinfo->getID();

        $date = isset($_POST['date']) ? $_POST['date'] : $this->date;

        try {
            $stmt = $this->sqldb->getCon()->query("
            SELECT user_data_content.data_content 
            FROM data.user_data
            LEFT JOIN data.user_data_content
            ON data.user_data.data_refrence = data.user_data_content.data_id
            WHERE date=". $date ." AND owner_id=". $id ." ;
            ");

            foreach ($stmt as $row) { //TODO Add selection of multi days
                foreach($row as $index) {
                    print_r ($index);
                }
            }

        } catch (PDOException $e) {
            print_r($e);
        }




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