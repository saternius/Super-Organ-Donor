<?php
require "connection.php";
require "Server.php";

$server = new Server($db);
//HOW TO CREATE A NEW ZOMBIE/INCREMENT A KILL 
//echo $server->createNewZombie(1);


//HOW TO ASSIGN A NAME TO A ZOMBIE
$zombie_index = 1;
$name = "BRUNO";
echo $server->assignName($zombie_index,$name);


//
?>