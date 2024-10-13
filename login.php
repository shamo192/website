<?php
// Start or resume session
session_start();

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    $usertype = $_SESSION["usertype"];
    if ($usertype == 'admin') {
        header("location: .php");
    } elseif ($usertype == 'standard') {
        header("location: OPD.php");
    }
    exit();
}


// Lockout configuration
define('MAX_ATTEMPTS', 3);
define('LOCKOUT_TIME', 30); // in seconds

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    $usertype = $_SESSION["usertype"];
    if ($usertype == 'admin') {
        header("location: .php");
    } elseif ($usertype == 'standard') {
        header("location: OPD.php");
    }
    exit();
}

// Initialize session variables for tracking login attempts
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
    $_SESSION['lockout_time'] = 0;
}

// Message variable
$message = "";
$disabled = false; // Input fields disabled flag
$remaining_time = 0; // Remaining time for lockout

// Database configuration
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "prms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to log messages
function logMessage($conn, $username, $location, $usertype, $action) {
    $sql = "INSERT INTO logs (username, location, usertype, date, time, action) VALUES (?, ?, ?, CURDATE(), CURTIME(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $location, $usertype, $action);
    $stmt->execute();
    $stmt->close();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the user is locked out
    if ($_SESSION['attempts'] >= MAX_ATTEMPTS) {
        $time_since_lockout = time() - $_SESSION['lockout_time'];
        if ($time_since_lockout < LOCKOUT_TIME) {
            $remaining_time = LOCKOUT_TIME - $time_since_lockout;
            $message = "Too many failed attempts. Please wait for $remaining_time seconds.";
            $disabled = true; // Lock input fields
        } else {
            // Reset attempts after lockout time has expired
            $_SESSION['attempts'] = 0;
            $_SESSION['lockout_time'] = 0; // Reset lockout time
        }
    }

    // Validate if username and password are provided
    if (empty($username) || empty($password)) {
        $message = "Please provide both username and password.";
    } else {
        // Validate credentials against the database
        $sql = "SELECT * FROM accounts WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Reset attempts on successful login
            $_SESSION['attempts'] = 0;

            // Get user details
            $row = $result->fetch_assoc();
            $userType = $row['usertype'];
            $location = $row['location'];
            
            // Start session
            $_SESSION['loggedin'] = true;
            $_SESSION['usertype'] = $userType;
            $_SESSION['username'] = $username;
            $_SESSION['location'] = $location;

            // Log successful login
            $message = "Login successful!";
            echo '<script>alert("'.$message.'"); window.location.href="OPD.php";</script>';
            exit();
        } else {
            // Increment attempts and set lockout time if max attempts reached
            $_SESSION['attempts']++;
            if ($_SESSION['attempts'] >= MAX_ATTEMPTS) {
                $_SESSION['lockout_time'] = time();
                $message = "Too many failed attempts. Please wait for " . LOCKOUT_TIME . " seconds.";
                $disabled = true; // Lock input fields
                $remaining_time = LOCKOUT_TIME; // Set remaining time for the countdown
            } else {
                $message = "Invalid username or password. Please try again.";
            }
            // Log failed login attempt
            logMessage($conn, $username, "", "", "failed");
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url("Burgos.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .login-title {
            font-size: 24px;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-control {
            border-radius: 20px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .btn-custom {
            background-color: #007bff;
            border: none;
            border-radius: 20px;
            padding: 10px;
            color: white;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .alert {
            margin-top: 20px;
        }
        
        .countdown {
            font-size: 20px;
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
    <script>
        function startLockoutTimer(seconds) {
            const inputFields = document.getElementById("loginForm").querySelectorAll(".form-control, .btn-custom");
            const countdownDisplay = document.getElementById("countdown");

            let countdown = seconds;
            inputFields.forEach(input => input.disabled = true);

            const interval = setInterval(() => {
                countdownDisplay.textContent = `Please wait for ${countdown} seconds.`;
                
                if (countdown <= 0) {
                    clearInterval(interval);
                    inputFields.forEach(input => input.disabled = false);
                    countdownDisplay.textContent = ""; // Clear the countdown display
                }
                countdown--;
            }, 1000);
        }
    </script>
</head>
<body>

<div class="login-container">
    <div class="login-title">Patient Record Management System</div>
    <?php if ($message): ?>
        <div class="alert alert-warning" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <form id="loginForm" method="POST" action="">
        <input type="text" id="username" name="username" class="form-control" placeholder="Username" required <?php echo $disabled ? 'disabled' : ''; ?>>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required <?php echo $disabled ? 'disabled' : ''; ?>>
        <button type="submit" class="btn btn-custom" <?php echo $disabled ? 'disabled' : ''; ?>>Login</button>
    </form>
    <div id="countdown" class="countdown"></div>
    <div class="footer">
        © 2024 Your Company. All rights reserved.
        <h6>Programmed By: Erin Tuzon & Jayrus Luy</h6>
    </div>
</div>

<script>
    <?php if ($disabled): ?>
        startLockoutTimer(<?php echo $remaining_time; ?>);
    <?php endif; ?>
</script>

</body>
</html>
