<?php
header('Content-type: application/json');
include ("./classes/select.php");
include ("../config/settings.php");
use Database\Select as Conn;

if (isset($_GET['catched'])) { $catched = $_GET['catched']; if ($catched =='') { unset($catched);} }

$pdo = new Conn();
$sql = "SELECT * FROM `t_koatuu_tree` WHERE ter_level IN (2, 3) AND (ter_type_id = 1) AND (reg_id = '" . $catched . "')";
$pdo->select($sql);
$pdo = null;
$sql = null;