<?php
header('Content-type: application/json');

$servername = "localhost";
$username = "mysql";
$password = "mysql";
$dbname = "joker_db";

if (isset($_GET['name'])) { $name = $_GET['name']; if ($name =='') { unset($name);} }
if (isset($_GET['email'])) { $email = $_GET['email']; if ($email =='') { unset($email);} }
if (isset($_GET['territory'])) { $territory = $_GET['territory']; if ($territory =='') { unset($territory);} }

try {
    $pdo = new PDO("mysql:host=".$servername.";dbname=".$dbname, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = "CREATE TABLE IF NOT EXISTS users (
        id INT (99) PRIMARY KEY NOT NULL AUTO_INCREMENT,
        name VARCHAR (255) NOT NULL,
        email VARCHAR (255) NOT NULL,
        territory VARCHAR (255) NOT NULL
    );";
    $mysql = $pdo->prepare($stmt);
    $mysql->execute();

    $check = "SELECT * FROM `users` WHERE (email = '" . $email . "')";
    $sqli = $pdo->prepare($check);
    $sqli->execute();
    $result = $sqli->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $k => $v) {
        $mail = $v['email'];
    }
    if ($email == $mail) {
        $response = json_encode($result, JSON_UNESCAPED_UNICODE);
        echo $response;
    } else {
        $statement = "INSERT INTO users (name, email, territory) VALUES (:name, :email, :territory)";
        $sql = $pdo->prepare($statement);
        $sql->bindParam(':name', $name);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':territory', $territory);
        $sql->execute();
    }
}
catch (PDOException $e) {
    echo $e->getMessage();
    die();
}