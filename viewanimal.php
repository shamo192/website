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

// Check if the bite_id is set in the URL
if (isset($_GET['bite_id'])) {
    $bite_id = $conn->real_escape_string($_GET['bite_id']); // Store bite_id in $bite_id

    // Query to fetch the patient data
    $sql = "SELECT * FROM animal_bite_record WHERE bite_id = '$bite_id'"; // Use $bite_id in the query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger text-center'>No patient found with ID: $bite_id</div>"; // Use $bite_id here
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
            max-width: 1100px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-align: center;
        }
        .table th, .table td {
            font-size: 1.25rem;
        }
        .row div.table {
            margin-bottom: 20px;
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
        <div class="row">
            <!-- First column -->
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Patient Name</th>
                        <td><?php echo htmlspecialchars($patient['patient_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?php echo htmlspecialchars($patient['address']); ?></td>
                    </tr>
                    <tr>
                        <th>Contact No.</th>
                        <td><?php echo htmlspecialchars($patient['contact_no']); ?></td>
                    </tr>
                    <tr>
                        <th>Sex</th>
                        <td><?php echo htmlspecialchars($patient['sex']); ?></td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td><?php echo htmlspecialchars($patient['age']); ?></td>
                    </tr>
                    <tr>
                        <th>Birthdate</th>
                        <td><?php echo htmlspecialchars($patient['birthdate']); ?></td>
                    </tr>
                    <tr>
                        <th>Birth Place</th>
                        <td><?php echo htmlspecialchars($patient['birth_place']); ?></td>
                    </tr>
                    <tr>
                        <th>Occupation</th>
                        <td><?php echo htmlspecialchars($patient['occupation']); ?></td>
                    </tr>
                    <tr>
                        <th>Nationality</th>
                        <td><?php echo htmlspecialchars($patient['nationality']); ?></td>
                    </tr>
                    <tr>
                        <th>Religion</th>
                        <td><?php echo htmlspecialchars($patient['religion']); ?></td>
                    </tr>
                    <tr>
                        <th>Guardian</th>
                        <td><?php echo htmlspecialchars($patient['guardian']); ?></td>
                    </tr>
                    <tr>
                        <th>Guardian-Patient Relation</th>
                        <td><?php echo htmlspecialchars($patient['guardian_patient_relation']); ?></td>
                    </tr>
                    <tr>
                        <th>Guardian Address</th>
                        <td><?php echo htmlspecialchars($patient['guardian_address']); ?></td>
                    </tr>
                    <tr>
                        <th>Date & Time of Treatment</th>
                        <td><?php echo htmlspecialchars($patient['date_time_treatment']); ?></td>
                    </tr>
                </table>
            </div>

            <!-- Second column -->
            <div class="col-md-6">
                <table class="table table-bordered">
                   
                    <tr>
                        <th>Date of Exposure</th>
                        <td><?php echo htmlspecialchars($patient['date_exposure']); ?></td>
                    </tr>
                    <tr>
                        <th>Weight</th>
                        <td><?php echo htmlspecialchars($patient['weight']); ?></td>
                    </tr>
                    <tr>
                        <th>Blood Pressure</th>
                        <td><?php echo htmlspecialchars($patient['blood_pressure']); ?></td>
                    </tr>
                    <tr>
                        <th>Temperature</th>
                        <td><?php echo htmlspecialchars($patient['temp']); ?></td>
                    </tr>
                    <tr>
                        <th>BPM</th>
                        <td><?php echo htmlspecialchars($patient['bpm']); ?></td>
                    </tr>
                    <tr>
                        <th>CPM</th>
                        <td><?php echo htmlspecialchars($patient['cpm']); ?></td>
                    </tr>
                    <tr>
                        <th>Past Medical History</th>
                        <td><?php echo htmlspecialchars($patient['past_medical_history']); ?></td>
                    </tr>
                    <tr>
                        <th>Animal Bite Mode</th>
                        <td><?php echo htmlspecialchars($patient['animal_bite_mode']); ?></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td><?php echo htmlspecialchars($patient['category']); ?></td>
                    </tr>
                    <tr>
                        <th>Chief Complaints</th>
                        <td><?php echo htmlspecialchars($patient['chief_complaints']); ?></td>
                    </tr>
                    <tr>
                        <th>Civil Status</th>
                        <td><?php echo htmlspecialchars($patient['civil_status']); ?></td>
                    </tr>
                    <tr>
                        <th>Date Added</th>
                        <td><?php echo htmlspecialchars($patient['date_added']); ?></td>
                    </tr>
                    <tr>
                        <th>Date Edited</th>
                        <td><?php echo htmlspecialchars($patient['date_edited']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php } else { ?>
            <p class="alert alert-danger">Patient details not found.</p>
        <?php } ?>
    </div>
    <div class="print-btn">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </button>
    </div>

    <a class="back-button" href="animal.php">&#9166</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>
</html>
