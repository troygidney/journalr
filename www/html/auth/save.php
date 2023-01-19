<?php 
require_once '/var/www/html/vendor/autoload.php';
require '/var/www/php/auth/LoginService.php';
require '/var/www/php/auth/DataController.php';

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    http_response_code(403);
    exit;
}

session_start();

$client = new LoginService();
$client->validate();


$savedata = new DataController($_POST['data'], $client);
$savedata->saveData();




?>