<?php 
require_once './vendor/autoload.php';
require '../php/auth/LoginService.php';
require_once '../php/UserInfo.php';

use benhall14\phpCalendar\Calendar as Calendar;

session_start();

$client = new LoginService();
$client->validate();

$google_info = new UserInfo($client);

$calendarId = 'primary';
$optParams = array(
  'maxResults' => 10,
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
  'timeMin' => date('c'),
);

$service = new Google_Service_Calendar($client);
$results = $service->events->listEvents($calendarId, $optParams);

date_default_timezone_set("America/Edmonton");

$calendar = new Calendar();
$calendar->useWeekView();

// $events = $calendar->findEvents($running_day);

// print_r ($events);




// if (count($results->getItems()) == 0) {
//   print "No upcoming events found.\n";
// } else {
//   print "Upcoming events:\n";
//   foreach ($results->getItems() as $event) {
//     $start = $event->start->dateTime;
//     if (empty($start)) {
//       $start = $event->start->date;
//     }
//     printf("%s (%s)\n", $event->getSummary(), $start);
//   }
// }

// $gauth = new Google_Service_oauth2($client);
// $google_info = $gauth->userinfo->get();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Planner</title>
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

  <!-- <script type="text/javascript" src="config.js"></script> -->

    <!-- Main Quill library -->
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>

    <!-- Theme included stylesheets -->
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <!-- <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet"> -->

    <!-- Core build with no theme, formatting, non-essential modules -->
    <!-- <link href="assets/vendor/quill/quill.core.css" rel="stylesheet"> -->
    <!-- <script src="assets/vendor/quill/quill.core.js"></script> -->



</head>

<body onload="load(this)">


<div class="wrapper">

    <div class="nav">
         <div class="navWrapper">
            <div class="navHamburger" onclick="navToggle(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>            
            </div>
            
            <div>
              <div class="navDate">
                Hello <?php echo $google_info->getName()?>, it is currently...
              </div>
              <div id="navDate" class="navDate">

              </div>
            </div>
            
            <a class="navAccount" href="google.ca"><img class="navAccountImg" src="<?php echo $google_info->getPicture() ?>" referrerpolicy="no-referrer"></a>
        </div>
    </div>

    <div id="sidebar" class="sideBar sideBarHidden">
        <div class="sideBarWrapper">
            
            <div class="calendarWrapper">
                <?php  $calendar->display(); ?>
            </div>


        </div>
    </div>
    <div id="main" class="main" >
        <div class="mainWrapper">
            <div class="editor" id="editor">
                <!-- <textarea class="" cols="50000" maxlength="50000" wrap="hard" autofocus placeholder="Start Typing..."></textarea> -->
            </div>
            
        </div>
    </div>

</div>

</body>

  <script>

    function load(x) {

        setInterval(function() {
            var dateElement = document.getElementById("navDate");
            dateElement.innerText = new Intl.DateTimeFormat('en-CA', { dateStyle: 'full', timeStyle: 'long', timeZone: 'America/Edmonton' }).format(new Date().getTime());
        }, 1000);
    }
    
    function navToggle(element) {
        element.classList.toggle("change");
        document.getElementById("sidebar").classList.toggle("sideBarChange");
        document.getElementById("sidebar").classList.toggle("sideBarHidden");

        console.log(window.innerWidth);
        if (window.innerWidth <= 600)
          document.getElementById("main").classList.toggle("mainHidden");

    }

    var quill = new Quill('#editor', {
        // debug: 'info',
        placeholder: 'Start Typing...',
        scrollingContainer: '#editor',
        theme: 'snow'
    });
  </script>


<?php 

      // echo 'We are running PHP, version: '. phpversion(); 



      //  $database ="mydb";  
      //  $user = "root";  
      //  $password = "/run/secrets/db_root_password";  
      //  $host = "mysql";  

      //  $connection = new PDO("mysql:host={$host};dbname={$database};charset=utf8", $user, $password);  
      //  $query = $connection->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_TYPE='BASE TABLE'");  
      //  $tables = $query->fetchAll(PDO::FETCH_COLUMN);  

      //   if (empty($tables)) {
      //     echo "<p>There are no tables in database \"{$database}\".</p>";
      //   } else {
      //     echo "<p>Database \"{$database}\" has the following tables:</p>";
      //     echo "<ul>";
      //       foreach ($tables as $table) {
      //         echo "<li>{$table}</li>";
      //       }
      //     echo "</ul>";
      //   }

        ?>