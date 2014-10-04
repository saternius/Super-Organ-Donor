<?php
require "connection.php";
require "Server.php";

$server = new Server($db);
header('Content-Type: application/json');

$longAndLats = $server->longAndLats();

//change to $numZombies
$arr = array('numZombies' => '1,337,900,142','lastKilled' => $lastKilled,'longAndLats' => $longAndLats);
echo json_encode($arr);
//
?>