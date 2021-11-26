<?php
    include_once __DIR__ . '/../includes/DatabaseConnection.php';

    function query($pdo, $sql, $parameters = []) {
        $query = $pdo->prepare($sql);
        $query->execute($parameters);
        return $query;
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
        query($pdo, $query, $fields);
    }

    function updateJoke($pdo, $fields) {

        $query = 'UPDATE `joke` SET ';
        foreach($fields as $key => $value){
            $query .= '`' . $key . '` = :' . $key . ',';
        }

        rtrim($query, ',');
        $query .= ' WHERE `id` = :primaryKey';
        
        $fields['primaryKey'] = $fields['id'];
        query($pdo, $query, $fields);
    }

    function deleteJoke($pdo, $id) {
        $parameters = [':id' => $id];
        $query = query($pdo, 'DELETE FROM `joke` WHERE id=:id', $parameters);

        return $query;
    }

    function allJokes($pdo) {
        $jokes = query($pdo, 'SELECT `joke`, `id`, `joketext`
        , `email`, `name` FROM `joke` INNER JOIN `authorid` = `author`.`id`');

        return $jokes;
    }

    function fetchAll($pdo){
        $jokes = allJokes($pdo);
        echo '<ul>';
        foreach($jokes as $joke) {
            echo '<li>' . $joke . '</li>';
        }
        echo '</ul>';
    }

    $date = new DateTime("14 April 2000");
    echo $date->format('d---m---Y');
?>