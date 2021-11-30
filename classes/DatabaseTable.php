<?php
    include __DIR__ . '/../includes/DatabaseConnection.php';

    class DatabaseTable 
    {
        public $pdo;
        public $table;
        public $primaryKey;

        public function __construct(PDO $pdo, string $table, string $primaryKey) 
        {
            $this->pdo = $pdo;
            $this->table = $table;
            $this->primaryKey = $primaryKey;
        }
            

        private function query($sql, $parameters = []) 
        {
            $query = $this->pdo->prepare($sql);
            $query->execute($parameters);
            return $query;
        }
    
        private function processDates($fields) 
        {
            foreach($fields as $key => $value) {
                if ($value instanceof DateTime)
                    $fields[$key] = $value->format('Y-m-d H:i:s');
            }
    
            return $fields;
        }
    
        public function total()
        {
            $query = $this->query($this->pdo, 'SELECT COUNT(*) FROM `' . $this->table . '`');
            $row = $query->fetch();
            return $row[0];
        }
        
        
        private function update($fields) 
        {
            
            $query = 'UPDATE `' . $this->table . '` SET ';
            foreach($fields as $key => $value){
                $query .= '`' . $key . '` = :' . $key . ',';
            }
            
            $query = rtrim($query, ',');
            
            $query .= ' WHERE `' . $this->primaryKey . '`= :primaryKey';
            
            $fields['primaryKey'] = $fields['id'];
            
            $fields = $this->processDates($fields);
            $this->query($this->pdo, $query, $fields);
        }
        
        public function findById($value)
        {
            
            $parameters = [
                ':value' => $value
            ];
            $sql = 'SELECT * FROM `' . $this->table . '` 
            WHERE `' . $this->primaryKey . '` =:value';
    
            $query = $this->query($sql, $parameters);
            
    
            return $query->fetch();
        }
    
        public function findAll() {
            $result = $this->query($this->pdo, 'SELECT * FROM `' . $this->table . '`');
            
            return $result->fetchAll();
        }
        
        public function delete($id) {
            $parameters = [':id' => $id];
            
            $query = $this->query($this->pdo,    'DELETE FROM `' . $this->table .
            '` WHERE `' . $this->primaryKey . '` =:id', $parameters);
        }
        
        private function insert($fields) {
            $query = 'INSERT INTO `' . $this->table . '` (';
            
            foreach($fields as $key => $value) {
                $query .= '`' . $key . '`,';
            }
    
            $query = rtrim($query, ',');
    
            $query .= ') VALUES (';
            
            foreach($fields as $key => $value) {
                $query .= ':' . $key . ',';
            }
            
            $query = rtrim($query, ',');
            $query .= ')';
            
            echo $query;
            
            $fields = $this->processDates($fields);
            $this->query($this->pdo, $query, $fields);
        }
        
        public function save($record) {
            try {
                if ($record[$this->primaryKey] == '') {
                    $record[$this->primaryKey] = NULL;
                }
                $this->insert($record);
            } catch (PDOException $e) {
                $this->update($record);
            }
        }
    }       

    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');

    print_r($jokesTable->findById(10));
    print_r($authorsTable->findById(3));