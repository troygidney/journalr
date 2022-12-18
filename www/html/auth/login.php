<?php 
 
require_once '../vendor/autoload.php';
session_start();
$file = fopen("/run/secrets/google_secret", "r", true) or die("Unable to open file!");
$clientSecret = fread($file,filesize("/run/secrets/google_secret"));
fclose($file);
$clientID = "703222469143-o0ovrj12j6h45ji87rqhs60pekqgl4cj.apps.googleusercontent.com";

$redirecturl = "http://localhost/auth/login.php";

//Making client request to google

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirecturl);
$client->addScope('profile');
$client->addScope('email'); // Todo look more into the scope definition

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    $gauth = new Google_Service_oauth2($client);
    $google_info = $gauth->userinfo->get();
    $email = $google_info->email;
    $name = $google_info->name;

    echo "Welcome ". $name. ". You are logged in with ". $email;
    $cereal = serialize($client);
    $_SESSION['client'] = $cereal;

} else {
    echo "<a href='".$client->createAuthUrl()."'>login with Google</a>";
} 







?>