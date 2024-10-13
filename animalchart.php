<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "root"; // Update with your actual password
$dbname = "prms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Specify the year to analyze
$currentYear = date("Y");

// Fetch animal bite mode data
$sql = "SELECT animal_bite_mode, COUNT(*) as count 
        FROM animal_bite_record 
        WHERE YEAR(date_added) = '$currentYear' 
        GROUP BY animal_bite_mode 
        ORDER BY count DESC";
$result = $conn->query($sql);

$dataPoints = array();
$totalBiteCases = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dataPoints[] = array("label" => $row['animal_bite_mode'], "y" => $row['count']);
        $totalBiteCases += $row['count'];
    }
}

$conn->close();
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Bite Mode Count for <?php echo $currentYear; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #F7F9F2;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #343A40;
            padding: 15px;
            display: flex;
            justify-content: space-between;
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
        .total-cases {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
        }
        #chartContainer {
            margin-top: 80px;
        }
        table {
            margin-top: 30px;
        }
    </style>

    <script>
        window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Animal Bite Mode Distribution for <?php echo $currentYear; ?>"
                },
                subtitles: [{
                    text: "Retrieved from Database"
                }],
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##0\" cases\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }

        function printPage() {
            window.print();
        }
    </script>
</head>
<body>
    <!-- Fixed Top Navbar -->
    <div class="navbar">
        <a href="animal.php">&#9166; Back</a>
        <button onclick="printPage()">🖨 Print</button>
    </div>

    <div class="container">
        <h1 class="mt-4 mb-4 text-center">Animal Bite Mode Count for <?php echo $currentYear; ?></h1>

        <!-- Total Animal Bite Cases -->
        <div class="total-cases text-center">
            Total Animal Bite Cases for <?php echo $currentYear; ?>: <?php echo $totalBiteCases; ?>
        </div>

        <!-- Chart Container -->
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

        <!-- Data Table -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Animal Bite Mode</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli($servername, $username, $password, $dbname);
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['animal_bite_mode']) . "</td>
                            <td>" . htmlspecialchars($row['count']) . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' class='text-center'>No data found for the year $currentYear</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
