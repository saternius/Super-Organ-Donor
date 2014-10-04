<?php
require "connection.php";
require "Server.php";

$server = new Server($db);
$server->calculateProxies();
?>