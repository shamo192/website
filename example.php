<?php
session_start();



// Your page logic goes here


    // Database connection
    $con = mysqli_connect("localhost", "root", "root", "");

    // Check if connection is successful
    if(!$con) {
        echo "Database not connected";
    } 

    // Redirect to add.php when btn_add is clicked
    if (isset($_POST["btn_add"])) {
        echo "<script>window.location='bookadd.php'</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>books Information</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-image: url("");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            width: 250px;
            background-color: rgba(51, 51, 51, 0.5);
            padding-top: 60px;
            color: #fff;
            backdrop-filter: blur(5px);
            transition: width 0.3s ease;
        }

        .sidebar.show {
            width: 250px;
        }

        .sidebar.hide {
            width: 0;
        }

        .sidebar a {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
        }

        .sidebar a:hover {
            background-color: rgba(85, 85, 85, 0.5);
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        th {
            background-color: #4CAF50;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
            background-color: #d9ead3;
        }

        #sidebar img {
            width: 78%;
            display: block;
            margin: 18px auto;
            border-radius: 50%;
            border: 2px solid #222831;
        }

        /* Responsive layout */
        @media screen and (max-width: 768px) {
            .sidebar {
                width: 0;
                padding-top: 10px;
                height: auto;
                position: fixed;
                top: 60px;
                left: 0;
                z-index: 1000;
                overflow-x: hidden;
                transition: 0.5s;
            }

            .sidebar.show {
                width: 100%;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            #sidebar img {
                width: 50%;
            }
        }
		#add
		{
			width: 150px;
			height: 60px;
			position: fixed;
			bottom: 20px;
			right: 20px;
			border-radius: 20px;
			font-size: 20px;
		}
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <img src="logoofburgos.png" alt="Your Image">
        <a href="home.php">Home</a>
		<a href="useracc.php">User Account</a>
        <a href="studinfo.php">Student Information</a>
		<a href="#">Book Information</a>

    </div>

    <!-- Sidebar toggle button -->
    <button class="btn btn-dark d-lg-none" id="sidebarToggle">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid mt-5">
            <h1 class="text-center mb-4">BOOKS INFORMATION</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Year Published</th>
                            <th>Status</th>
							<th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                         <?php
                                    $sql = "SELECT * FROM bookinfo";
                                    $result = mysqli_query($con, $sql);
                                    while ($record = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $record["id"] . "</td>";
                                        echo "<td>" . $record["title"] . "</td>";
                                        echo "<td>" . $record["description"] . "</td>";
                                        echo "<td>" . $record["author"] . "</td>";
                                        echo "<td>" . $record["publisher"] . "</td>";
                                        echo "<td>" . $record["year_published"] . "</td>";
                                        echo "<td>" . $record["status"] . "</td>";
                                       echo "<td>
                                                <a href='bookdelete.php?id=" . $record["id"] . "' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this book?')\">Delete</a>
                                                <a href='bookedit.php?id=" . $record["id"] . "' class='btn btn-primary'>Edit</a>
                                            </td>";
                                        echo "</tr>";
                                    }
                                ?>
                    </tbody>
                </table>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <form method="post">
                          <button type="submit" id="add" name="btn_add" class="btn btn-success btn-block">Add Book</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toggle sidebar script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('#sidebarToggle').addEventListener('click', function () {
                document.querySelector('#sidebar').classList.toggle('show');
            });
        });
    </script>
</body>
</html>



