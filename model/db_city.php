<?php
header('Content-type: application/json');

$servername = "localhost";
$username = "mysql";
$password = "mysql";
$dbname = "joker_db";

if (isset($_GET['catched'])) { $catched = $_GET['catched']; if ($catched =='') { unset($catched);} }

try {
    $pdo = new PDO("mysql:host=".$servername.";dbname=".$dbname, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement = "SELECT * FROM `t_koatuu_tree` WHERE ter_level IN (2, 3) AND (ter_type_id = 1) AND (reg_id = '" . $catched . "')";
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