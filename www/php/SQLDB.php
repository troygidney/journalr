<?php

class SQLDB  {

        private $username = "datauser";
        private $password = "TEMP"; // TOOD Change to secret

        private $database = "data";
        private $host = "mysql"; // docker container 

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
        if ($this->connection == null) $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8", $this->username, $this->password);

        $query = $this->connection->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_TYPE='BASE TABLE'");  
        $tables = $query->fetchAll(PDO::FETCH_COLUMN);

        // print_r ($tables);
      }

}


?>