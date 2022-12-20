<?php 
 
require_once '../vendor/autoload.php';
require '../../php/auth/LoginService.php';

session_start();

$client = new LoginService();
$client->login();

?>