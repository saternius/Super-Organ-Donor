<?php
require "connection.php";
require "Server.php";


$zombie = $db->real_escape_string($_GET["zombie"]);
$server = new Server($db);
header('Content-Type: application/json');

$server->focusZombie($zombie);
$name = $server->zombName();
$kills = $server->kills();
$proxy = $server->proxyKills();
$lastKilled = $server->zombLastKilled();
$longAndLats = $server->zombLongAndLats();
$proxyLnL = $server->zombProxyLnL();
$arr = array('name'=>$name,'kills' => $kills, 'proxyKills'=> $proxy, 'lastKilled' => $lastKilled,'longAndLats' => $longAndLats, 'proxyLnL' => $proxyLnL);
echo json_encode($arr);
//
?>