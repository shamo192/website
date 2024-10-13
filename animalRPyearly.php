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

// Query to fetch number of patients per month
$sql = "SELECT MONTH(date_returned) as month, COUNT(*) as count 
        FROM animal_bite_record 
        WHERE YEAR(date_returned) = YEAR(CURDATE()) 
        GROUP BY MONTH(date_returned)";

$result = $conn->query($sql);

// Prepare data points and initialize total counter
$dataPoints = array_fill(0, 12, ["y" => 0, "label" => ""]);
$totalBitesReturned = 0;

$months = [
    1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 
    6 => "June", 7 => "July", 8 => "August", 9 => "September", 
    10 => "October", 11 => "November", 12 => "December"
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $month = (int)$row['month'];
        $dataPoints[$month - 1] = ["y" => $row['count'], "label" => $months[$month]];
        $totalBitesReturned += $row['count']; // Sum total bites returned
    }
}

$conn->close();
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Bite Returns Over the Year</title>
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
                    text: "Returning of Animal Bites Over the Year"
                },
                axisY: {
                    title: "Number of animal bite returns",
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
        <a href="animal.php">&#9166; Back</a>
        <button onclick="printPage()">🖨 Print</button>
    </div>

    <div class="container">
        <!-- Display Total Bites Returned -->
        <div class="total-bites">
            Total Animal Bite Returns for the Year: <?php echo $totalBitesReturned; ?>
        </div>

        <!-- Chart Container -->
        <div id="chartContainer"></div>

        <!-- Table of Monthly Bites Returned -->
        <table class="table table-striped table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Month</th>
                    <th>Number of Patients</th>
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
