<?php 
 
require_once '../vendor/autoload.php';
require '/var/www/php/auth/LoginService.php';

session_start();

$client = new LoginService();
$client->login();

?>