<?php
    include_once __DIR__ . '/../includes/DatabaseConnection.php';

    function query($pdo, $sql, $parameters) {
        $query = $pdo->prepare($sql);
        foreach ($parameters as $name => $value) {
            $query->bindValue($name, $value);
        }
        
        $query->execute();
        return $query;
    }
    function totalJokes($pdo) {
        $parameters = [];
        $query = query($pdo, 'SELECT COUNT(*) FROM `joke`', $parameters);
        return $query->fetch[0];
    }

    function getJoke($pdo, $id) {
        $parameters = [':id', $id];

        $query = query($pdo, 'SELECT FROM `joke` WHERE `id`=:id', $parameters);
        return $query->fetch();
    }
?>