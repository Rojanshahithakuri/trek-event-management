<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'summer';

// Establish database connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$upcomingEvents = array();
$currentDate = date('Y-m-d H:i:s');
$sql = "SELECT * FROM calendar WHERE start <='$currentDate' and end>='$currentDate'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $counter = 1; // Initialize a counter variable
    while ($row = mysqli_fetch_assoc($result)) {
        $row['serial'] = $counter; // Assign serial number to the event
        $upcomingEvents[] = $row;
        $counter++; // Increment the counter
    }
}

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upcoming Events</title>
    <title>Hard Rock Treks & Expedition</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css"/>
    <link rel="stylesheet" href="ongoing.css">
</head>
<style>
    .sidebar .ongo{
    background-color:grey;
    border-radius:20px;
}
</style>
<body>
    <div class="sidebar">
        <h4><center><b>Menu</b></center></h4>
        <a href="dashboard.php">Dashboard</a>
        <a href="calendar.php">Calendar</a>
        <a href="events.php">Total Events</a>
        <a href="" class="ongo">Ongoing Events</a>
        <a href="upcoming.php">Upcoming Events</a>
        <a href="finished.php">Finished Events</a>
        <button class="addevent-button" onclick="openModal()">Add Event</button>
    </div>

    <h2>Ongoing Events</h2>
    <div class="content">
        <table>
            <tr>
                <th>S.N</th>
                <th>Destination</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Guests</th>
                <th>Guides</th>
                <th>Porter</th>
            </tr>
            <?php foreach ($upcomingEvents as $event): ?>
                <tr>
                    <td><?php echo $event['serial']; ?></td>
                    <td><?php echo $event['destination']; ?></td>
                    <td><?php echo $event['start']; ?></td>
                    <td><?php echo $event['end']; ?></td>
                    <td><?php echo $event['guests']; ?></td>
                    <td><?php echo $event['guide']; ?></td>
                    <td><?php echo $event['porter']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
