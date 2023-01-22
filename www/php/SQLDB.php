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

      public function __construct() {
        $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8", $this->username, $this->password, $this->options);
      }

      /**
       * @return PDO
       */
      public function getCon() {
        // print_r($this->connection);
          return $this->connection;
      }

}
