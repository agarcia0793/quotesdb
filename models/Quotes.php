<?php 
    class Quote {
        private $conn;
        private $table = 'quotes';

        public $id;
        public $quote;
        public $author_id;
        public $category_id;
        public $author;
        public $category;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = "SELECT 
                q.id,
                q.quote,
                a.author,  
                c.category 
            FROM 
                {$this->table} q 
            LEFT JOIN 
                authors a ON q.author_id = a.id 
            LEFT JOIN 
                categories c ON q.category_id = c.id"; 
                    
            if ($this->author_id && $this->category_id) {
                $query = $query . " WHERE q.author_id = :author_id AND q.category_id = :category_id";
            } else if ($this->author_id) {
                $query = $query . " WHERE q.author_id = :author_id";
            } else if ($this->category_id) {
                $query = $query . " WHERE q.category_id = :category_id";
            }

            //Statement
            try {
                $stmt = $this->conn->prepare($query);

                if ($this->author_id) $stmt->bindParam(':author_id', $this->author_id);
                if ($this->category_id) $stmt->bindParam(':category_id', $this->category_id);

                //Execute
                $stmt->execute();

                return $stmt;
            } catch (PDOException $e) {
                return array('error' => $e->getMessage());  
            }
        }

        public function read_single() {
            $query = "SELECT 
                    q.id,
                    q.quote,
                    a.author,  
                    c.category 
                FROM 
                    {$this->table} q 
                LEFT JOIN 
                    authors a ON q.author_id = a.id 
                LEFT JOIN 
                    categories c ON q.category_id = c.id 
                WHERE 
                    q.id = ? 
                LIMIT 1"; 
            
            try {
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $this->id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $this->id = $row['id'];
                    $this->quote = $row['quote'];
                    $this->author = $row['author'];
                    $this->category = $row['category'];
                }
                return $row;

            } catch (PDOException $e) {
                return array('error' => $e->getMessage());  
            }
        }

        public function create() {
            $query = "INSERT INTO {$this->table} (quote, author_id, category_id) VALUES (:quote,:author_id,:category_id)";

            try {
                $stmt = $this->conn->prepare($query);

                //clean data 
                $this->quote = htmlspecialchars(strip_tags($this->quote));
                $this->author_id = htmlspecialchars(strip_tags($this->author_id));
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                $stmt->bindParam(':quote', $this->quote, PDO::PARAM_STR);
                $stmt->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
                $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
                $stmt->execute();
                
                $quote_arr = array(
                    'id' => $this->conn->lastInsertId(), 
                    'quote' => $this->quote, 
                    'author_id' => $this->author_id, 
                    'category_id' => $this->category_id
                );
                return $quote_arr;
                
            } catch (PDOException $e) {
                return array('error' => $e->getMessage());  
            }
        }

        public function update() {
            $query = "UPDATE {$this->table} 
                SET 
                    quote = :quote, 
                    author_id = :author_id, 
                    category_id = :category_id 
                WHERE 
                    id = :id";

            try {
                $stmt = $this->conn->prepare($query);

                //clean data 
                $this->quote = htmlspecialchars(strip_tags($this->quote));
                $this->author_id = htmlspecialchars(strip_tags($this->author_id));
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                $this->id = htmlspecialchars(strip_tags($this->id));
            
                $stmt->bindParam(':quote', $this->quote);
                $stmt->bindParam(':author_id', $this->author_id);
                $stmt->bindParam(':category_id', $this->category_id);
                $stmt->bindParam(':id', $this->id);

                $stmt->execute();
                $quote_arr = array(
                    'id' => $this->id, 
                    'quote' => $this->quote, 
                    'author_id' => $this->author_id, 
                    'category_id' => $this->category_id
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