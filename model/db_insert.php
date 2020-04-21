<?php
header('Content-type: application/json');
include ("./classes/select.php");
include ("../config/settings.php");
use Database\Select as Conn;

if (isset($_GET['name'])) { $name = $_GET['name']; if ($name =='') { unset($name);} }
if (isset($_GET['email'])) { $email = $_GET['email']; if ($email =='') { unset($email);} }
if (isset($_GET['territory'])) { $territory = $_GET['territory']; if ($territory =='') { unset($territory);} }

$name = htmlspecialchars($name);
$email = htmlspecialchars($email);
$pdo = new Conn();

$table = "CREATE TABLE IF NOT EXISTS users (
        id INT (99) PRIMARY KEY NOT NULL AUTO_INCREMENT,
        name VARCHAR (255) NOT NULL,
        email VARCHAR (255) NOT NULL,
        territory VARCHAR (255) NOT NULL
    );";
$pdo->createTable($table);

$data = "SELECT * FROM `users` WHERE (email = '" . $email . "')";
$pdo->check($data, $name, $email, $territory);
$pdo = null;
$table = null;
$data = null;