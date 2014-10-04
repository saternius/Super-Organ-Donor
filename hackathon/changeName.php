<?php
require "connection.php";
require "Server.php";

$theName = $db->real_escape_string($_GET["name"]);
$theZombie = $db->real_escape_string($_GET["zombie"]);
$server = new Server($db);
//HOW TO CREATE A NEW ZOMBIE/INCREMENT A KILL 
//echo $server->createNewZombie(1);


//HOW TO ASSIGN A NAME TO A ZOMBIE
header('Content-Type: application/json');
$success = $server->assignName($theZombie,$theName);
$arr = array('status' => $success);
echo json_encode($arr);
//
?>