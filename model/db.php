<?php
header('Content-type: application/json');
include ("./classes/select.php");
include ("../config/settings.php");
use Database\Select as Conn;

$pdo = new Conn();
$sql = "SELECT * FROM `t_koatuu_tree` WHERE (ter_level = 1) AND (ter_type_id = 0)";
$pdo->select($sql);
$pdo = null;
$sql = null;