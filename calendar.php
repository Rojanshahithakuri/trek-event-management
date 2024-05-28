<?php
if(isset($_POST['submit'])){
    // Code to add a new event
    // Establish database connection
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'summer';
    $conn = mysqli_connect($host, $user, $pass, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $destination=$_POST["destination"];
    $guests=$_POST["guests"];
    $guide=$_POST["guide"];
    $porter=$_POST["porter"];
    $start=$_POST["start"];
    $end=$_POST["end"];

    $sql="INSERT INTO calendar(destination,guests,guide,porter,start,end)values('$destination','$guests','$guide','$porter','$start','$end')";
    mysqli_query($conn,$sql);
    echo('Event added successfully!');
    mysqli_close($conn);
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
            'id' => $row['ID'],
            'title' => $row['destination'],
            'start' => $row['start'],
            'end' => $row['end'],
            'guests' => $row['guests'],
            'guide' => $row['guide'],
            'porter' => $row['porter'],

        );
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hard Rock Treks & Expedition</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css"/>
    <link rel="stylesheet" href="calendar.css">
</head>
<style>
.update_btn{
background-color:#ebe9ef !important;
color:black;
}
.update_btn:hover{
background-color: blue !important;
color:white;
}
.delete_btn{
background-color:#ebe9ef !important;
color:black;
}
.delete_btn:hover{
background-color: red !important;
color:white;
}
.sidebar .cal{
    background-color:grey;
    border-radius:20px;
}
.sidebar{
    background-color:white;
}
</style>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4><center><b>Menu</b></center></h4>
        <a href="dashboard.php">Dashboard</a>
        <a href="calendar.php" class="cal">Calendar</a>
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
    </div>

    <!-- Modal for adding event -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Event no: <?php echo count($events) + 1; ?></h3>
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

    <!-- Modal for viewing and updating event details -->
    <div id="myModal2" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal2()">&times;</span>
            <h3>Event Details</h3>
            <table id="eventDetails" class="table">
               
                <tr>
                    <td><strong>ID:</strong></td>
                    <td id="ID"></td>
                </tr>
                <tr>
                    <td><strong>Destination:</strong></td>
                    <td id="destination2"></td>
                </tr>
                <tr>
                    <td><strong>Start Date:</strong></td>
                    <td id="start2"></td>
                </tr>
                <tr>
                    <td><strong>End Date:</strong></td>
                    <td id="end2"></td>
                </tr>
                <tr>
                    <td><strong>Total Guests:</strong></td>
                    <td id="guests2"></td>
                </tr>
                <tr>
                    <td><strong>Total Guide:</strong></td>
                    <td id="guide2"></td>
                </tr>
                <tr>
                    <td><strong>Total porter:</strong></td>
                    <td id="porter2"></td>
                </tr>
            </table>
            <div>
                <button id="updateButton" class="update_btn">Update</button>
                <button id="deleteButton" class="delete_btn">Delete</button>
            </div>
            <!-- Hidden update form -->
            <form id="updateForm" style="display:none;" action="update_event.php" method="POST">
                <input type="hidden" id="updateID" name="id">
                <label for="title">Destination:</label><br>
                <input type="text" id="updateDestination" name="destination"><br>
                <label for="guests">Total Guests:</label><br>
                <input type="number" id="updateGuests" name="guests"><br>
                <div class="guide-porter">
                    <div class="guide">
                        <label for="guide">Guide:</label><br>
                        <input type="number" id="updateGuide" name="guide" class="small-input"><br>
                    </div>
                    <div class="porter">
                        <label for="porter">Porter:</label><br>
                        <input type="number" id="updatePorter" name="porter" class="small-input"><br>
                    </div>
                </div>
                <label for="start">Start Date:</label><br>
                <input type="datetime-local" id="updateStart" name="start"><br>
                <label for="end">End Date:</label><br>
                <input type="datetime-local" id="updateEnd" name="end"><br><br>
                <input type="submit" value="Update">
            </form>
            <!-- Hidden delete form -->
            <form id="deleteForm" style="display:none;" action="delete_event.php" method="POST">
                <input type="hidden" id="deleteID" name="id">
                <input type="submit" value="Delete">
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script>
        // Open the modal when the Add Event button is clicked
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }

        // Close the modal when the close button or outside the modal is clicked
        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        // Open the modal for viewing event details
        function openModal2() {
            document.getElementById("myModal2").style.display = "block";
        }

        // Close the modal for viewing event details
        function closeModal2() {
            document.getElementById("myModal2").style.display = "none";
        }

        $(document).ready(function(){
            $('#calendar').fullCalendar({
                selectable:true,
                selectHelper:true,
                events: <?php echo json_encode($events); ?>,
                header:{
                    left:'month,agendaWeek,agendaDay,list',
                    center:'title',
                    right:'prev,today,next',
                },
                buttonText:{
                    today:'Today',
                    month:'Month',
                    week:'Week',
                    list:'List',
                    day:'Day'
                },
                dayRender: function(date, cell) {
                    var today = $.fullCalendar.moment();
                    if(date.get('date') == today.get('date')) {
                        cell.css("background", "lightgrey");
                    }
                },
                eventClick: function(event) {
                    $('#ID').text(event.id);
                    $('#destination2').text(event.title);
                    $('#start2').text(event.start.format('YYYY-MM-DD HH:mm'));
                    $('#end2').text(event.end.format('YYYY-MM-DD HH:mm'));
                    $('#guests2').text(event.guests);
                    $('#guide2').text(event.guide);
                    $('#porter2').text(event.porter);
                    openModal2();
                }
            });

            // Update button click handler
            $('#updateButton').click(function() {
                // Fill the update form with current event data
                $('#updateID').val($('#ID').text());
                $('#updateDestination').val($('#destination2').text());
                $('#updateGuests').val($('#guests2').text());
                $('#updateGuide').val($('#guide2').text());
                $('#updatePorter').val($('#porter2').text());
                $('#updateStart').val($('#start2').text().replace(' ', 'T'));
                $('#updateEnd').val($('#end2').text().replace(' ', 'T'));

                // Show the update form
                $('#updateForm').show();
            });

            // Delete button click handler
            $('#deleteButton').click(function() {
                // Show confirmation dialog
                var confirmDelete = confirm("Do you want to delete the event: " + $('#destination2').text() + "?");
                if (confirmDelete) {
                    // Fill the delete form with the event ID and submit it
                    $('#deleteID').val($('#ID').text());
                    $('#deleteForm').submit();
                }
            });
        });
    </script>
</body>
</html>
