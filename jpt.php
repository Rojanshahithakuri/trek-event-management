<?php
if(isset($_POST['submit'])){
    $destination = $_POST["destination"];
    $guests = $_POST["guests"];
    $guide = $_POST["guide"];
    $porter = $_POST["porter"];
    $start = $_POST["start"];
    $end = $_POST["end"];
    $season = $_POST["season"];

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'summer';

    $conn = mysqli_connect($host, $user, $pass, $dbname);
    $sql = "INSERT INTO calendar (destination, guests, guide, porter, start, end, season) VALUES ('$destination', '$guests', '$guide', '$porter', '$start', '$end', '$season')";
    mysqli_query($conn, $sql);
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
<body>
    <!-- Sidebar -->
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
        <div>
            <label for="season-select">Select Season:</label>
            <select id="season-select">
                <option value="all">All</option>
                <option value="spring">Spring</option>
                <option value="summer">Summer</option>
                <option value="fall">Fall</option>
                <option value="winter">Winter</option>
            </select>
        </div>
        <div id="calendar"></div>
    </div>

    <!-- Modal for adding event -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Event no: <?php echo count($events) + 1; ?></h3>
            <!-- Form for adding event -->
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
                <input type="datetime-local" id="end" name="end"><br>
                <label for="season">Season:</label><br>
                <select id="season" name="season">
                    <option value="spring">Spring</option>
                    <option value="summer">Summer</option>
                    <option value="fall">Fall</option>
                    <option value="winter">Winter</option>
                </select><br><br>
                <input type="submit" name="submit" value="Save">
            </form>
        </div>
    </div>

    <!-- Modal for event details -->
    <div id="myModal2" class="modal">
        <!-- Modal content -->
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
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script>
    var events = <?php echo json_encode($events); ?>;

    // Open the modal when the Add Event button is clicked
    function openModal() {
        document.getElementById("myModal").style.display = "block";
    }

    // Close the modal when the close button or outside the modal is clicked
    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }

    // Open the modal for event details
    function openModal2() {
        document.getElementById("myModal2").style.display = "block";
    }

    // Close the modal for event details
    function closeModal2() {
        document.getElementById("myModal2").style.display = "none";
    }

    // Function to filter events based on selected season and get the start date
    function filterEvents(season) {
        if (season === 'all') {
            return { filteredEvents: events, startDate: null };
        } else {
            var filteredEvents = events.filter(event => event.season === season);
            var startDate = filteredEvents.length > 0 ? filteredEvents[0].start : null;
            return { filteredEvents: filteredEvents, startDate: startDate };
        }
    }

    $(document).ready(function() {
        $('#calendar').fullCalendar({
            selectable: true,
            selectHelper: true,
            events: filterEvents('all').filteredEvents, // Initially show all events
            header: {
                left: 'month,agendaWeek,agendaDay,list',
                center: 'title',
                right: 'prev,today,next',
            },
            buttonText: {
                today: 'Today',
                month: 'Month',
                week: 'Week',
                list: 'List',
                day: 'Day'
            },
            dayRender: function(date, cell) {
                var today = $.fullCalendar.moment();
                if (date.get('date') === today.get('date')) {
                    cell.css("background", "lightgrey");
                }
            },
            eventClick: function(event) {
                $('#ID').text(event.id);
                $('#destination2').text(event.title);
                $('#start2').text(event.start.format('YYYY-MM-DD HH:mm'));
                $('#end2').text(event.end.format('YYYY-MM-DD HH:mm'));
                openModal2();
            }
        });

        // Handle season selection
        $('#season-select').on('change', function() {
            var selectedSeason = $(this).val();
            var result = filterEvents(selectedSeason);
            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('addEventSource', result.filteredEvents);
            if (result.startDate) {
                $('#calendar').fullCalendar('gotoDate', result.startDate);
            }
        });
    });
</script>

</body>
</html>
