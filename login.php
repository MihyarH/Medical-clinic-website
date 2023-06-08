<?php
session_start();

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"]["user_type"] === "doctor") {
        header("Location: doctor_appointments.php");
        exit();
    } elseif ($_SESSION["user"]["user_type"] === "patient") {
        header("Location: patient_appointments.php");
        exit();
    }
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hostName = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "WDFP";
    $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
    if (!$conn) {
        die("Something went wrong");
    }

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($user) {
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user;

            if ($user["user_type"] === "doctor") {
                header("Location: doctor_appointments.php");
                exit();
            } elseif ($user["user_type"] === "patient") {
                header("Location: patient_appointments.php");
                exit();
            }
        } else {
            echo "<div class='alert alert-danger'>Invalid password</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid email</div>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div>
            <p>Not registered yet? <a href="registration.php">Register Here</a></p>
        </div>
    </div>
</body>
</html>
