<?php
if(isset($_POST['submit'])){
    $destination=$_POST["destination"];
    $guests=$_POST["guests"];
    $guide=$_POST["guide"];
    $porter=$_POST["porter"];
    $start=$_POST["start"];
    $end=$_POST["end"];

    $host='localhost';
    $user='root';
    $pass='';
    $dbname='summer';

    $conn=mysqli_connect($host,$user,$pass,$dbname);
    $sql="INSERT INTO calendar(destination,guests,guide,porter,start,end)values('$destination','$guests','$guide','$porter','$start','$end')";
    mysqli_query($conn,$sql);
    echo('event added successfully!');
}
//fetch events from database;
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'summer';

$events = array(); // Define an empty array to hold events
$conn = mysqli_connect($host, $user, $pass, $dbname);
$sql = "SELECT * FROM calendar";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = array(
            'title' => $row['destination'],
            'start' => $row['start'],
            'end' => $row['end']
        );
    }
}
mysqli_close($conn);

// Function to count ongoing events
function countOngoingEvents($events) {
    $ongoingEvents = 0;
    $currentDate = date('Y-m-d H:i:s');

    foreach ($events as $event) {
        if ($event['start'] <= $currentDate && $event['end'] >= $currentDate) {
            $ongoingEvents++;
        }
    }

    return $ongoingEvents;
}

// Function to count upcoming events
function countUpcomingEvents($events) {
    $upcomingEvents = 0;
    $currentDate = date('Y-m-d H:i:s');

    foreach ($events as $event) {
        if ($event['start'] > $currentDate) {
            $upcomingEvents++;
        }
    }

    return $upcomingEvents;
}

function countFinishedEvents($events){
    $finishedEvents=0;
    $currentDate= date('Y-m-d H:i:s');

    foreach($events as $event){
        if ($event['end']<$currentDate){
            $finishedEvents++;
        }
    }
    return $finishedEvents;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Hard Rock Treks & Expedition</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css"/>
    <link rel="stylesheet" href="dashboard.css">
    <!-- Add your CSS and JavaScript links here -->

</head>
<body>
    <!-- Your HTML content here -->
    <div class="sidebar">
        <h4><center><b>Menu</b></center></h4>
        <a href="dashboard.php">Dashboard</a>
        <a href="calendar.php">Calendar</a>
        <a href="events.php">Total Events</a>
        <a href="ongoing.php">Ongoing Events</a>
        <a href="upcoming.php">Upcoming Events</a>
        <a href="finished.php">Finished Events</a>
        <button class="addevent-button" onclick="openModal()">Add Event</button>
    </div>

    <!-- Main content -->
    <div class="content">
        <h2 class="hello">Hard Rock Treks And Expedition</h2>
        <div id="calendar"></div>
        <div class="container">
              <div class="t-events">Total Events: <?php echo count($events); ?></div>
    <div class="o-events">Ongoing Events: <?php echo countOngoingEvents($events); ?></div>
    <div class="u-events">Upcoming Events: <?php echo countUpcomingEvents($events); ?></div>
    <div class="F-events">Finished Events: <?php echo countFinishedEvents($events)?></div>
    </div>
 
        </div>
      
    <!-- Modal for adding event -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Event no: <?php
            echo count($events)+1;
            ?></h3>
            <form id="eventForm" action="#" method="POST">
    <label for="title">Destination:</label><br>
    <input type="text" id="destination" name="destination"><br>
    <label for="guests">Total Guests:</label><br>
    <input type="number" name="guests"><br>
    <div class="guide-porter">
        <div class="guide">
            <label for="guide">Guide:</label><br>
            <input type="number" name="guide" class="small-input"><br>
        </div>
        <div class="porter">
            <label for="porter">Porter:</label><br>
            <input type="number" name="porter" class="small-input"><br>
        </div>
    </div>
    <label for="start">Start Date:</label><br>
    <input type="datetime-local" id="start" name="start"><br>
    <label for="end">End Date:</label><br>
    <input type="datetime-local" id="end" name="end"><br><br>
    <input type="submit" name="submit" value="Save">
</form>

        </div>
    </div>
    <script>
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }

        // Close the modal when the close button or outside the modal is clicked
        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }
    </script>
</body>
</html>
