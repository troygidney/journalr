<?php 
require_once './vendor/autoload.php';
require '/var/www/php/auth/LoginService.php';
require_once '/var/www/php/UserInfo.php';
require_once '/var/www/php/SQLDB.php';

use benhall14\phpCalendar\Calendar as Calendar;

session_start();

$client = new LoginService();
$client->validate();

date_default_timezone_set("America/Edmonton");

$sqldb = new SQLDB();

$google_info = new UserInfo($client, $sqld);


// $calendarId = 'primary';
// $optParams = array(
//   'maxResults' => 10,
//   'orderBy' => 'startTime',
//   'singleEvents' => TRUE,
//   'timeMin' => date('c'),
// );

// $service = new Google_Service_Calendar($client);
// $results = $service->events->listEvents($calendarId, $optParams);


$calendar = new Calendar();
$calendar->useMonthView();

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

    <script src='./assets/vendor/fullcalendar-6.0.2/dist/index.global.js'></script>

    <link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/litera/bootstrap.min.css">

    <script>

        var calendar;

        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendarVar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'MTC',
            initialView: 'dayGridMonth',
            editable: true,
            selectable: true,
            // height: (document.getElementById("sidebarWrapper").offsetHeight),
            contentHeight:"auto",
            headerToolbar: { center: 'dayGridMonth,timeGridWeek' }, // buttons for switching between views
        });
        
        calendarVar.render(); //Init render for calendar

        calendar = calendarVar;
        });

        // calendar.

    </script>

</head>

<body onload="load(this)">


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
                         Hello <?php echo $google_info->getName()?>, it is currently...
                    </div>
                    <div id="navDate" class="navDate">
                     </div>
               </div>
            </div>
            
            <a class="navAccount" onclick="calendar.render()" ><img class="navAccountImg" src="<?php echo $google_info->getPicture() ?>" referrerpolicy="no-referrer"></a>
        </div>
    </div>

    <div id="sidebar" class="sideBar sideBarHidden">
        <div id="sidebarWrapper" class="sideBarWrapper">
            
            <div id="calendar" class="calendarWrapper  fc fc-ltr fc-bootstrap4">
                
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

        resizeListener();
    }

    function resizeListener() {
     window.addEventListener("resize", (event) => {
          if (window.innerWidth <= 796 && document.getElementById("sidebar").classList.contains("sideBarChange")) {
               document.getElementById("main").classList.add("mainHidden");
               navToggle(document.getElementById("navHamburger"));
          } else {
            document.getElementById("main").classList.remove("mainHidden");
          }
          console.log(window.innerWidth);
     });
    }
    
    function navToggle(element) {
        element.classList.toggle("change");
        document.getElementById("sidebar").classList.toggle("sideBarChange");
        document.getElementById("sidebar").classList.toggle("sideBarHidden");

        document.getElementById("calendar").style.visability = "hidden";
        setTimeout(function() {
            document.getElementById("calendar").style.visability = "visible";
            console.log("render!");
                calendar.updateSize();
            }, 400); 

        if (window.innerWidth <= 796)
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





        ?>