<?php 

require_once '/var/www/html/vendor/autoload.php';
include "/var/www/php/auth/LoginService.php";

session_start();

$client = new LoginService();
$client->heartbeat();

?>