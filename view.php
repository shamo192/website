<?php

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "root"; // Replace with your database password
$dbname = "prms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variable
$patient = null;

// Check if the patient_id is set in the URL
if (isset($_GET['patient_id'])) {
    $patient_id = $conn->real_escape_string($_GET['patient_id']);

    // Query to fetch the patient data
    $sql = "SELECT * FROM out_patient_record WHERE patient_id = '$patient_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger text-center'>No patient found with ID: $patient_id</div>";
    }
} else {
    echo "<div class='alert alert-warning text-center'>No patient ID provided.</div>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Patient Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #CCD5AE;
        }
        .container {
            max-width: 900px;
            height: 800px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 30px;
        }
        .table th, .table td {
            font-size: 1.25rem;
            text-align: center;
        }
        .table th {
            width: 300px;
        }
        .print-btn {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        .print-btn button {
            font-size: 1.25rem;
            padding: 10px 20px;
            border-radius: 5px;
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
    <div class="container">
        <h1 class="mt-4 mb-4">Patient Details</h1>

        <?php if ($patient) { ?>
            <table class="table table-bordered">
                <tr>
                    <th>Patient ID</th>
                    <td><?php echo htmlspecialchars($patient['patient_id']); ?></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?php echo htmlspecialchars($patient['name']); ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo htmlspecialchars($patient['address']); ?></td>
                </tr>
                <tr>
                    <th>Family Head</th>
                    <td><?php echo htmlspecialchars($patient['family_head']); ?></td>
                </tr>
                <tr>
                    <th>Family No.</th>
                    <td><?php echo htmlspecialchars($patient['family_no']); ?></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><?php echo htmlspecialchars($patient['age']); ?></td>
                </tr>
                <tr>
                    <th>Sex</th>
                    <td><?php echo htmlspecialchars($patient['sex']); ?></td>
                </tr>
                <tr>
                    <th>Birthdate</th>
                    <td><?php echo htmlspecialchars($patient['birthdate']); ?></td>
                </tr>
                <tr>
                    <th>Diagnosis</th>
                    <td><?php echo htmlspecialchars($patient['diagnosis']); ?></td>
                </tr>
                <tr>
                    <th>Services Rendered</th>
                    <td><?php echo htmlspecialchars($patient['services_rendered']); ?></td>
                </tr>
            </table>
        <?php } else { ?>
            <p class="alert alert-danger">Patient details not found.</p>
        <?php } ?>
    </div>
    <div class="print-btn">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </button>
    </div>

    <a class="back-button" href="OPD.php">&#9166</a>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>
</html>
