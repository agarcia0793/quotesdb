<?php 
    class Category {
        private $conn;
        private $table = 'categories';

        public $id;
        public $category;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = "SELECT  
                    id, 
                    category 
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
                    category
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
                    $this->category = $row['category'];
                }
                return $row;

            } catch (PDOException $e) {
                return array('error' => $e->getMessage());  
            }
                
        }

        public function create() {
            
            $query = "INSERT INTO {$this->table} (category) VALUES (:category)";

            try {
                $stmt = $this->conn->prepare($query);

                //clean data 
                $this->category = htmlspecialchars(strip_tags($this->category));
            
                $stmt->bindParam(':category', $this->category);

                $stmt->execute();
                $quote_arr = array(
                    'id' => $this->conn->lastInsertId(), 
                    'category' => $this->category
                );
                return $quote_arr;

            } catch (PDOException $e) {
                return array('error' => $e->getMessage());  
            }
        }

        public function update() {
            $query = "UPDATE {$this->table} 
                SET 
                    category = :category 
                WHERE 
                    id = :id";
            try {
                $stmt = $this->conn->prepare($query);

                //clean data 
                $this->category = htmlspecialchars(strip_tags($this->category));
                $this->id = htmlspecialchars(strip_tags($this->id));
                
                $stmt->bindParam(':category', $this->category);
                $stmt->bindParam(':id', $this->id);

                $stmt->execute();
                $quote_arr = array(
                    'id' => $this->id, 
                    'category' => $this->category
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