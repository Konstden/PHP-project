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
    function totalJokes($pdo) {
        $query = query($pdo, 'SELECT COUNT(*) FROM `joke`');
        return $query->fetch()[0];
    }

    function getJoke($pdo, $id) {
        $parameters = [':id', $id];

        $query = query($pdo, 'SELECT FROM `joke` WHERE `id`=:id', $parameters);
        return $query->fetch();
    }

    function insertJoke($pdo,$fields) {
        $query = 'INSERT INTO `joke` (';

        foreach($fields as $key => $value) {
            $query .= $key . ',';
        }
        rtrim($query, ',');
        $query .= ') VALUES (';
        foreach($fields as $key => $value) {
            $query .= ':' . $key . ',';
        }
        rtrim($query, ',');
        $query .= ')';
        
        
        $fields = processDates($fields);
        query($pdo, $query, $fields);
    }

    function update($pdo, $table, $primaryKey, $fields) {

        $query = 'UPDATE `' . $table . '` SET ';
        foreach($fields as $key => $value){
            $query .= '`' . $key . '` = :' . $key . ',';
        }

        rtrim($query, ',');
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

    function fetchAll($pdo){
        $jokes = allJokes($pdo);
        echo '<ul>';
        foreach($jokes as $joke) {
            echo '<li>' . $joke . '</li>';
        }
        echo '</ul>';
    }

    function findAll($pdo, $table) {
        $result = query($pdo, 'SELECT * FROM `' . $table . '`');

        return $result->fetchAll();
    }

    function delete($pdo, $table, $primaryKey, $id) {
        $parameters = [':id' => $id];

        $query = query($pdo,    'DELETE FROM `' . $table .
            '` WHERE `' . $primaryKey . '` =:id', $parameters);
    }

    function insert($pdo, $table, $fields) {
        $query = 'INSERT INTO `' . $table . '`(';

        foreach($fields as $key => $value) {
            $query .= $key . ',';
        }

        rtrim($query, ',');
        $query .= ') VALUES (';
        
        foreach($fields as $key => $value) {
            $query .= ':' . $key . ',';
        }
        
        rtrim($query, ',');
        $query .= ')';
        
        
        $fields = processDates($fields);
        query($pdo, $query, $fields);
    }
?>