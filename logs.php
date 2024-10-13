<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Logout History</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
			background-color: #DAD3BE;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
			text-align: center;
            margin-top: 0;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        .back-button {
            top: 10px;
            left: 10px;
        }
        .back-button {
            position: fixed;
            display: inline-block;
            padding: 15px 30px;
            font-size: 18px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>SYSTEM LOGS</h1>
    <div class="main-content">
        <div class="container">
            <div class="history-container">
                <?php
                $host = 'localhost';
                $user = 'root';
                $password = 'root';
                $database = 'prms';

                $conn = new mysqli($host, $user, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql_login = "SELECT username, location, usertype, date, time, action FROM logs";
                $result_login = $conn->query($sql_login);

                if ($result_login->num_rows > 0) {
                    echo "<h2>Login History</h2>";
                    echo "<table>";
                    echo "<tr><th>Username</th><th>Location</th><th>User Type</th><th>Date</th><th>Time</th><th>Action</th></tr>";
                    while ($row = $result_login->fetch_assoc()) {
                        echo "<tr><td>" . htmlspecialchars($row["username"]) . "</td><td>" . htmlspecialchars($row["location"]) . "</td><td>" . htmlspecialchars($row["usertype"]) . "</td><td>" . htmlspecialchars($row["date"]) . "</td><td>" . htmlspecialchars($row["time"]) . "</td><td>" . htmlspecialchars($row["action"]) . "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No login history found</p>";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <a class="back-button" href="OPD.php">&#9166</a>

</body>
</html>
