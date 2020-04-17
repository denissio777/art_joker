<?php
header('Content-type: application/json');

$servername = "localhost";
$username = "mysql";
$password = "mysql";
$dbname = "joker_db";

try {
    $pdo = new PDO("mysql:host=".$servername.";dbname=".$dbname, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement = "SELECT * FROM `t_koatuu_tree` WHERE (ter_level = 1) AND (ter_type_id = 0)";
    $sql = $pdo->prepare($statement);
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    $response = json_encode($result, JSON_UNESCAPED_UNICODE);
    echo $response;
}
catch (PDOException $e) {
    echo $e->getMessage();
    die();
}