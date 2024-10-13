<?php
// Start the session at the beginning of the script
session_start();

// Check if the user is logged in and authorized as admin or standard
if (!isset($_SESSION['loggedin']) || !in_array($_SESSION['usertype'], ['admin', 'standard'])) {
    header('Location: login.php');
    exit();
}
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

// Initialize variables
$search = '';
$results = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['search'])) {
        $search = $conn->real_escape_string($_POST['search']);
        $sql = "SELECT * FROM out_patient_record 
                WHERE name LIKE '%$search%' 
                OR address LIKE '%$search%' 
                OR family_head LIKE '%$search%' 
                OR family_no LIKE '%$search%' 
                OR diagnosis LIKE '%$search%'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $results = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $results = [];
        }
    }

    // Logout process
    if (isset($_POST['logout'])) {
        if (isset($_SESSION['username'])) { // Check if the user is logged in
            $username = $_SESSION['username'];
            $usertype = $_SESSION['usertype'];
            $location = $_SESSION['location'];

            // Insert logout time into the database
            $logoutDate = date("Y-m-d");
            $logoutTime = date("H:i:s"); // 24-hour format

            // Action message based on user type
            $action = ($usertype === 'admin') ? "Admin Logout" : "Standard Logout";

            $insertLogoutSql = "INSERT INTO logs (username, location, usertype, date, time, action) VALUES (?, ?, ?, ?, ?, ?)";
            $insertLogoutStmt = $conn->prepare($insertLogoutSql);
            $insertLogoutStmt->bind_param("ssssss", $username, $location, $usertype, $logoutDate, $logoutTime, $action);

            if (!$insertLogoutStmt->execute()) {
                echo "Error logging logout: " . $insertLogoutStmt->error; // Debugging line
            }

            // Destroy the session
            session_unset();
            session_destroy();

            // Redirect to the login page after logout
            header("Location: Home.php");
            exit();
        } else {
            echo "No user is logged in."; // Debugging line
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Main Page</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto;
            display: block;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        @media screen and (max-width: 600px) {

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            tr {
                margin: 0 0 1rem 0;
                border-bottom: 1px solid #ddd;
                background-color: #f9f9f9;
            }

            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                white-space: nowrap;
            }

            td:before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 45%;
                padding-right: 10px;
                font-weight: bold;
                white-space: nowrap;
            }
        }

        @media screen and (min-width: 601px) {
            table {
                display: table;
            }

            th,
            td {
                display: table-cell;
            }
        }

        .icon-link {
            display: inline-block;
            /* Allows padding and margin to be applied */
            margin: 10px;
            /* Adds space between icons */
            padding: 10px;
            /* Increases the clickable area */
            border-radius: 5px;
            /* Rounds the corners */
            transition: background-color 0.3s ease;
            /* Smooth transition for hover effects */
        }

        .icon-link i {
            font-size: 24px;
            /* Increases the icon size */
            color: #1A4870;
            /* Sets a color for the icons */
        }

        .icon-link:hover {
            background-color: rgba(0, 123, 255, 0.1);
            /* Light background on hover */
        }

        .icon-link:hover i {
            color: #6A9C89;
            /* Darker color on hover */
        }

        .logo {
            padding: 20px;
            text-align: center;
            /* Centers the logo horizontally */
        }

        .logo img {
            max-width: 130px;
            /* Set a max-width for the logo */
            height: auto;
            /* Ensure it scales proportionally */
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.html">Burgos Municipality</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="confirmLogout()">Log out</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="logo">
                            <img src="logoofburgos.png" alt="Burgos municipality logo">
                        </div>
                        <a class="nav-link" href="OPD.php">OPD</a>
                        <a class="nav-link" href="animal.php">Animal Bites</a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">Reports for OPD</a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link" href="medicalcert.php">Medical Certificate</a>
                                <a class="nav-link" href="register.html">Referral Slip</a>
                                <a class="nav-link" href="npyearly.php">New patient yearly/Monthly report</a>
                                <a class="nav-link" href="rpyearly.php">Retreat patient yearly/Monthly report</a>
                                <a class="nav-link" href="diagnosischartOPD.php">Number of diagnosis yearly report</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in </div>
                    as Brgy Raniag:
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Barangay Raniag OPD</h1>

                    <!-- Search Form -->
                    <form method="POST" action="">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Search for patient..." aria-label="Search">
                            <button class="btn btn-primary" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>

                    <div class="card mb-4">
                        <?php if (!empty($results)) { ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Patient ID</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Family Head</th>
                                        <th>Family No.</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results as $row) { ?>
                                        <tr>
                                            <td data-label="Patient ID"><?php echo htmlspecialchars($row['patient_id']); ?></td>
                                            <td data-label="Name"><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td data-label="Address"><?php echo htmlspecialchars($row['address']); ?></td>
                                            <td data-label="Family Head"><?php echo htmlspecialchars($row['family_head']); ?></td>
                                            <td data-label="Family No."><?php echo htmlspecialchars($row['family_no']); ?></td>
                                            <td>
                                                <a href="print.php?patient_id=<?php echo urlencode($row['patient_id']); ?>" class="icon-link">
                                                    <i class="fa-solid fa-print"></i>
                                                </a>
                                                <a href="view.php?patient_id=<?php echo urlencode($row['patient_id']); ?>" class="icon-link">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p>No results found</p>
                        <?php } ?>
                    </div>
                </div>

                <form id="logoutForm" method="POST" style="display:none;">
                    <input type="hidden" name="logout" value="1">
                </form>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; 2024 Municipality of Burgos. All Rights Reserved.</div>
                        <div>
                            <h6> Programmed By: Erin Tuzon & Jayrus Luy </h6>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                document.getElementById('logoutForm').submit();
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>

