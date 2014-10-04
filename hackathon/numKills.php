<?php
require "connection.php";
require "Server.php";

$server = new Server($db);
header('Content-Type: application/json');

$numZombies = $server->numZombies();
$lastKilled = $server->lastKilled();

//change to $numZombies
$arr = array('numZombies' => $numZombies,'lastKilled' => $lastKilled);
echo json_encode($arr);
//
?>