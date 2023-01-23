<?php
require_once '/var/www/html/vendor/autoload.php';
require '/var/www/php/auth/LoginService.php';
require_once '/var/www/php/UserInfo.php';
require_once '/var/www/php/SQLDB.php';

use benhall14\phpCalendar\Calendar as Calendar;

session_start();

$client = new LoginService();
$client->validate();

date_default_timezone_set("America/Edmonton");

$sqldb = new SQLDB();

$google_info = new UserInfo($client);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Journalr</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="metro4:init" content="true">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">

    <script src='./assets/vendor/fullcalendar-6.0.2/dist/index.global.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@editorjs/header@latest'></script>
    <script src='https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest'></script>
    <script src='https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest'></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


    <script src="./assets/js/editor.js"></script>
    <script src="./assets/js/date.js"></script>
    <script src="./assets/js/main.js"></script>

    <link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/litera/bootstrap.min.css">

    <script>
    
    let editor;
    let calendar;

    
    </script>

</head>

<body onload="load().then((x) => {editor = x[0];calendar = x[1];});">


    <div class="wrapper">

        <div class="nav" style="z-index: 10;">
            <div class="navWrapper">
                <div id="navHamburger" class="navHamburger" onclick="navToggle(this)">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>

                <div>
                    <div>
                        <div class="navDate">
                            Hello <?php echo $google_info->getName() ?>, it is currently...
                        </div>
                        <div id="navDate" class="navDate">
                        </div>
                    </div>
                </div>

                <a class="navAccount" onclick="calendar.render()"><img class="navAccountImg" src="<?php echo $google_info->getPicture() ?>" referrerpolicy="no-referrer"></a>
            </div>
        </div>

        <div id="sidebar" class="sideBar sideBarHidden">
            <div id="sidebarWrapper" class="sideBarWrapper">

                <div id="calendar" class="calendarWrapper  fc fc-ltr fc-bootstrap4">

                </div>


            </div>
        </div>
        <div id="main" class="main">
            <div class="mainWrapper">
                <div class="editor" style="background-color: white;" id="editorjs">
                </div>

            </div>
        </div>

    </div>

</body>