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
$sql = "SELECT * FROM calendar WHERE end < '$currentDate' ORDER BY start ASC";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $counter=1;
    while ($row = mysqli_fetch_assoc($result)) {
        $row['serial']=$counter;
        $upcomingEvents[] = $row;
        $counter++;
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
    <link rel="stylesheet" href="finished.css">
</head>
<style>
  
</style>
<body>
<div class="sidebar">
<img src="hrt.png" alt="HRT Logo" class="logo">
        <a href="dashboard.php">Dashboard</a>
        <a href="calendar.php">Calendar</a>
        
       
    </div>


<div class="content">
<h2>Finished Events</h2>
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
