<?php 
require_once '/var/www/html/vendor/autoload.php';
require '/var/www/php/auth/LoginService.php';
require '/var/www/php/auth/SaveData.php';


session_start();

$client = new LoginService();
$client->validate();


$savedata = new SaveData($_POST['data'], $client);
$savedata->saveData();




?>