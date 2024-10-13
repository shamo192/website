<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "root";
$dbname = "prms";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch the number of patients per month
$sql = "SELECT MONTH(date_added) as month, COUNT(*) as count 
        FROM out_patient_record
        WHERE YEAR(date_added) = YEAR(CURDATE()) 
        GROUP BY MONTH(date_added)";

$result = $conn->query($sql);

// Prepare data points
$dataPoints = array_fill(0, 12, ["y" => 0, "label" => ""]);
$totalBites = 0; // Initialize total bites counter

$months = [
    1 => "January", 2 => "February", 3 => "March", 4 => "April",
    5 => "May", 6 => "June", 7 => "July", 8 => "August",
    9 => "September", 10 => "October", 11 => "November", 12 => "December"
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $month = (int)$row['month'];
        $dataPoints[$month - 1] = ["y" => $row['count'], "label" => $months[$month]];
        $totalBites += $row['count']; // Sum up the total bites
    }
}

$conn->close();
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Bites Over the Year</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #F7F9F2;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #343A40;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar a, .navbar button {
            color: white;
            font-size: 18px;
            text-decoration: none;
            border: none;
            background: none;
            cursor: pointer;
        }

        .navbar a:hover, .navbar button:hover {
            opacity: 0.8;
        }

        .container {
            margin-top: 100px; /* Space for navbar */
        }

        #chartContainer {
            height: 370px;
            width: 100%;
        }

        table {
            margin-top: 20px;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        .total-bites {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
    </style>

    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Out Patient Over the Year"
                },
                axisY: {
                    title: "Number of Out Patient",
                    minimum: 0,
                    maximum: 500,
                    interval: 50
                },
                data: [{
                    type: "line",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        };

        function printPage() {
            window.print();
        }
    </script>
</head>
<body>
    <!-- Fixed Navbar -->
    <div class="navbar">
        <a href="OPD.php">&#9166; Back</a>
        <button onclick="printPage()">🖨 Print</button>
    </div>

    <div class="container">
        <!-- Display Total Bites -->
        <div class="total-bites">
            Total Out Patient for the Year: <?php echo $totalBites; ?>
        </div>

        <!-- Chart Container -->
        <div id="chartContainer"></div>

        <!-- Table of Monthly Bites -->
        <table class="table table-striped table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Month</th>
                    <th>Number of Out Patient</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($months as $monthIndex => $monthName) {
                    echo "<tr>
                            <td>{$monthName}</td>
                            <td>{$dataPoints[$monthIndex - 1]['y']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
