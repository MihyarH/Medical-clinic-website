<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION["user"]) || $_SESSION["user"]["user_type"] !== "doctor") {
    header("Location: login.php");
    exit();
}

$doctorId = $_SESSION["user"]["id"];

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "WDFP"; // Replace with your actual database name

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

$appointmentId = $_POST["appointmentId"];

// Retrieve the appointment details
$sql = "SELECT * FROM appointments WHERE id = '$appointmentId'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Appointment not found!";
    exit();
}

$appointment = mysqli_fetch_assoc($result);

// Handle form submission for updating the appointment
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["updateAppointment"])) {
    $patient = $_POST["patient"];
    $date = $_POST["date"];
    $time = $_POST["time"];

    $updateSql = "UPDATE appointments SET patient_name = '$patient', date = '$date', time = '$time' WHERE id = '$appointmentId'";
    $updateResult = mysqli_query($conn, $updateSql);

    if ($updateResult) {
        echo "Appointment updated successfully!";
        header("Location: doctor_appointments.php");
        exit();
    } else {
        echo "Error updating appointment: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Appointment</title>
    <link rel="stylesheet" href="Appoint.css">
</head>
<body>
    <h1>Edit Appointment</h1>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="appointmentId" value="<?php echo $appointmentId; ?>">
        <label>Patient:</label>
        <input type="text" name="patient" value="<?php echo $appointment["patient_name"]; ?>" required>
        <br>
        <label>Date:</label>
        <input type="date" name="date" value="<?php echo $appointment["date"]; ?>" required>
        <br>
        <label>Time:</label>
        <input type="time" name="time" value="<?php echo $appointment["time"]; ?>" required>
        <br>
        <input type="submit" name="updateAppointment" value="Update Appointment">
    </form>
</body>
</html>
