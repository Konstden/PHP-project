<?php
    include_once __DIR__ . '/../includes/DatabaseConnection.php';

    function query($pdo, $sql, $parameters = []) {
        $query = $pdo->prepare($sql);
        $query->execute($parameters);
        return $query;
    }

    function processDates($fields) {
        foreach($fields as $key => $value) {
            if ($value instanceof DateTime)
                $fields[$key] = $value->format('Y-m-d H:i:s');
        }

        return $fields;
    }

    function total($pdo, $table) {
        $query = query($pdo, 'SELECT COUNT(*) FROM `' . $table . '`');
        $row = $query->fetch();
        return $row[0];
    }
    
    
    function update($pdo, $table, $primaryKey, $fields) {
        
        $query = 'UPDATE `' . $table . '` SET ';
        foreach($fields as $key => $value){
            $query .= '`' . $key . '` = :' . $key . ',';
        }
        
        $query = rtrim($query, ',');
        
        $query .= ' WHERE `' . $primaryKey . '`= :primaryKey';
        
        $fields['primaryKey'] = $fields['id'];
        
        $fields = processDates($fields);
        query($pdo, $query, $fields);
    }
    
    function allJokes($pdo) {
        $jokes = query($pdo, 'SELECT `joke`.`id`, `joketext`,`email`, `name`, `jokedate`
                    FROM `joke` 
                    INNER JOIN author 
                    ON `authorid` = `author`.`id`');

        return $jokes->fetchAll();
        }

    function fetchAll($pdo, $results){
        // $jokes = allJokes($pdo);
        echo '<ul>';
        foreach($results as $result) {
            echo '<li>' . $result['joketext'] . '</li>';
        }
        echo '</ul>';
    }


    function findById($pdo, $table, $primaryKey, $value) {
        
        $parameters = [
            ':value' => $value
        ];

        $query = query($pdo, 'SELECT * FROM `' . $table . '` 
        WHERE `' . $primaryKey . '` =:value', $parameters);
        

        return $query->fetch();
    }

function findAll($pdo, $table) {
    $results = query($pdo, 'SELECT * FROM `' . $table . '`');
        
        return fetchAll($pdo, $results);
    }
    
    function delete($pdo, $table, $primaryKey, $id) {
        $parameters = [':id' => $id];
        
        $query = query($pdo,    'DELETE FROM `' . $table .
        '` WHERE `' . $primaryKey . '` =:id', $parameters);
    }
    
    function insert($pdo, $table, $fields) {
        $query = 'INSERT INTO `' . $table . '` (';
        
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
        
        $fields = processDates($fields);
        query($pdo, $query, $fields);
    }
    
    function save($pdo, $table, $primaryKey, $record) {
        try {
            if ($record[$primaryKey] == '') {
                $record[$primaryKey] = NULL;
            }
            insert($pdo, $table, $record);
        } catch (PDOException $e) {
            update($pdo, $table, $primaryKey, $record);
        }
    }
?>