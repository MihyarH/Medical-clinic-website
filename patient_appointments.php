<!-- patient_appointments.php -->

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION["user"]) || $_SESSION["user"]["user_type"] !== "patient") {
    header("Location: login.php");
    exit();
}

$patientName = $_SESSION["user"]["full_name"];

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "WDFP"; // Replace with your actual database name

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

// Fetch appointments for the logged-in patient
$sql = "SELECT * FROM appointments WHERE patient_name = '$patientName'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

$appointments = array();
while ($row = mysqli_fetch_assoc($result)) {
    $doctorName = $row["doctor_name"];
    $row["doctor_name"] = $doctorName;
    $appointments[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Appointments</title>
    <link rel="stylesheet" href="appointments.css">
</head>
<body>
<div class="container">
    <h1>Patient Appointments</h1>

    <h2>Welcome, <?php echo $_SESSION["user"]["full_name"]; ?>!</h2>
    <form method="POST" action="logout.php">
        <input id="logout" type="submit" value="Logout">
    </form>

    <table>
        <tr>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
        <?php foreach ($appointments as $appointment) { ?>
            <tr>
                <td><?php echo $appointment["doctor_name"]; ?></td>
                <td><?php echo $appointment["date"]; ?></td>
                <td><?php echo $appointment["time"]; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
