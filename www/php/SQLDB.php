<?php

class SQLDB  {

        private $username = "datauser";
        private $password = "TEMP"; // TOOD Change to secret

        private $database = "data";
        private $host = "mysql"; // docker container 

        private $options = [
          PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];

        private $connection;

      //  $connection = new PDO("mysql:host={$host};dbname={$database};charset=utf8", $user, $password);  
      //  $query = $connection->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_TYPE='BASE TABLE'");  
      //  $tables = $query->fetchAll(PDO::FETCH_COLUMN);  

      //   if (empty($tables)) {
      //     echo "<p>There are no tables in database \"{$database}\".</p>";
      //   } else {
      //     echo "<p>Database \"{$database}\" has the following tables:</p>";
      //     echo "<ul>";
      //       foreach ($tables as $table) {
      //         echo "<li>{$table}</li>";
      //       }
      //     echo "</ul>";
      //   }


      public function __construct() {
        // echo "con:";
        // print_r(new PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8", $this->username, $this->password));
        $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8", $this->username, $this->password, $this->options);
        // print_r($this->connection);
        // $query = $this->connection->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_TYPE='BASE TABLE'");  
        // $tables = $query->fetchAll(PDO::FETCH_COLUMN);

        // print_r ($tables);
      }



      /**
       * @return PDO
       */
      public function getCon() {
        // print_r($this->connection);
          return $this->connection;
      }

}


?>