<?php
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

// Check if eventId is set and not empty
if (isset($_POST['eventId']) && !empty($_POST['eventId'])) {
    $eventId = $_POST['eventId'];

    // SQL to delete event
    $sql = "DELETE FROM calendar WHERE id = $eventId";

    if (mysqli_query($conn, $sql)) {
        echo "Event deleted successfully!";
    } else {
        echo "Error deleting event: " . mysqli_error($conn);
    }
} else {
    echo "Event ID is not set or empty.";
}

mysqli_close($conn);
?>
