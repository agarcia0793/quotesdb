<?php
    class Database {
        private $host = 'localhost';
        private $port = '5432';
        private $db_name = 'quotesdb';
        private $username = 'postgres';
        private $password = 'postgres';
        private $conn;
    }


    public function connect() {
        $this->conn = null;
        $dsn = "pgsql:host={$this->host};port={$thhis->port};dbname={$this->db_name}"

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
          
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
         }

        return $this->conn;
    }

    public function __construct() {
        $this->username = getenv('USERNAME');
        $this->password = getenv('PASSWORD');
        $this->dbname = getenv('DBNAME');
        $this->host = getenv('HOST');
        $this->port = getenv('PORT');
    }