<?php 
 
require_once '../vendor/autoload.php';
require './LoginService.php';

session_start();

$client = new LoginService();
$client->login();

?>