<?php
/*
These are the database login details
*/  

//The host for usual hosting.
#$HOST="mysql:host=localhost;dbname=user;charset=utf8";            
//The host for docker containers.
$HOST="mysql:host=mysql;dbname=user;charset=utf8";                 
//The database username. 
$USER="root";            
//The database password. 
$PASSWORD="1234";         

define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
 
//FOR DEVELOPMENT ONLY
define("SECURE", FALSE);    
?>