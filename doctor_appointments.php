

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
$dbName = "WDFP"; 

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

// Function to fetch patient email based on the patient name
function getPatientEmail($conn, $patientName) {
    $sql = "SELECT email FROM Users WHERE user_type = 'patient' AND full_name = '$patientName'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row["email"];
    } else {
        return null;
    }
}

// Fetch patient names from the Users table
$patientsSql = "SELECT full_name FROM Users WHERE user_type = 'patient'";
$patientsResult = mysqli_query($conn, $patientsSql);
if (!$patientsResult) {
    die("Error executing query: " . mysqli_error($conn));
}

$patients = array();
while ($patient = mysqli_fetch_assoc($patientsResult)) {
    $patients[] = $patient;
}

// Function to fetch appointments for a doctor
function fetchAppointments($conn, $doctorId) {
    $appointments = array();

    $sql = "SELECT * FROM appointments WHERE doctor_name = '$doctorId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $appointments[] = $row;
        }
    } else {
        die("Error executing query: " . mysqli_error($conn));
    }

    return $appointments;
}

// Query appointments table to retrieve appointments for the logged-in doctor
$appointments = fetchAppointments($conn, $doctorId);

// Handle form submission for adding an appointment
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["addAppointment"])) {
    $patientName = $_POST["patient"];
    $email = getPatientEmail($conn, $patientName);
    $date = $_POST["date"];
    $time = $_POST["time"];

    addAppointment($conn, $doctorId, $patientName, $email, $date, $time);
}

// Function to add a new appointment
function addAppointment($conn, $doctorId, $patientName, $email, $date, $time) {
    $insertSql = "INSERT INTO appointments (doctor_name, patient_name, email, date, time) 
                  VALUES ('$doctorId', '$patientName', '$email', '$date', '$time')";
    $insertResult = mysqli_query($conn, $insertSql);

    if ($insertResult) {
        echo "Appointment added successfully!";
        header("Location: doctor_appointments.php");
        exit();
    } else {
        echo "Error adding appointment: " . mysqli_error($conn);
    }
}

// Handle form submission for removing an appointment
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["removeAppointment"])) {
    $appointmentId = $_POST["appointmentId"];
    removeAppointment($conn, $appointmentId);
}

// Function to remove an appointment
function removeAppointment($conn, $appointmentId) {
    $deleteSql = "DELETE FROM appointments WHERE id = '$appointmentId'";
    $deleteResult = mysqli_query($conn, $deleteSql);

    if ($deleteResult) {
        echo "Appointment removed successfully!";
        header("Location: doctor_appointments.php");
        exit();
    } else {
        echo "Error removing appointment: " . mysqli_error($conn);
    }
}

// Handle form submission for updating an appointment
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["updateAppointment"])) {
    $appointmentId = $_POST["appointmentId"];
    $patientName = $_POST["patient"];
    $email = getPatientEmail($conn, $patientName);
    $date = $_POST["date"];
    $time = $_POST["time"];

    updateAppointment($conn, $appointmentId, $patientName, $email, $date, $time);
}

// Function to update an appointment
function updateAppointment($conn, $appointmentId, $patientName, $email, $date, $time) {
    $updateSql = "UPDATE appointments SET patient_name = '$patientName', email = '$email', date = '$date', time = '$time' WHERE id = '$appointmentId'";
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
    <title>Doctor Appointments</title>
    <style>
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
        }

        @media (max-width: 400px) {
            h1 {
                font-size: 24px;
            }

            h2 {
                font-size: 18px;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 5px;
            }

            .dropbtn, .editBtn {
                padding: 5px;
                font-size: 12px;
            }
        }
        body {
            font-family: Monospace,Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
        }
        #logout{
            position: relative;
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: 12px;
            margin-left: 75%;
    }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: 12px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content form {
            padding: 10px;
        }

        .dropdown-content label, .dropdown-content input, .dropdown-content select {
            display: block;
            margin-bottom: 10px;
        }

        .dropdown-content input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 12px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .editBtn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding:  10px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 12px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Doctor Appointments</h1>

    <h2>Welcome, <?php echo $_SESSION["user"]["full_name"]; ?>!</h2>
    <form method="POST" action="logout.php">
            <input id="logout" type="submit" value="Logout">
        </form>
    <div class="dropdown">
        <button class="dropbtn">Add Appointment</button>
        <div class="dropdown-content">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="patient">Patient:</label>
                <select id="patient" name="patient" required>
                    <?php foreach ($patients as $patient) { ?>
                        <option value="<?php echo $patient['full_name']; ?>"><?php echo $patient['full_name']; ?></option>
                    <?php } ?>
                </select>
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>
                <input type="submit" name="addAppointment" value="Submit">
            </form>
        </div>
    </div>

    <table>
        <tr>
            <th>Patient</th>
            <th>Email</th>
            <th>Date</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($appointments as $appointment) { ?>
            <tr>
                <td><?php echo $appointment["patient_name"]; ?></td>
                <td><?php echo $appointment["email"]; ?></td>
                <td><?php echo $appointment["date"]; ?></td>
                <td><?php echo $appointment["time"]; ?></td>
                <td>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="dropdown">
                            <button class="editBtn">Edit</button>
                            <div class="dropdown-content">
                                <input type="hidden" name="appointmentId" value="<?php echo $appointment['id']; ?>">
                                <label for="patient">Patient:</label>
                                <select id="patient" name="patient" required>
                                    <?php foreach ($patients as $patient) { ?>
                                        <option value="<?php echo $patient['full_name']; ?>" <?php if ($patient['full_name'] === $appointment['patient_name']) echo "selected"; ?>><?php echo $patient['full_name']; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="date">Date:</label>
                                <input type="date" id="date" name="date" value="<?php echo $appointment['date']; ?>" required>
                                <label for="time">Time:</label>
                                <input type="time" id="time" name="time" value="<?php echo $appointment['time']; ?>" required>
                                <input type="submit" name="updateAppointment" value="Update">
                            </div>
                        </div>
                        <input type="hidden" name="appointmentId" value="<?php echo $appointment['id']; ?>">
                        <input type="submit" class = "dropbtn" name="removeAppointment" value="Remove">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
