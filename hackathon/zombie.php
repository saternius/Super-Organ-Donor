<?php
require "connection.php";
require "Server.php";
$killer = $db->real_escape_string($_GET["killer"]);
$long = $db->real_escape_string($_GET["long"]);
$lat = $db->real_escape_string($_GET["lat"]);

$server = new Server($db);
$yourID = $server->createNewZombie($killer,$lat,$long);
$killerName = $server->getKillerName($yourID);

//incase you are double killed
$hasName = $server->hasName($yourID);

$arr = array('killerName' => $killerName, 'yourID' => $yourID, 'hasName' => $hasName);
header('Content-Type: application/json');
echo json_encode($arr);
?>