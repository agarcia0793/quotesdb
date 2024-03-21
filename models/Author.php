<?php 
    class Author {
        private $conn;
        private $table = 'authors';

        public $id;
        public $author;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = "SELECT  
                    id, 
                    author 
                FROM 
                    {$this->table}";
            try {
                $stmt = $this->conn->prepare($query);

                $stmt->execute();

                return $stmt;

            } catch (PDOException $e) {
                return array('error' => $e->getMessage());  
            }
        }

        public function read_single() {
            $query = "SELECT 
                    id, 
                    author
                FROM 
                    {$this->table}  
                WHERE 
                    id = ? 
                LIMIT 1"; 

            try {
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $this->id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $this->id = $row['id'];
                    $this->author = $row['author'];
                }
                return $row;

            } catch (PDOException $e) {
                return array('error' => $e->getMessage());  
            }
        }

        public function create() {
            $query = "INSERT INTO {$this->table} (author) VALUES (:author)";

            try {
                $stmt = $this->conn->prepare($query);

                //clean data 
                $this->author = htmlspecialchars(strip_tags($this->author));
            
                $stmt->bindParam(':author', $this->author);

                $stmt->execute();
                $quote_arr = array(
                    'id' => $this->conn->lastInsertId(), 
                    'author' => $this->author
                );
                return $quote_arr;

            } catch (PDOException $e) {
                return array('error' => $e->getMessage());  
            }
        }

        public function update() {
            $query = "UPDATE {$this->table} 
                SET 
                    author = :author 
                WHERE 
                    id = :id";

            try {
                $stmt = $this->conn->prepare($query);

                //clean data 
                $this->author = htmlspecialchars(strip_tags($this->author));
                $this->id = htmlspecialchars(strip_tags($this->id));
            
                $stmt->bindParam(':author', $this->author);
                $stmt->bindParam(':id', $this->id);

                $stmt->execute();
                $quote_arr = array(
                    'id' => $this->id, 
                    'author' => $this->author
                );
                return $quote_arr;
                
            } catch (PDOException $e) {
                return array('error' => $e->getMessage());  
            }
        }

        public function delete() {
            $query = "DELETE FROM {$this->table} 
                        WHERE id = :id";

            try {
                $stmt = $this->conn->prepare($query);

                $this->id = htmlspecialchars(strip_tags($this->id));

                $stmt->bindParam(':id', $this->id);

                $stmt->execute();
                $quote_arr = array(
                    'id' => $this->id
                );
                return $quote_arr;
                
            } catch (PDOException $e) {
                return array('error' => $e->getMessage());  
            }
        }
    }